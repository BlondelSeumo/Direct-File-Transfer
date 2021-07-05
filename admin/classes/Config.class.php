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

class Config {

   /**
	*
	* Return Global Config values fron init.php in core folder
	* @param  path of config key
	* @return config value
	*
	*/
	public static function get($path = null) {
		if ($path) {
			$config = $GLOBALS['config'];
			$path = explode('/', $path);

			foreach($path as $bit) {
				if (isset($config[$bit])) {
					$config = $config[$bit];
				}
			}

			return $config;
		}

		return false;
	}
}