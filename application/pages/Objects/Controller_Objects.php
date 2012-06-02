<?php 

class Controller_Objects extends CoreController {

	public function __contruct() { }

	// Returns the array with data for view page
	public function GetData() {

		$this->data['pageId'] = "objects";
		$this->data['title'] = "BMO: Objekt";
		$this->data['pageStyle'] = '';

		return $this->data;
		
	}

	public function index() {
		// General setup
		$this->setup();
		$this->data['view_object'] = "<h1>Objektsamling</h1><p>Här kan du se alla objekt som Ronny samlat på sig genom åren. 
																	Välj en kategori till vänster eller använd sökrutan.
																	För större bilder, se <a href={$this->baseUrl}gallery>galleriet</a>.";
	}

	public function show() {

		// No article ID to show
		if (!isset($this->request->arguments[2])) {
			$this->index();
		} else {
			
			// General setup
			$this->setup();

			// Try to fetch the requested object
			$object = $this->objects->getByLink($this->request->arguments[2]);

			if (!empty($object)) {
				// The main View
				$this->data['view_object'] = $this->viewHelper->objectView($object[0]);
			} else {
				$this->data['view_object'] = "<p>Objektet hittades inte</p>";
			}

		}
	}

	public function category() {

		// No article ID to show
		if (!isset($this->request->arguments[2])) {
			$this->index();
		} else {

			// General setup
			$this->setup();

			// Try to fetch the requested category
			$object = $this->objects->getAllByIndex('category', urldecode($this->request->arguments[2]));

			if (!empty($object)) {
				// The main View
				$this->data['view_object'] = $this->viewHelper->categoryView($object);
			} else {
				$this->data['view_object'] = "<p>Kategorin hittades inte</p>";
			}

		}
	}

	private function setup() {
		$this->viewHelper = new View_Objects_Helper($this->request->baseUrl);	
		$this->data['view_sidebar'] = $this->viewHelper->viewSidebar();	
		$this->objects = new Object(Database::Instance());
	}
	
}

?>