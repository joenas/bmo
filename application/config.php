<?php

// Error reporting, development only
ini_set('display_errors', 1);
error_reporting(-1);

// Start a named session
session_name(preg_replace('/[:\.\/-_]/', '', __FILE__));
session_start();

define( 'DEFAULTPAGE', 		'home');
define( 'DEFAULT_TITLE', 	'BMO - Begravningsmuseum Online');
define( 'EXTENSION',		'.php');
define( 'CLASS_EXT',		'.php');
define( 'SEPARATOR',		'/');
define( 'CSS', 				'css/');
define( 'IMG',				'img/');

define( 'CORE', 			APP.'core/');
define( 'DATABASE', 		APP.'database/');
define( 'PAGES',			APP.'pages/');
//define( 'FUNCTIONS', 		APP.'function/' );

define( 'CONTROLLER_PREFIX', 	'Controller_');  		// File prefix
define( 'MODEL_PREFIX',			'Model_');				// File prefix
define( 'VIEW_PREFIX',			'View_');

define( 'DB_PATH',			DATABASE.'bmo.sqlite');	

// Autoloader for classes
//----------------------------------------------------

function autoloader($className) {
	$classPath = PAGES.substr($className, strpos($className, "_")+1).SEPARATOR;

	if (is_file( CORE.$className.CLASS_EXT )) {
		require_once( CORE.$className.CLASS_EXT );
	}	
	elseif (is_file( $classPath.$className.CLASS_EXT )) {
		require_once( $classPath.$className.CLASS_EXT );
	}
	//else die("Class file for <code>".$className."</code> not found.");
}

spl_autoload_register('autoloader');
spl_autoload_extensions('.php,.class.php');

?>
