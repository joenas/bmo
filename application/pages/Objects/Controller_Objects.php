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
		$this->viewHelper = new View_Objects_Helper($this->request->baseUrl);	

		//echo urldecode($this->request->arguments[2]);
		$this->data['view_sidebar'] = $this->viewHelper->viewSidebar();	
	}

	public function show() {


		// No article ID to show
		if (!isset($this->request->arguments[2])) {
			$this->index();
		} else {
			
			$this->viewHelper = new View_Objects_Helper($this->request->baseUrl);	
			$this->data['view_sidebar'] = $this->viewHelper->viewSidebar();	

			// Controller helper
			//$this->viewHelper = new View_Articles_Helper($this->request->baseUrl);	
			// The sidebar
			//$this->data['view_article_sidebar'] = $this->viewHelper->articleSidebar();
	
			// Try to fetch the requested article
			$this->objects = new Object(Database::Instance());
			$object = $this->objects->getByLink($this->request->arguments[2]);

			if (!empty($object)) {
				// The main View
				$this->data['view_object'] = $this->viewHelper->objectView($object[0]);
			} else {
				$this->data['view_object'] = "<p>Objektet hittades inte</p>";
			}

		}
	}
	
}

?>