<?php 

/**************************************************
 *
 * Sanitize input/output
 * @param  input string
 * @return sanitized string
 *
 **************************************************/
function escape($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}