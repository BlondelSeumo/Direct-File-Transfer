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

class Redirect {

	/**
	*
	* Simplify header redirect fucntion
	* @param location/link name
	*
	*/
	public static function to($location = null) {
		if ($location) {
			if (is_numeric($location)) {
				switch ($location) {
					case 404:
						header('HTTP/1.0 404 Not Found');
						include 'includes/errors/404.php';
						exit();
					break;
				}
			}
			header('Location: ' . $location);
			exit();
		}
	}
}