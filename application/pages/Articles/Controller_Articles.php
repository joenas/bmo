<?php 

class Controller_Articles extends CoreController {

	public function __construct() { 
		// Controller helper, needed in all methods
		$this->viewHelper = new View_Articles_Helper('/');
	}

	public function getData() {
			$this->data['pageId'] = "articles";
			$this->data['title'] = "Artiklar";
			return $this->data;
	}

	public function index() {
		
		// The main View
		$this->data['view_article_list'] = $this->viewHelper->articleList();
		// The sidebar
		$this->data['view_article_sidebar'] = $this->viewHelper->articleSidebar();
 
	}

	public function show() {

		// No article ID to show
		if (!isset($this->request->arguments[2])) {
			$this->index();
		} else {
			// The main View
			$this->data['view_article'] = $this->viewHelper->articleView($this->request->arguments[2]);
			// The sidebar
			$this->data['view_article_sidebar'] = $this->viewHelper->articleSidebar();
		}
	}


}

?>