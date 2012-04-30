<?php 

class Controller_Articles implements iController {

	public function __contruct() { }

	// Returns the array with data for view page
	public function GetData() {

		$this->viewData['pageId'] = "articles";
		$this->viewData['pageStyle'] = '';

		return $this->viewData;
		
	}

	public function Route($request) {

	}
	
}

?>