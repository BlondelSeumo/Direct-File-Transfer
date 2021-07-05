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

class Hash {


	/**
	*
	* Encrypt a password with hash value
	* @param input string
	* @return hash value of input
	*
	*/
	public static function make($string) {
		return password_hash($string, PASSWORD_BCRYPT);
	}


	/**
	*
	* Create random value hash
	* @return hash value 
	*
	*/
	public static function unique() {
		return self::make(uniqid());
	}
}