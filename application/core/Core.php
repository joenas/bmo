<?php

class Core {

	public function route() {

		// Parse the request.
		$request = new Request();
		$request->Parse();

		// Capitalize first letter, 'Index' instead of 'index' etc
		$controllerName = ucfirst($request->controller);
		$method = $request->method;

		// ie Controller_Example
		$controllerClass = CONTROLLER_PREFIX.$controllerName;

		if (!class_exists($controllerClass)) 
		{
			// ie 404, no page found
			$this->controller = new CoreController();
			$this->controller->index();	

		} else {
			// Create the controller
			$this->controller = new $controllerClass;
			$this->controller->name = $controllerName;

			// Give controller Debug capabilities
			$this->controller->debug = Debug::Instance();

			// Give controller Helper capabilites
			$this->controller->helper = ViewHelper::Instance();

			// Give arguments
			$this->controller->baseUrl = $request->baseUrl;	
			$this->controller->arguments = $request->arguments;

			// Look for method, otherwise fall back to index()
			if (method_exists($this->controller, $method)) {				
				//$this->controller->debug->message("calling {$method}", __LINE__, __FILE__);
				$this->controller->$method();
			} else {
				$this->controller->debug->message("calling default index()", __LINE__, __FILE__);
				$this->controller->index();
			}

			// Let controller render its View
			$this->controller->render();

		}
		// Finished
	}

}
