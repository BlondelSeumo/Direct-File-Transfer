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

# PHP Mailer SDK - Required to send emails
require_once __DIR__ . '/../vendor/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../vendor/PHPMailer/SMTP.php';
require_once __DIR__ . '/../vendor/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {


	private $_config;
	private $_db = null;


	public function __construct() {

		$this->_db = DB::getInstance();
		$data = $this->_db->get('configs', array('id', '=', 1));

		if ($data->count()) {
			$this->_config = $data->first();
		}

	}


	/**
	*
	* Main send email method form frontend
	* @param email from, email to, file quantity, links
	* @return status message
	*
	*/
	public function sendEmail($emailFrom, $emailTo, $emailMessage, $fileQuantity, $links) {


		# PHPMailer Object
		$mail = new PHPMailer(); 

		# Server settings
	    $mail->isSMTP(); 
	    $mail->Host       = $this->_config->smtp_host;                    // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = $this->_config->email_login;                     // SMTP username
	    $mail->Password   = $this->_config->email_password;                               // SMTP password
	    $mail->SMTPSecure = $this->_config->smtp_encryption;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port       = $this->_config->smtp_port; 


		#From email address and name
		$mail->From = $emailFrom;

		if (!empty($this->_config->from_name)) {
			$mail->FromName = $this->_config->from_name;
		} else {
			$mail->FromName = "Full Name";
		}
		

		# Add email to addresses
		$addresses = explode(',', $emailTo);
		foreach ($addresses as $address) {
    		$mail->addAddress($address);
		}


		# Address to which recipient will reply
		if(!empty($this->_config->from_email)) {
			$mail->addReplyTo($this->_config->from_email);
		} else {
			$mail->addReplyTo($emailFrom);
		}
		

		# Add Email CC 
		if(!empty($this->_config->email_cc)) {
			$mail->addCC($this->_config->email_cc);
		} else {
			$mail->addCC($emailFrom);
		}
		

		# Include Email From and File Quantity Details, and also Title
		$content = "<html><body style='margin:0; padding:5rem; background-color:#f5f5f5;'>
						<div style='width:600px; min-width:600px; margin: 2rem auto; padding: 3rem; background-color:#FFFFFF; border-top: 7px solid #0e2e40;'>
							<h2 style='color:#0e2e40;text-align:center;font-weight:800; font-size:16px; margin-bottom:1rem;'>Upload & Share</h2>
							<h2 style='color:#0e2e40;text-align:center;font-weight:600; font-size:14px;'>" . $emailFrom . "</h2>
							<h2 style='color:#0e2e40;text-align:center;font-weight:600; font-size:12px; border-bottom: 1px solid #e1dfdd; padding-bottom:2rem;'>Has transfered you some files to download</h2>
							
							<table style='border: none; border-collapse: collapse;'>
								<tr><td style='line-height:70px; width:100%;'><strong>Total shared files: </strong>" . $fileQuantity . "</td></tr>";

		# Include File Names and Downlaod Links
		$all_links = explode(';', $links);
		foreach ($all_links as $link) {

			$file_details = explode(',', $link);
			if(strlen($file_details[0]) > 1) {
				$content .= "<tr><td><strong>File name: </strong>" . $file_details[0] . "</td></tr>
							<tr><td style='padding-bottom:3rem;'><strong>Download link: </strong><a href='" . $file_details[1] . "' >Start Downloading</a></td></tr>"; 
			}   		
		}
		
		# If there was a Message sent with Email, inlcude it as well
		if($emailMessage != "") {
			$content .= "<tr><td style='width:100%;'><strong>Sender message: </strong>" . $emailMessage . "</td></tr>";
		}
		
		# Include closing HTML Tags
		$content .= "</table>
					 <h2 style='color:#0e2e40;font-family: Arial, Helvetica, sans-serif;text-align:center;font-weight:600; font-size:14px;'>Thank you for using our service</h2>
					 </div></body></html>";


		# Send HTML or Plain Text email
		$mail->isHTML(true);

		$mail->Subject = "Upload & Share File Transfer";
		$mail->Body = $content;
		//$mail->AltBody = $content;

		return $mail->send();
		   
	}


	/**
	*
	* Email all download links from admin panel
	* @param email to, subject, message, links
	* @return bool status
	*
	*/
	public function emailLinks($emailTo, $subject = null, $message = null, $links) {

		# PHPMailer Object
		$mail = new PHPMailer(); //Argument true in constructor enables exceptions

		# Server settings
	    $mail->isSMTP();                                            		// Send using SMTP
	    $mail->Host       = $this->_config->smtp_host;                    	// Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   		// Enable SMTP authentication
	    $mail->Username   = $this->_config->email_login;                    // SMTP username
	    $mail->Password   = $this->_config->email_password;                 // SMTP password
	    $mail->SMTPSecure = $this->_config->smtp_encryption;          		// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port       = $this->_config->smtp_port; 


	    #From email address and name
		$mail->From = $this->_config->email_login;

		$mail->addAddress($emailTo);

		if (isset($subject)) {
			$mail->Subject = $subject;
		} else {
			$mail->Subject = 'Upload & Share File Transfer';
		}


		# Include Email From and File Quantity Details, and also Title
		$content = "<html><body style='margin:0; padding:5rem; background-color:#f5f5f5;'>
						<div style='width:600px; min-width:600px; margin: 2rem auto; padding: 3rem; background-color:#FFFFFF; border-top: 7px solid #0e2e40;'>
							<h2 style='color:#0e2e40;text-align:center;font-weight:800; font-size:16px; margin-bottom:1rem;'>Upload & Share</h2>
							<h2 style='color:#0e2e40;text-align:center;font-weight:600; font-size:14px;'>" . $this->_config->email_login . "</h2>
							<h2 style='color:#0e2e40;text-align:center;font-weight:600; font-size:12px; border-bottom: 1px solid #e1dfdd; padding-bottom:2rem;'>Has transfered you some files to download</h2>
							
							<table style='border: none; border-collapse: collapse;'>";

		# Include File Names and Downlaod Links
		foreach ($links as $key => $value) {

				$content .= "<tr><td><strong>File name: </strong>" . $key . "</td></tr>
							<tr><td style='padding-bottom:3rem;'><strong>Download link: </strong><a href='" . $value . "' >Start Downloading</a></td></tr>"; 
			 		
		}
		
		# If there was a Message sent with Email, inlcude it as well
		if($message != "") {
			$content .= "<tr><td style='width:100%;'><strong>Sender message: </strong>" . $message . "</td></tr>";
		}
		
		# Include closing HTML Tags
		$content .= "</table>
					 <h2 style='color:#0e2e40;font-family: Arial, Helvetica, sans-serif;text-align:center;font-weight:600; font-size:14px;'>Thank you for using our service</h2>
					 </div></body></html>";
					 

		# Send HTML or Plain Text email
		$mail->isHTML(true);
		
		$mail->Body = $content;

		return $mail->send();

	}		


	/**
	*
	* Test email method
	* @param email to, test subject, test message
	* @return bool status
	*
	*/
	public function testEmail($emailTo, $subject = null, $message = null) {

		# PHPMailer Object
		$mail = new PHPMailer(); //Argument true in constructor enables exceptions

		# Server settings
	    $mail->isSMTP();                                            // Send using SMTP
	    $mail->Host       = $this->_config->smtp_host;                    // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = $this->_config->email_login;                     // SMTP username
	    $mail->Password   = $this->_config->email_password;                               // SMTP password
	    $mail->SMTPSecure = $this->_config->smtp_encryption;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port       = $this->_config->smtp_port; 


	    #From email address and name
		$mail->From = $this->_config->email_login;

		$mail->addAddress($emailTo);

		if (isset($subject)) {
			$mail->Subject = $subject;
		} else {
			$mail->Subject = 'Test Subject';
		}

		if (isset($message)) {
			$mail->Body = $message;
		} else {
			$mail->Body = 'Test Body';
		}

		return $mail->send();

	}

}