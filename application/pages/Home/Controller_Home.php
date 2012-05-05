<?php 

class Controller_Home extends CoreController {

	public function __contruct() { }

	// Returns the array with data for view page
	public function GetData() {

		$this->data['pageId'] = "home";
		$this->data['pageStyle'] = '';

		// echo "<p><strong>";
		// var_dump($this->data);
		// echo "</strong></p>";

		return $this->data;
		
	}

	public function index() {

		$db = Database::Instance();

		$article = new Article($db);

		$res = $article->getArticle('home');
		$this->data['id'] = $res[0]['id'];
		$this->data['view_title'] = $res[0]['title'];
		$this->data['view_content'] = $res[0]['content'];

	}

	public function test() {
		echo "test";
	}
	
}

?>