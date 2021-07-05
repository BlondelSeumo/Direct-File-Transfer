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
				$status = $_db->update('configs_google', 1, array(
					'adsense_left' => Input::get('left-ad'),
					'adsense_right' => Input::get('right-ad'),
				));

				# Send flash message based on the db update results
				if ($status) {
					Session::flash('adsense-success', 'Google Adsense updated successfully.');
					Redirect::to('../pages/marketing/adsense.page.php');
				} else {
					Session::flash('adsense-error', 'Google Adsense was not updated, try again.');
					Redirect::to('../pages/marketing/adsense.page.php');
				}				

			} catch(Exception $e) {
				Session::flash('adsense-error', 'Google Adsense was not updated, try again.');
				Redirect::to('../pages/marketing/adsense.page.php');
			}

		} else {

			# If there were form valication errors, send error messages
			$errorMessages;

			foreach ($validation->errors() as $error) {
				$errorMessages .= $error . '<br>';
			}

			Session::flash('adsense-error', $errorMessages);
			Redirect::to('../pages/marketing/adsense.page.php');
		}
	}
}

