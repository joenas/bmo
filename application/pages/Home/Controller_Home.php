<?php 

class Controller_Home implements iController {

	public function __contruct() { }

	// Returns the array with data for view page
	public function GetData() {

		$this->viewData['pageId'] = "home";
		$this->viewData['pageStyle'] = '';

		// echo "<p><strong>";
		// var_dump($this->viewData);
		// echo "</strong></p>";

		return $this->viewData;
		
	}

	public function Route($request) {

		$db = new Database();

		$article = new Article($db);

		$res = $article->getArticle('7');
		$this->viewData['id'] = $res[0]['id'];
		$this->viewData['view_title'] = $res[0]['title'];
		$this->viewData['view_content'] = $res[0]['content'];

	}
	
}

?>