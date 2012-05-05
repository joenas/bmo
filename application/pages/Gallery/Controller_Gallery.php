<?php 

class Controller_Gallery extends CoreController {

	public function __contruct() { }

	// Returns the array with data for view page
	public function GetData() {

		$this->viewData['pageId'] = "gallery";
		$this->viewData['pageStyle'] = '';

		return $this->viewData;
		
	}

	public function Route($request) {

	}
	
}

?>