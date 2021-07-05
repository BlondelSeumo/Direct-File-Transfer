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
					'title' => Input::get('title'),
					'description' => Input::get('description'),
					'copyright' => Input::get('copyright'),
				));

				# Send flash message based on the db update results
				if ($status) {
					Session::flash('frontend-success', 'Frontend updated successfully.');
					Redirect::to('../pages/layouts/frontend.page.php');
				} else {
					Session::flash('frontend-error', 'Update has failed, try again.');
					Redirect::to('../pages/layouts/frontend.page.php');
				}				

			} catch(Exception $e) {
				Session::flash('frontend-error', 'Update has failed, try again.');
				Redirect::to('../pages/layouts/frontend.page.php');
			}


		} else {

			# If there were form valication errors, send error messages
			$errorMessages;

			foreach ($validation->errors() as $error) {
				$errorMessages .= $error . '<br>';
			}

			Session::flash('frontend-error', $errorMessages);
			Redirect::to('../pages/layouts/frontend.page.php');
		}
	} 
}

