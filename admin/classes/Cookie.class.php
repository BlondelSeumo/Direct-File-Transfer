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

class Cookie {

	/**
	*
	* Check if cookie already exists for the user
	* @param  user login name
	* @return bool status
	*
	*/
	public static function exists($name) {
		return (isset($_COOKIE[$name])) ? true : false;
	}


	/**
	*
	* Get cookie name
	* @param  user login name
	* @return cookie name
	*
	*/
	public static function get($name) {
		return $_COOKIE[$name];
	}


	/**
	*
	* Set user cookie with expiry time
	* @param  user login name, hash value, expiry time
	* @return bool status
	*
	*/
	public static function put($name, $value, $expiry) {
		if (setcookie($name, $value, time() + $expiry, '/')) {
			return true;
		}

		return false;
	}


	/**
	*
	* Delete cookie fo the user
	* @param  user login name
	*
	*/
	public static function delete($name) {
		self::put($name, '', - 1);
	}
}