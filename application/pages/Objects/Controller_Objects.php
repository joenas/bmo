<?php 

class Controller_Objects extends CoreController {

	public function __contruct() { }

	// Returns the array with data for view page
	public function GetData() {

		$this->data['pageId'] = "objects";
		$this->data['pageStyle'] = '';

		return $this->data;
		
	}

	public function index() {

		$db = Database::Instance();

		$object = new Object($db);

		//echo urldecode($this->request->arguments[2]);


		$res = $object->getById('7');
		$this->data['id'] = $res[0]['id'];
		$this->data['view_title'] = $res[0]['title'];
		$this->data['view_category'] = $res[0]['category'];
		$this->data['view_text'] = $res[0]['text'];
		$this->data['view_image'] = "<img src=".$res[0]['image'].">";

		$array = $object->getColumnDistinct('category');
		$html = '<h2>Kategorier</h2><ul>';
		foreach ($array as $val) {
			$html .= "<li><a href={$this->baseUrl}objects/category/".$val['category'].">".$val['category']."</a></li>";
		}
		$html .= "</ul>";
		$this->data['view_sidebar'] = $html;
	}
	
}

?>