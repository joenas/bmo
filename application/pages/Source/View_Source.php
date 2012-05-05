<?php 

// Include code from source.php to display sourcecode-viewer
//$sourcebaseUrl=dirname(__FILE__).'/../..';
//$sourcebaseUrl = $this->baseUrl;
$sourceNoEcho=true;

if ( !isset($_GET['file']) && !isset($_GET['dir']) ) {
	$_GET['file'] = 'index.php';
}

include('FSource.php');

echo $sourceBody;
