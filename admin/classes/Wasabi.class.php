<?php

/*==========================================================================
 * Copyright (c) 2020
 * =========================================================================
 * 
 *
 * Project: Upload & Share
 * Author: Berkine 
 * Version: 1.0.0
 * 
 * 
 * =========================================================================
 */

# Core Initialization File
require_once __DIR__ . '/../core/init.core.php';

# AWS PHP SDK - Required to run AWS APIs
require_once __DIR__ . '/../vendor/aws/autoload.php';



# AWS Namespaces
use Aws\S3\S3Client;   
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;
use Aws\Exception\AwsException;
use Aws\Exception\CredentialsException;


class Wasabi {

	private $_s3;					# Wasabi S3 Client
	private $_config;				# Parameters from config.php
	private $_private_url;			# Private Signed file link
	private $_public_url;			# Public file link
	private $_db = null;			# DB Instance
	private $_email;				# Email class instance


	/**
	*
	* Wasabi Class Contructor 
	* Set private variables: $s3; $config;
	*
	*/
	public function __construct() {

		# Wasabi Access Key Parameters
		$this->_db = DB::getInstance();
		$data = $this->_db->get('configs', array('id', '=', 1));

		if ($data->count()) {
			$this->_config = $data->first();
		}

		$email = new Email();
		$this->_email = $email;

		/*========================================================================== 
		 * Initializing Amazon s3 client and pass S3 parameters 
		 * S3 Bucket must be in the same AWS Region where Amazon Transcribe is used
		 *==========================================================================*/
		$s3 = new Aws\S3\S3Client([
		 	'credentials' => [													
	        	'key'    => $this->_config->access_key,						
	        	'secret' => $this->_config->secret_access_key,			
	    	],
	    	'endpoint' => "https://s3." . $this->_config->region . ".wasabisys.com",
			'version' => 'latest',	
			'signature_version' => 'v4',	
			'region'  => $this->_config->region
		]);

		$this->_s3 = $s3;

	}


	/**
	*
	* Initiate MultiPart Uploaded
	* @param - File Metadata
	* @return - MultiPart UploadID and Key(object) Name
	*
	*/
	public function initiateMultipartUploader($fileName, $fileType) {

		$s3_result = $this->_s3->createMultipartUpload([
				'Bucket' => $this->_config->bucket_name,				# Bucket Name
				'Key' => "{$fileName}",									# S3 Object Name
				'StorageClass' => 'STANDARD',  							# S3 Storage Type - Can be one of the follwoing: STANDARD|REDUCED_REDUNDANCY|STANDARD_IA|ONEZONE_IA|INTELLIGENT_TIERING
				'ACL' => 'public-read', 								# S3 Object Access Control List - Can be one of the following: private|public-read|public-read-write|authenticated-read|aws-exec-read|bucket-owner-read|bucket-owner-full-control
				'ContentDisposition' => 'attachment',					# Allows you to download the file without opening it in the browser
        		'ContentType' => "{$fileType}"							# File format
		]);

		$output = array();
		$output['uploadId'] = $s3_result->get('UploadId');
		$output['key'] = $s3_result->get('Key');

		return $output;

	}


	/**
	*
	* Create UploadPart Link for each file chunk
	* @param - User inputData and contentLength, partNumber
	* @return - partNumber and it's associated url
	*
	*/
	public function createUploadPartLinks($key, $uploadId, $partNumber, $contentLength) {

		$s3_result = $this->_s3->getCommand('UploadPart', array(		
				'Bucket' => $this->_config->bucket_name,				# Bucket Name
        		'Key' => "{$key}",									# File Name in S3
	            'UploadId' => "{$uploadId}",						# Multipart Upload ID
	            'PartNumber' => $partNumber,								# Part Number of the chunk
	            'ContentLength' => $contentLength							# Size of the chunk that will be uploaded
		));

		#Give it at least 24 hours for large chunk uploads
		$request = $this->_s3->createPresignedRequest($s3_result,"+24 hours");

		$output = array();
		$output['partnumber'] = $partNumber;
		$output['url'] = (string)$request->getUri();

		return $output;

	}


	/**
	*
	* Complete Multipart Upload (list and combine parts)
	* @param - User inputData and contentLength, partNumber
	* @return - completion status code
	*
	*/
	public function completeMultipartUploader($key, $uploadId) {

		$listParts = $this->_s3->listParts([
        			'Bucket' => $this->_config->bucket_name,
        			'Key' => "{$key}",
        			'UploadId' => "{$uploadId}"
        ]);


        $s3_result = $this->_s3->completeMultipartUpload([
		            'Bucket' => $this->_config->bucket_name,
		            'Key' => "{$key}",
		            'UploadId' => "{$uploadId}",
		            'MultipartUpload' => [
		            	"Parts"=>$listParts["Parts"],
            ]
        ]);

		$output = array();
		$output['status'] = $s3_result['@metadata']['statusCode'];

		return $output;
		
	}


