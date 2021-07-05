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
		$validation = $validate->check($_POST, array()); 

		# If validation passed update the db table
		if ($validation->passed()) {

			# Initilize DB Class
			$_db = DB::getInstance();

			try {

				# Returns true if update was successful, false otherwise
				$status = $_db->update('upload_settings', 1, array(
					'max_size' => Input::get('max_file_size'),
					'max_quantity' => Input::get('max_file_quantity'),
					'file_type' => Input::get('file_type'),
					'share_type' => Input::get('share_type'),
					'server_encryption' => Input::get('server_encryption'),
					'signed_link' => Input::get('signed_link'),
					'signed_link_expiration' => Input::get('link_expiration'),
					'chunk_size' => Input::get('chunk_size'),
				));

				# Send flash message based on the db update results
				if ($status) {
					Session::flash('upload-success', 'Upload settings have been updated successfully.');
					Redirect::to('../pages/settings/upload.page.php');
				} else {
					Session::flash('upload-error', 'Upload settings were not updated, try again.');
					Redirect::to('../pages/settings/upload.page.php');
				}				

			} catch(Exception $e) {
				Session::flash('upload-error', 'Upload settings were not updated, try again.');
				Redirect::to('../pages/settings/upload.page.php');
			}

		} else {

			# If there were form valication errors, send error messages
			$errorMessages;

			foreach ($validation->errors() as $error) {
				$errorMessages .= $error . '<br>';
			}

			Session::flash('upload-error', $errorMessages);
			Redirect::to('../pages/settings/upload.page.php');
		}
	} 
}

