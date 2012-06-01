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
			// The sidebar
			$this->data['view_article_sidebar'] = $this->viewHelper->articleSidebar();
	
			// Try to fetch the requested article
			$this->articles = new Article(Database::Instance());
			$article = $this->articles->getByLink($this->request->arguments[2]);

			if (!empty($article)) {
				// The main View
				$this->data['view_article'] = $this->viewHelper->articleView($article);
			
				// Ugly hack to make up for html in post...
				if ($this->request->arguments[2]=="begravningsseder-och-bruk") {
					$this->data['pageStyle'] = "article.articles { width: 100%; } aside.begravning-right { background: white; float: right; width: 35%; } aside.begravning-right figure { margin: 20px 0 20px 40px; }";
					$this->data['pageStyle'] .= " div.primary { width: 80%; } div.secondary { display: none; } article.begravning-left { width: 65%; float: left; } ";
				}
				else {
					// The related images 
					$this->data['view_images'] = $this->viewHelper->articleImages($this->request->arguments[2]);
				}
			} else {
				$this->data['view_article'] = "<p>Artikeln hittades inte</p>";
			}

		}
	}


}

?>