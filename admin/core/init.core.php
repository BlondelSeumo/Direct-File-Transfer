<?php 

session_start();

/**************************************************
 *
 * Global config variables
 *
 **************************************************/
$GLOBALS['config'] = array(
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 605800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'csrf_token'
	)
);


define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/wasabi/admin/');


/**************************************************
 *
 * Autoload Classes
 * @param  class name
 * @return required class
 *
 **************************************************/
spl_autoload_register(function($class) {
	require_once ROOT_PATH . 'classes/' . $class . '.class.php';
});

require_once ROOT_PATH . 'includes/sanitize.inc.php';


if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}