	/**
	*
	* Get Private Signed Download Link
	* @param - User inputData and link duration
	* @return - Signed private link with timer
	*
	*/
	public function getPrivateLink($key, $timer) {

        # Return uploaded S3 object
		$s3_object = $this->_s3 -> getCommand('GetObject',[
			'Bucket' => $this->_config->bucket_name,
			'Key' => "{$key}",
		]);
		

		# Create S3 Object Presigned Private URL with expiration time
		$presigned_url = $this->_s3->createPresignedRequest($s3_object , strtotime($timer . ' hours'));


		# Return URL of the S3 Object with Presigned Private URL
		$_private_url = (string)$presigned_url->getUri();


		$output = array();
		$output['private-link'] = $_private_url;
		$output['key'] = $key;

		return $output;
		
	}


	/**
	*
	* Get Public Download Link
	* @param - User inputData 
	* @return - public link
	*
	*/
	public function getPublicLink($key) {

        # Return uploaded S3 object
		$_public_url = $this->_s3 ->getObjectUrl($this->_config->bucket_name, $key);


		$output = array();
		$output['public-link'] = $_public_url;
		$output['key'] = $key;

		return $output;
		
	}

	public function getAllLinks() {
		return $this->_file_links;
	}


	/**
	*
	* In case if cancelled, abort multiupload 
	* @param - User inputData 
	* @return - status code
	*
	*/
	public function cancelMultipartUploader($key, $uploadId) {

       	$s3_result = $this->_s3->abortMultipartUpload([
	            'Bucket' => $this->_config->bucket_name,
	            'Key' => "{$key}",
	            'UploadId' => "{$uploadId}"
        ]);


		$output = array();
		$output['status'] = $s3_result;

		return $output;
		
	}


	/**
	*
	* Record data to the File Table Database
	* @param - File Metadata
	*
	*/
	public function recordToFilesTableDB($key, $filetype, $size_bytes, $sharetype) {

		# Data Table Shares record
		$data = array(
					'filename' => $key,
					'filetype' => $filetype,
					'size' => $size_bytes,
					'sharetype' => $sharetype,
					'uploaddate' => date('Y-m-d')						
					);

		$this->_db->insert('data_table_files', $data);


		# Data Upload Traffic record
		$data_uploads = array('file_size' => $size_bytes, 'upload_date' => date('Y-m-d'));
		$this->_db->insert('data_upload_traffic', $data_uploads);


		# Dashboard Data record
		$data_dashboard = $this->_db->get('data_dashboard', array('id', '=', 1))->first();
		$total_bucket_size = $data_dashboard->total_bucket_size + $size_bytes;
		$data_dashboard_total = array('total_bucket_size' => $total_bucket_size);
		$this->_db->update('data_dashboard', 1, $data_dashboard_total);

	}


	/**
	*
	* Record data to the Shares Table Database
	* @param - User inputData 
	*
	*/
	public function recordToSharesTableDB($sharetype, $filequantity, $filenames, $senderemail, $receiveremail, $message, $privatelink, $expirationtime) {

		if ($privatelink == 'Yes') {
			$validUntil = date("Y-m-d H:i:s", strtotime("+{$expirationtime} hours"));
		} else {
			$validUntil = ' ';
		}
		
		# Data Table Shares record
		$data = array(
					'sharetype' => $sharetype,
					'filequantity' => $filequantity,
					'filenames' => $filenames,
					'senderemail' => $senderemail,
					'receiveremail' => $receiveremail,
					'message' => $message,
					'privatelink' => $privatelink,
					'expirationtime' => $validUntil,
					'uploaddate' => date('Y-m-d h:i:s')						
					);

		$this->_db->insert('data_table_shares', $data);


		# Data Upload Files record
		$data_uploads = array('total_files' => $filequantity, 'upload_date' => date('Y-m-d'));
		$this->_db->insert('data_upload_files', $data_uploads);

	}


	/**
	*
	* Record data to the Dashboard Table Database
	* @param - User inputData 
	*
	*/
	public function recordToDashboardTableDB($total_uploads, $emails_sent, $links_created) {

		$data = $this->_db->get('data_dashboard', array('id', '=', 1))->first();
		
		$total_uploads_sum = $data->total_uploads + $total_uploads;
		$emails_sent_sum = $data->emails_sent + $emails_sent;
		$links_created_sum = $data->links_created + $links_created;
		
		$input = array(
					'total_uploads' => $total_uploads_sum,
					'emails_sent' => $emails_sent_sum,
					'links_created' => $links_created_sum,					
					);

		$this->_db->update('data_dashboard', 1, $input);

	}


