<?php 

class Controller_About implements iController {

	public function __contruct() { }

	// Returns the array with data for view page
	public function GetData() {

		$this->viewData['pageId'] = "about";
		$this->viewData['title'] = "Om BMO";
		$this->viewData['pageStyle'] = '';

		return $this->viewData;
		
	}

	public function Route($request) {

		$db = new Database();

		$article = new Article($db);

		$res = $article->getArticle('4');
		$this->viewData['id'] = $res[0]['id'];
		$this->viewData['view_title'] = $res[0]['title'];
		$this->viewData['view_content'] = $res[0]['content'];		
	}
	
}

?>