<?php 

class Controller_About extends CoreController {

	protected $data;	

	public function __contruct() { 

	}

	public function getData() {
		$this->data['pageId'] = "about";
		$this->data['title'] = "Om BMO";
		$this->data['pageStyle'] = '';

		return $this->data;

	}

	public function index() {

		$db = Database::Instance();

		$article = new Article($db);

		$res = $article->getArticle('about');
		$this->data['id'] = $res[0]['id'];
		$this->data['view_title'] = $res[0]['title'];
		$this->data['view_content'] = $res[0]['content'];		
	}
	
}

?>