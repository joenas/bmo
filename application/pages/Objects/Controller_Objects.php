<?php 

class Controller_Objects extends CoreController {

	public function __contruct() { }

	// Returns the array with data for view page
	public function GetData() {

		$this->viewData['pageId'] = "objects";
		$this->viewData['pageStyle'] = '';

		return $this->viewData;
		
	}

	public function Route($request) {

		$db = Database::Instance();

		$object = new Object($db);

		$res = $object->getObject('7');
		$this->viewData['id'] = $res[0]['id'];
		$this->viewData['view_title'] = $res[0]['title'];
		$this->viewData['view_category'] = $res[0]['category'];
		$this->viewData['view_text'] = $res[0]['text'];
		$this->viewData['view_image'] = "<img src=".$res[0]['image'].">";

	}
	
}

?>