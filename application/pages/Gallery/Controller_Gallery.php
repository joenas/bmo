<?php 

class Controller_Gallery extends CoreController {

	public function __contruct() { }

	public function getData() {
		$this->data['pageId'] = "gallery";
		$this->data['title'] = "Galleri";
		$this->data['pageStyle'] = '';
		return $this->data;
	}

	public function index() {

	}
	
}

?>