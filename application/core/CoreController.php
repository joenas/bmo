<?php

class CoreController {

	// Default method if sub-class does not have index, ie 404
	public function index () {
		$this->view = PAGES.'404.php';
    $title = "404";
		require ( TEMPLATE );
		exit;
	}

	public function getdata() { 
		return $this->data; 
	}

	// Rendering method
	public function render() {

		// 'Controller_Example' -> 'Example'
		$view = get_class($this);
		$view = substr($view, strpos($view, '_')+1);

		// Path is for example 'pages/Example/'
		$path = PAGES.$view.SEPARATOR;

    // Content file, 'View_Example.php' etc. Required in template.php
    $this->view = $path.VIEW_PREFIX.$view.'.php';

    // Get the data from controller
		extract($this->data);

		// Template file, ie print the page
		require( TEMPLATE );

	}

	// Redirect to requested page
	protected function redirectPage( $extra = '' ) {
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: http://$host$uri/$extra");
		exit;
	}

}

?>