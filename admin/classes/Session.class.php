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

class Session {

	/**
	*
	* Check if session exists
	* @param session name
	* @return bool value
	*
	*/
	public static function exists($name) {
		return (isset($_SESSION[$name])) ? true : false; 
	}


	/**
	*
	* Assign a session name
	* @param session name and value
	* @return session 
	*
	*/
	public static function put($name, $value) {
		return $_SESSION[$name] = $value;
	}


	/**
	*
	* Get session
	* @param session name
	* @return session
	*
	*/
	public static function get($name) {
		return $_SESSION[$name];
	}


	/**
	*
	* Delete session if exists
	* @param session name
	*
	*/
	public static function delete($name) {
		if (self::exists($name)) {
			unset($_SESSION[$name]);
		}
	}


	/**
	*
	* Short messages shown only once
	* @param session name, message
	* @return session
	*
	*/
	public static function flash($name, $string = '') {
		if(self::exists($name)) {
			$session = self::get($name);
			self::delete($name);
			return $session;			
		} else {
			self::put($name, $string);
		}

	}


}