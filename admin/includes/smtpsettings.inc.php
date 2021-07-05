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

# Check if user is looged
if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

# Check if form fields are filled and csrf token exists
if (Input::exists()) {
	if (Token::check(Input::get('csrf_token'))) {
		
		# Validate form input data
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'smtp_host' => array(
				'required' => true,
			), 
			'smtp_port' => array(
				'required' => true,
			),
			'email_login' => array(
				'required' => true,
			),
			'email_password' => array(
				'required' => true,
			)
		)); 

		# If validation passed update the db table
		if ($validation->passed()) {

			# Initilize DB Class
			$_db = DB::getInstance();

			try {

				# Returns true if update was successful, false otherwise
				$status = $_db->update('configs', 1, array(
					'smtp_host' => Input::get('smtp_host'),
					'smtp_port' => Input::get('smtp_port'),
					'smtp_encryption' => Input::get('smtp_encryption'),
					'email_login' => Input::get('email_login'),
					'email_password' => Input::get('email_password'),
					'from_email' => Input::get('from_email'),
					'from_name' => Input::get('from_name'),
					'email_cc' => Input::get('email_cc'),
				));

				# Send flash message based on the db update results
				if ($status) {
					Session::flash('smtp-success', 'SMTP settings have been updated successfully.');
					Redirect::to('../pages/settings/smtp.page.php');
				} else {
					Session::flash('smtp-error', 'SMTP settings update failed, try again.');
					Redirect::to('../pages/settings/smtp.page.php');
				}				

			} catch(Exception $e) {
				Session::flash('smtp-error', 'SMTP settings update failed, try again.');
				Redirect::to('../pages/settings/smtp.page.php');
			}


		} else {

			# If there were form valication errors, send error messages
			$errorMessages;

			foreach ($validation->errors() as $error) {
				$errorMessages .= $error . '<br>';
			}

			Session::flash('smtp-error', $errorMessages);
			Redirect::to('../pages/settings/smtp.page.php');
		}
	} 
}

