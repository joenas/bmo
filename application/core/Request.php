<?php

class Request {
	
	public $baseDir;
	public $page;
	public $action;
	public $args;

	// Function for parsing the request string.
	//-------------------------------------------
	public function Parse() {

		// Get request and base dir
		$requestUri = $_SERVER['REQUEST_URI'];
		$scriptName = $_SERVER['SCRIPT_NAME'];
		$baseDir = dirname($scriptName);
		$request = trim( substr($requestUri, strlen(rtrim($baseDir, '/'))), '/' );

		// Get query part of request
		$query = "";
		$pos = strpos($request, '?');
		if ($pos != 0) {
			$query = substr($request, $pos);
			$request = substr($request, 0, $pos);
		}

		// Split request
		$splits = explode('/', $request);

		// Set page and action 
		$page =  !empty($splits[0]) ? $splits[0] : DEFAULTPAGE;
		$action =  !empty($splits[1]) ? $splits[1] : '';

		$this->baseDir = $baseDir;
		$this->page = $page;
		$this->action = $action;
		$this->args = $splits;

//		echo "<strong>\$requestUri= $requestUri, \$scriptName= $scriptName, \$baseDir = $baseDir, \$request = $request, \$query = $query<br>";
//		echo "\$page = $this->page, \$action = $this->action</strong><br><br>";

	}
}

?>