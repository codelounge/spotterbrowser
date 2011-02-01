<?php defined('SYSPATH') or die('No direct access allowed.');

return array(

	'driver'        => 'ORM',
	'hash_method'   => 'sha1',
	'salt_pattern' => '1, 3, 7, 9, 14, 16, 21, 24, 25, 36',
	'lifetime'      => 1209600,
	'session_key'   => 'auth_user',
	'autologin_key' => 'auth_autologin',
	'forced_key'    => 'auth_forced',

);