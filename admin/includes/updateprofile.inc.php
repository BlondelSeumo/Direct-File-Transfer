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
			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 32
			), 
			'email' => array(
				'name' => 'Email',
				'required' => true,
				'min' => 4
			),
			'name' => array(
				'required' => false,
				'min' => 2
			),
			'password_current' => array(
				'name' => 'Current Password',
				'required' => true,
				'min' => 6
			),
		)); 

		# If validation passed update the db table
		if ($validation->passed()) {

			# Check if current password is valid and update the db table
			if (password_verify(Input::get('password_current'), $user->data()->password)) {
				try {
					$user->update(array(
						'username' => Input::get('username'),
						'name' => Input::get('name'),
						'email' => Input::get('email')
					));

					Session::flash('profile-success', 'Profile details have been updated successfully.');
					Redirect::to('../pages/settings/profile.page.php');

				} catch(Exception $e) {
					Session::flash('profile-error', 'Database updated has failed, try again.');
					Redirect::to('../pages/settings/profile.page.php');					
				}

			} else {
				Session::flash('profile-error', 'Incorrect current password. Profile updated has failed.');
				Redirect::to('../pages/settings/profile.page.php');
			}

		} else {

			# If there were form valication errors, send error messages
			$errorMessages;

			foreach ($validation->errors() as $error) {
				$errorMessages .= $error . '<br>';
			}

			Session::flash('profile-error', $errorMessages);
			Redirect::to('../pages/settings/profile.page.php');
		}
	} 
}

