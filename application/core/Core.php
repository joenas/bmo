<?php

class Core {

	public function Route($request) {

		// Require site functions
//		require_once ( FUNCTIONS.'FCommon.php' );
//		require_once ( FUNCTIONS.'FLoginsrc.php' );

		$this->baseDir = $request->baseDir;

		// Index instead of index etc
		$this->page = ucfirst($request->page);

		// Classes for page
		$controllerClass = CONTROLLER_PREFIX.$this->page;
		$modelClass = MODEL_PREFIX.$this->page;

		if (class_exists($controllerClass)) {

			$this->controller = new $controllerClass;

			// So we can always access modelClass by $this->modelClass in controllerClass
			if (class_exists($modelClass)) {
				$this->controller->modelClass = $modelClass;
			}
			// Safe to call method
			if ($this->controller instanceof iController) {
				$this->controller->Route($request);
			}
			else die("Class $controllerClass doesnt not implement iController");
		}

	}

	public function Render() {

		// For example pages/Report/
		$path = PAGES.$this->page.SEPARATOR;

    	// Content file, View_Report.php etc. Required in template.php
    	$view = $path.VIEW_PREFIX.$this->page.'.php';

		// Available?
    	if ( !is_file($view) ) 
    	{
    		$view = PAGES.'404.php';
    		$title = "404";
    	}
    	/* 
    	If property exists, class is loaded and implements 
    	iController so calling GetData should be safe
    	*/
		else if ( property_exists($this, 'controller') ) {
			extract($this->controller->GetData());
		}

		// Template file, ie print the page
		require( PAGES.'template.php' );

	}

	public function Link($link, $type = 'href', $aBaseDir = null) {

		// If provided with new basedir, use that. Otherwise check for root and alter or use regular			
		$baseDir = ( isset($aBaseDir) ) ? $aBaseDir : ($this->baseDir=='/') ? '' : $this->baseDir;
		print $type . "='$baseDir/$link'";
	
	}

	public function SourceLink($pageFile) {
		print "<a href='".$this->baseDir."/source?dir=".dirname($pageFile)."&amp;file=".basename($pageFile)."'>Källkod</a>";
	}

}
