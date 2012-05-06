<?php

class Core {

	public function route() {

		// Parse the request.
		$request = new Request();
		$request->Parse();

		// Capitalize first letter, 'Example' instead of 'example' etc
		$controllerName = ucfirst($request->controller);
		$method = $request->method;

		// ie Controller_Example
		$controllerClass = CONTROLLER_PREFIX.$controllerName;

		if (!class_exists($controllerClass)) 
		{
			// ie 404, no page found
			$this->controller = new CoreController();
			$this->controllerAddons();
			$this->controller->index();	

		} else {
			// Create the controller
			$this->controller = new $controllerClass;
			
			// Add helper classes
			$this->controllerAddons();

			// Give arguments and baseUrl
			$this->controller->baseUrl = $request->baseUrl;	
			$this->controller->arguments = $request->arguments;

			// Look for method, otherwise fall back to index()
			if (method_exists($this->controller, $method)) {				
				//$this->controller->debug->message("Calling {$controllerClass}->{$method}()", __LINE__, __FILE__);
				$this->controller->$method();
			} else {
				//$this->controller->debug->message("Missing method {$method}(), calling default {$controllerClass}->index()", __LINE__, __FILE__);
				$this->controller->index();
			}

			// Let controller render its View
			$this->controller->render();

		}
		// Finished
	}

	private function controllerAddons() {
		// Give controller Debug capabilities
		$this->controller->debug = Debug::Instance();

		// Give controller Helper capabilites
		$this->controller->helper = ViewHelper::Instance();
	}

}
