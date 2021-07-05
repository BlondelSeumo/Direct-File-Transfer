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
			'access_key' => array(
				'min' => 16,
				'max' => 128,
				'required' => true,
			), 
			'secret_access_key' => array(
				'required' => true,
			),
			'region' => array(
				'min' => 9,
				'required' => true,
			),
			'bucket_name' => array(
				'min' => 3,
				'max' => 63,
				'required' => true,
			),
		)); 

		# If validation passed update the db table
		if ($validation->passed()) {

			# Initilize DB Class
			$_db = DB::getInstance();

			try {

				# Returns true if update was successful, false otherwise
				$status = $_db->update('configs', 1, array(
					'access_key' => Input::get('access_key'),
					'secret_access_key' => Input::get('secret_access_key'),
					'region' => Input::get('region'),
					'bucket_name' => Input::get('bucket_name'),
				));

				# Send flash message based on the db update results
				if ($status) {
					Session::flash('wasabi-success', 'Wasabi Credentials have been updated successfully.');
					Redirect::to('../pages/settings/wasabicredentials.page.php');
				} else {
					Session::flash('wasabi-error', 'Database write failed, try again.');
					Redirect::to('../pages/settings/wasabicredentials.page.php');
				}				

			} catch(Exception $e) {
				Session::flash('wasabi-error', 'Database write failed, try again.');
				Redirect::to('../pages/settings/wasabicredentials.page.php');
			}

		} else {

			# If there were form valication errors, send error messages
			$errorMessages;

			foreach ($validation->errors() as $error) {
				$errorMessages .= $error . '<br>';
			}

			Session::flash('wasabi-error', $errorMessages);
			Redirect::to('../pages/settings/wasabicredentials.page.php');
		}
	} 
}

