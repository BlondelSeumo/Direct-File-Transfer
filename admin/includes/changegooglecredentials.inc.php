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

# Check if user is logged in
if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

# Check if form fields are filled and csrf token exists
if (Input::exists()) {
	if (Token::check(Input::get('csrf_token'))) {
		
		# Validate form input data
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			 'analytics-id' => array(
			 	'required' => true,
			 ), 
			 'google-maps' => array(
			 	'required' => true,
			 )
		)); 

		# If validation passed update the db table
		if ($validation->passed()) {

			# Initilize DB Class
			$_db = DB::getInstance();

			try {

				# Returns true if update was successful, false otherwise
				$status = $_db->update('configs_google', 1, array(
					'analytics_id' => Input::get('analytics-id'),
					'maps_key' => Input::get('google-maps'),
				));

				# Upload credentials file to ./core directory
				if(isset($_FILES["file"])) {
					$extension = explode('.', $_FILES['file']['name']);
					$new_name = 'service-account-credentials.' . $extension[1];
					$destination = '../core/' . $new_name;
					move_uploaded_file($_FILES['file']['tmp_name'], $destination);
				}

				# Send flash message based on the db update results
				if ($status) {
					Session::flash('analytics-success', 'Google settings updated successfully.');
					Redirect::to('../pages/settings/google.page.php');
				} else {
					Session::flash('analytics-error', 'Google settings were not added, try again.');
					Redirect::to('../pages/settings/google.page.php');
				}				

			} catch(Exception $e) {
				Session::flash('analytics-error', 'Google settings were not updated, try again.');
				Redirect::to('../pages/settings/google.page.php');
			}

		} else {

			# If there were form valication errors, send error messages
			$errorMessages;

			foreach ($validation->errors() as $error) {
				$errorMessages .= $error . '<br>';
			}

			Session::flash('analytics-error', $errorMessages);
			Redirect::to('../pages/google/google.page.php');
		}
	} 
}

