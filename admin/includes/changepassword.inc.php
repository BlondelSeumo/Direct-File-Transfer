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
			'password_current' => array(
				'name' => 'Current Password',
				'required' => true,
				'min' => 6
			),
			'password_new'=> array(
				'name' => 'New Password',
				'required' => true,
				'min' => 6
			),
			'password_new_again' => array(
				'name' => 'New Password Confirmation',
				'required' => true,
				'min' => 6,
				'matches' => 'password_new'
			)
		));

		# If validation passed update the db table
		if ($validation->passed()) {
			
			# Check if current password is valid and update the db table
			if (password_verify(Input::get('password_current'), $user->data()->password)) {

				$user->update(array(
					'password' => Hash::make(Input::get('password_new'))
				));

				Session::flash('password-success', 'Password has been successfully changed.');
				Redirect::to('../pages/settings/password.page.php');

			} else {
				Session::flash('password-error', 'Incorrect current password. Password update has failed.');
				Redirect::to('../pages/settings/password.page.php');
			}

		} else {

			# If there were form valication errors, send error messages
			$errorMessages;

			foreach ($validation->errors() as $error) {
				$errorMessages .= $error . '<br>';
			}

			Session::flash('password-error', $errorMessages);
			Redirect::to('../pages/settings/password.page.php');
		}
	}
}

