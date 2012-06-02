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
			$this->controllerAddons($request);
			$this->controller->index();	

		} else {
			// Create the controller
			$this->controller = new $controllerClass;
			
			// Add helper classes
			$this->controllerAddons($request);

			// Give arguments and baseUrl
			$this->controller->baseUrl = $request->baseUrl;	

			// Look for method, otherwise fall back to index()
			if (method_exists($this->controller, $method)) {				
				$this->controller->$method();
			} else {
				$this->controller->index();
			}

			// Let controller render its View
			$this->controller->render();

		}
		// Finished
	}

	private function controllerAddons($request) {
		// Give controller Debug capabilities
		$this->controller->debug = Debug::Instance();

		// Give controller Helper capabilites
		$this->controller->helper = ViewHelper::Instance();

		// Give the controller the Request object
		$this->controller->request = $request;
	}

}
