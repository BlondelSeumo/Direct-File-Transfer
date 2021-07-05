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

class Token {

	/**
	*
	* Generate unique token
	* @return csrf token
	*
	*/
	public static function generate() {
		return Session::put(Config::get('session/token_name'), md5(uniqid()));
	}

	/**
	*
	* Check generated token
	* @param token value
	* @return bool value
	*
	*/
	public static function check($token) {
		$tokenName = Config::get('session/token_name');

		if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
			Session::delete($tokenName);
			return true;
		}

		return false;
	}
}