	/**
	*
	* Get Upload Settings from Upload_Settings table
	* @return - max file size and max file quantities
	*
	*/
	public function getUploadSettings() {

		$data = $this->_db->get('upload_settings', array('id', '=', 1))->first();

		return array(
					'maxSize' => $data->max_size,
					'maxQuantity' => $data->max_quantity,
					'fileType' => $data->file_type,
				);

	}


	/**
	*
	* Get File Download Link (Admin Panel)
	* @param - file id in DB
	* @return - file link
	*
	*/
	public function getFileLink($id) {

		$data = $this->_db->get('data_table_files', array('id', '=', $id))->first();
		$result = $this->_s3->getObjectUrl($this->_config->bucket_name, $data->filename);

		return $result;

	}


	/**
	*
	* Get All File Download Links (Admin Panel)
	* @param - file id in DB
	* @return - file link
	*
	*/
	public function getAllFileLinks($ids) {

		$idsList = explode(',', $ids);
		$counter = 0;
		$results = [];

		foreach ($idsList as $id) {

			$data = $this->_db->get('data_table_files', array('id', '=', $id))->first();
			$result = $this->_s3->getObjectUrl($this->_config->bucket_name, $data->filename);
			$results[$counter] = $result;
			$counter++;
		}

		return $results;

	}


	/**
	*
	* Email Download Link (Admin Panel)
	* @param - file id in DB
	* @return - file link
	*
	*/
	public function emailDownloadLink($id, $emailTo, $subject = null, $message = null) {

		$results = [];

		$data = $this->_db->get('data_table_files', array('id', '=', $id))->first();
		$result = $this->_s3->getObjectUrl($this->_config->bucket_name, $data->filename);
		$results[$data->filename] = $result;
		$status = $this->_email->emailLinks($emailTo, $subject, $message, $results);

		return $status;

	}


	/**
	*
	* Email All Download Links (Admin Panel)
	* @param - file id in DB
	* @return - file link
	*
	*/
	public function emailAllDownloadLinks($ids, $emailTo, $subject = null, $message = null) {

		
		$idsList = explode(',', $ids);
		$results = [];
		
		foreach ($idsList as $id) {

			$data = $this->_db->get('data_table_files', array('id', '=', $id))->first();
			$result = $this->_s3->getObjectUrl($this->_config->bucket_name, $data->filename);
			$results[$data->filename] = $result;

		}

		$status = $this->_email->emailLinks($emailTo, $subject, $message, $results);

		return $status;

	}


	/**
	*
	* Delete File (Admin Panel)
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function deleteFile($id) {

		$data = $this->_db->get('data_table_files', array('id', '=', $id))->first();

		# Dashboard Data record
		$data_dashboard = $this->_db->get('data_dashboard', array('id', '=', 1))->first();
		$total_bucket_size = $data_dashboard->total_bucket_size - $data->size;
		$data_dashboard_total = array('total_bucket_size' => $total_bucket_size);

		$this->_db->update('data_dashboard', 1, $data_dashboard_total);

		# Delete the file in S3 and in DB
		$result = $this->_s3->deleteObject([
					'Bucket' => $this->_config->bucket_name, 
					'Key' => $data->filename
				]);

		$this->_db->delete('data_table_files', array('id', '=', $id));

	}


	/**
	*
	* Delete All Files (Admin Panel)
	* @param - file id in DB
	* @return - confirmation
	*
	*/
	public function deleteAllFiles($ids) {

		# Add email to addresses
		$idsList = explode(',', $ids);
		foreach ($idsList as $id) {

			$data = $this->_db->get('data_table_files', array('id', '=', $id))->first();

			# Dashboard Data record
			$data_dashboard = $this->_db->get('data_dashboard', array('id', '=', 1))->first();
			$total_bucket_size = $data_dashboard->total_bucket_size - $data->size;
			$data_dashboard_total = array('total_bucket_size' => $total_bucket_size);

			$this->_db->update('data_dashboard', 1, $data_dashboard_total);

			# Delete the file in S3 and in DB
			$result = $this->_s3->deleteObject([
						'Bucket' => $this->_config->bucket_name, 
						'Key' => $data->filename
					]);

			$this->_db->delete('data_table_files', array('id', '=', $id));

		}

	}

}
	




	
