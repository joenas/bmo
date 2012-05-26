<?php 

class Controller_Articles extends CoreController {

	public function __construct() { 
	}

	public function getData() {
			$this->data['pageId'] = "articles";
			$this->data['title'] = "Artiklar";
			return $this->data;
	}

	public function index() {
		// Controller helper
		$this->viewHelper = new View_Articles_Helper($this->request->baseUrl);	
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
			// Controller helper
			$this->viewHelper = new View_Articles_Helper($this->request->baseUrl);	

			// The main View
			$this->data['view_article'] = $this->viewHelper->articleView($this->request->arguments[2]);
			// The sidebar
			$this->data['view_article_sidebar'] = $this->viewHelper->articleSidebar();
			
			// Ugly hack to make up for html in post...
			if ($this->request->arguments[2]=="begravningsseder-och-bruk") {
				$this->data['pageStyle'] = "article.articles { width: 100%; } article.begravning-right { float: right; width: 35%; } article.begravning-right figure { margin: 20px 0 20px 40px; }";
				$this->data['pageStyle'] .= " div.primary { width: 80%; } div.secondary { display: none; } article.begravning-left { width: 65%; float: left; } ";
			}
			else {
				// The image side bar
				$this->data['view_images'] = $this->viewHelper->articleImages($this->request->arguments[2]);
			}
		}
	}


}

?>