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

$user = new User();
$email = new Email();

# Check if user is looged
if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

# Check if form fields are filled 
if (Input::exists()) {
	
	# Validate form input data	
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'test_email' => array(
			'required' => true,
		), 
	)); 

	# If validation passed send sample email
	if ($validation->passed()) {
		
		# Initilize email fields
		$emailTo = Input::get('test_email');
		$subject = Input::get('test_subject');
		$message = Input::get('test_message');

		# Call testEmail method
		$status = $email->testEmail($emailTo, $subject, $message);

		# Send update status based on testEmail method return value
		if ($status) {
			Session::flash('smtp-test-success', 'Email has been send successfully.');
			Redirect::to('../pages/settings/smtp.page.php');
		} else {
			Session::flash('smtp-test-error', 'There was an error with email sending.');
			Redirect::to('../pages/settings/smtp.page.php');
		}			

	} else {

		# If there were form valication errors, send error messages
		$errorMessages;

		foreach ($validation->errors() as $error) {
			$errorMessages .= $error . '<br>';
		}

		Session::flash('smtp-test-error', $errorMessages);
		Redirect::to('../pages/settings/smtp.page.php');
	}
}

