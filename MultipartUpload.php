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

# AWS PHP SDK - Required to run AWS APIs
require_once 'admin/classes/Wasabi.class.php';
require_once 'admin/classes/Email.class.php';

# Initiate S3 and Email classes
$s3 = new Wasabi();
$email = new Email();


# Check if File XHR Input was set
if (isset($_POST['input'])) {


		# Function Name that will be Called
		$input = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_STRING);
		

		# =================================================
		#  Set FilePond Sizes/File Types/Quantities
		# =================================================
		if ($input == "set_upload_settings") {

			$result = $s3->getUploadSettings();

			# Return XHR reponse as JSON
		 	json_output($result);

		}



		# =================================================
		#  Initiate MultiPart Uploaded
		# =================================================
		if ($input == "create") {

			# XHR input variables
			$fileInfo = filter_input(INPUT_POST, 'fileInfo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

			$result = $s3->initiateMultipartUploader($fileInfo['name'], $fileInfo['type']);

			# Return XHR reponse as JSON
		 	json_output($result);

		}



		# =================================================
		#  Create UploadPart Link for each file chunk
		# =================================================
		if ($input == "part") {

			# XHR input variables
			$inputData = filter_input(INPUT_POST, 'sendBackData', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
			$partNumber = filter_input(INPUT_POST, 'partNumber', FILTER_SANITIZE_NUMBER_INT);
			$contentLength = filter_input(INPUT_POST, 'contentLength', FILTER_SANITIZE_NUMBER_FLOAT);

			$result = $s3->createUploadPartLinks($inputData['key'], $inputData['uploadId'], $partNumber, $contentLength);

			# Return XHR reponse as JSON
			json_output($result);
	        
		} 



		# ===============================================================================
		#  Complete Multipart Upload (list and combine parts)
		# ===============================================================================
		if ($input == "complete") {

			# XHR input variables
			$inputData = filter_input(INPUT_POST, 'sendBackData', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
			$fileData = filter_input(INPUT_POST, 'fileTableData', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

		 	$result = $s3->completeMultipartUploader($inputData['key'], $inputData['uploadId']);

		 	$s3->recordToFilesTableDB($fileData['name'], $fileData['type'], $fileData['size'], $fileData['sharetype']);

	       									
	        # Return XHR reponse as JSON
	        json_output($result);

		}



		# =================================================
		#  Get Private Link
		# =================================================
		if($input == "private") {

			# XHR input variables
			$inputData = filter_input(INPUT_POST, 'sendBackData', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
			$timer = filter_input(INPUT_POST, 'timer', FILTER_SANITIZE_NUMBER_INT);
        	
        	$result = $s3->getPrivateLink($inputData['key'], $timer);

			# Return XHR reponse as JSON
			json_output($result);

		}



		# =================================================
		#  Get Public Link
		# =================================================
		if($input == "public") {

			# XHR input variables
			$inputData = filter_input(INPUT_POST, 'sendBackData', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        	
        	# Return uploaded S3 object
			$result = $s3->getPublicLink($inputData['key']);

			# Return XHR reponse as JSON
			json_output($result);

		}



		# ==================================================================
		#  In case if cancelled or error occured, abort multiupload 
		# =================================================================
		if ($input == "abort") {

			$inputData = filter_input(INPUT_POST, 'sendBackData', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

			$result = $s3->cancelMultipartUploader($inputData['key'], $inputData['uploadId']);

			# Return XHR reponse as JSON
	        json_output($result);

		}



		# ==================================================================
		#  DB Record of Shared Data
		# =================================================================
		if ($input == "database") {

			$sharesData = filter_input(INPUT_POST, 'sharesTableData', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

			$s3->recordToSharesTableDB($sharesData['sharetype'], $sharesData['filequantity'], $sharesData['filenames'], $sharesData['senderemail'], $sharesData['receiveremail'], $sharesData['message'], $sharesData['privatelink'], $sharesData['expirationtime']);

		}



		# ==================================================================
		#  DB Record of Dashboard Data
		# =================================================================
		if ($input == "dashboard") {

			$dashboardData = filter_input(INPUT_POST, 'dashboardData', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

			$s3->recordToDashboardTableDB($dashboardData['totalUploads'], $dashboardData['emailsSent'], $dashboardData['linksCreated']);

		}



		# ==================================================================
		#  Send Links via Email
		# =================================================================
		if ($input == "email") {

			$emailData = filter_input(INPUT_POST, 'emailData', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
			$links = filter_input(INPUT_POST, 'links', FILTER_SANITIZE_STRING);

			$result = $email->sendEmail($emailData['emailFrom'], $emailData['emailTo'], $emailData['emailMessage'], $emailData['filequantity'], $links);

			# Return XHR reponse as JSON
	        json_output($result);

		}

}


# ==================================================================
# 	JSON Output to XHE request
# ==================================================================
function json_output($data) {

    header('Content-Type: application/json');

    die(json_encode($data));

}


