<?php

// Error reporting, development only
ini_set('display_errors', 1);
error_reporting(-1);

// Start a named session
session_name(preg_replace('/[:\.\/-_]/', '', __FILE__));
session_start();

// Page settings
define( 'DEFAULT_CONTROLLER', 		'home' );
define( 'DEFAULT_METHOD',				'index');
define( 'DEFAULT_TITLE', 	'BMO - Begravningsmuseum Online' );
define( 'EXTENSION',		'.php' );
define( 'SEPARATOR',		'/' );
define( 'CSS', 				'css/' );
define( 'IMG',				'img/' );
define( 'PAGES',			APP . 'pages/' );
define( 'TEMPLATE',		PAGES . 'template.php' );

// Database settings
define( 'DB_PATH', 		APP . 'database/');
define( 'DATABASE',		DB_PATH . 'bmo.sqlite');
define( 'DSN',				'sqlite:' . DATABASE);

// Core and autoloader 
define( 'CORE', 			APP . 'core/' );
define( 'CONTROLLER_PREFIX', 	'Controller_' );
define( 'MODEL_PREFIX',			'Model_' );	
define( 'VIEW_PREFIX',			'View_' );
define( 'CLASS_EXT',		'.php' );



// Autoloader for classes
//----------------------------------------------------

function autoloader($className) {
	// ie 'pages/Example' if class is Controller_Example
	$split = explode('_', $className);
	$classPath = isset($split[1]) ? PAGES.$split[1] : null;

	// Check in 'core/' 
	if (is_file( CORE.$className.CLASS_EXT )) {
		require_once( CORE.$className.CLASS_EXT );
	}	
	// Check in 'pages/Example/'
	elseif (is_file( "{$classPath}/{$className}.php" )) {
		require_once( "{$classPath}/{$className}.php" );
	}
	//else die("Error in ".__FILE__.": Class file for <code>".$className."</code> not found in " . $classPath);
}

spl_autoload_register('autoloader');
spl_autoload_extensions('.php,.class.php');

?>
