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

class User {

	private $_db;			# DB instance
	private	$_data;			# Value to star DB query results
	private $_sessionName;	# Session Name
	private $_cookieName;	# Coockie value
	private $_isLoggedIn;	# Bool to check user status


	public function __construct($user = null) {
		$this->_db = DB::getInstance();

		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');

		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);

				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					//process logout
				}
			}
		} else {
			$this->find($user);
		}
	}


	/**
	*
	* Create new user
	* @param user details
	*
	*/
	public function create($fields = array()) {
		if(!$this->_db->insert('users', $fields)) {
			throw new Exception('There was a problem creating an account.');
		}
	}


	/**
	*
	* Find a user
	* @param user name
	* @return bool status
	*
	*/
	public function find($user = null) {
		if($user) {
			$field = (is_numeric($user) ? 'id' : 'username');
			$data = $this->_db->get('users', array($field, '=', $user));

			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}

		return false;
	}


	/**
	*
	* User login check
	* @param username, password, checkbox value
	* @return bool value
	*
	*/
	public function login($username = null, $password = null, $remember = false) {
		
		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		} else {

			$user = $this->find($username);

			if ($user) {
				if (password_verify($password, $this->data()->password)) {
					Session::put($this->_sessionName, $this->data()->id);

					if ($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

						if (!$hashCheck->count()) {
							$this->_db->insert('users_session', array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						} else {
							$hash = $hashCheck->first()->hash;
						}

						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					}

					return true;	
				}
			}
		}

		return false;
	}


	/**
	*
	* Update user details
	* @param user details
	*
	*/
	public function update($fields = array(), $id = null) {
		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if (!$this->_db->update('users', $id, $fields)) {
			throw new Exception('There was a problem updating.');
		}
	}


	/**
	*
	* Generate unique token
	* @return csrf token
	*
	*/
	public function exists() {
		return (!empty($this->data) ? true : false);
	}


	/**
	*
	* Get DB query result data
	* @return query result
	*
	*/
	public function data() {
		return $this->_data;
	}


	/**
	*
	* Logout user session
	*
	*/
	public function logout() {

		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}


	/**
	*
	* Check if user is looged in
	* @return login status
	*
	*/
	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}
}