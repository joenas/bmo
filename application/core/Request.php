<?php

class Request {
	
	public $baseUrl;
	public $controller;
	public $method;
	public $arguments;

	// Function for parsing the request string.
	//-------------------------------------------
	public function Parse() {

		// Get request and baseUrl dir
		$requestUri = $_SERVER['REQUEST_URI'];
		$scriptName = $_SERVER['SCRIPT_NAME'];
		$baseUrl = dirname($scriptName);
		$request = trim( substr($requestUri, strlen(rtrim($baseUrl, '/'))), '/' ).'/';

		// Get query part of request
		$query = "";
		$pos = strpos($request, '?');
		if ($pos != 0) {
			$query = substr($request, $pos);
			$request = substr($request, 0, $pos);
		}

		// Split request
		$splits = explode('/', $request);

		// Set controller and method 
		$controller = !empty($splits[0]) ? $splits[0] : DEFAULT_CONTROLLER;
		$method = !empty($splits[1]) ? $splits[1] : DEFAULT_METHOD;
		$arguments = $splits;
    	unset($arguments[0], $arguments[1]);
		
		$this->baseUrl = $baseUrl;
		$this->controller = $controller;
		$this->method = $method;
		$this->arguments = $arguments;

		echo "in request: " . $this->baseUrl;

	}
}

?>