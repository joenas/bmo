<?php

/*------------------------------------------------------------------

	Description: Front controller for generating webpage
	Author: Jon Neverland, mail@jonnev.se

	Parts of parser and controller logic borrowed from http://dbwebb.se/lydia/

---------------------------------------------------------------------*/

// The application install directory
define( 'ROOT', dirname(__FILE__).'/' );
define( 'APP', 'application/' );
require( APP.'config.php' );

// Create the Core object and route
//----------------------------------------------------

$core = new Core();
$core->route();
//----------------------------------------------------

?>
