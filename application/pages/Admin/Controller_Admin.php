<?php 

class Controller_Admin extends CoreController {

	static private $user = 'admin';
	static private $password = 'test';
	private $login;
	protected $authenticated;


	public function __construct() { 
		
		// Login functionality.
		//----------------------
		$this->login = new Login;
		$this->authenticated = $this->login->userIsAuthenticated();

		$this->db = Database::Instance();
		//$this->data['pageStyle'] = '';
	}

	public function getData() {
				// Basic variables for template
		$this->data['pageId'] = "admin";
		$this->data['title'] = "BMO Admin";
		$this->data['pageStyle'] = "header.logo { display: none; } div.primary { width: 80%; }";

		return $this->data;
	}

	// Default View
	public function index() {

		// User not logged in
		if ($this->authenticated===false) {
				// Default action, show the login form
				$this->data['view'] = $this->login->userLoginForm($this->baseUrl);
				//$this->data['pageStyle'] = "div.primary { width: 100%; } ";
		} 
		// User is logged in
		else {
			$this->data['view'] = "<p>Du är nu inloggad. Välj en funktion till höger.</p>";
		}
	}


	// Editor view, requires that user is logged in
	public function edit() {

		if ($this->authenticated===false) {
			$this->index();
		} else {

			// Get model type and id
			$this->requestParser();

			// Create the helper
			$viewHelper = new View_Admin_Helper($this->model, $this->id);

			// Set notice to View if available
			$message = isset($this->message) ? $viewHelper->notice($this->message) : null;		

			// Setup the editor View
			$this->data['view'] = $viewHelper->editView();
		}
	}	

	// View for adding article or object
	public function add() {

		if ($this->authenticated===false) {
			$this->index();
		} else {

			// Get model type and id
			$this->requestParser();

			// Create the helper
			$viewHelper = new View_Admin_Helper($this->model, null);

			// Set notice to View if available
			$message = isset($this->message) ? $viewHelper->notice($this->message) : null;

			// Setup the add View
			$this->data['view'] = $viewHelper->addView();
		}		
	}

	// Updates the database and redirects to edit View for posted object
	public function update() {

		if ($this->authenticated===false || !isset($_POST['save'])) {
			$this->index();
		}	else if ( isset($_POST['save']) && $_POST['save']==true) {

				// Get the model type and id
				$this->requestParser();

				// Create Model, for example 'Article'
				$model = new $this->model($this->db);

				// Update
				$model->update($_POST);

				switch ($this->model) {
					case "Article":
						$this->message = "Artikeln har uppdaterats.";
						break;
					case "Object":
						$this->message = "Objektet har uppdaterats.";
						break;
				}

				// Reroute to edit View
				$this->reroute('edit', $this->model, $this->id);
		}
	}

	// Deletes from database and redirects to edit View
	public function delete() {
		
		// Get the model type and id
		$this->requestParser();
		
		// Not logged in / id OR type isnt set
		if ($this->authenticated===false || !(isset($this->model) && isset($this->id)) ) {
			$this->index();
		}
		// Both id and type are set	
		else  {

				// Create the model, for example 'Article'
				$model = new $this->model($this->db);

				// Delete the post
				$model->deleteById($this->id);

			  switch ($this->model) {

				case "Article";
					$this->message = "Artikeln har tagits bort.";
					break;
				case "Object": 
					$this->message = "Objektet har tagits bort.";
					break;
			}

			// Unset posted id and do not send id to new View, post is gone!
			unset($_POST['id']);
			$this->reroute('edit', $this->model);
		}
	}

	// Inserts a new object/article to database and redirects to edit View
	public function insert() {

		if ($this->authenticated===false) {
			$this->index();
		} 
		else if (isset($_POST['save']) && $_POST['save']==true) { 

			// Get the model type and id
			$this->requestParser();

			// Create the model, for example 'Article'
			$model = new $this->model($this->db);

			// Create the post. Function is in the model file, ie 'models/Article.php'
			$res = $model->create( $_POST );

			// If creating failed, go back to add View and show error message
			if ($res==0) {
				$this->message = "Det gick ej att lägga till, vänligen kontrollera databasen";
				$this->id = null;
				$this->reroute('add', $this->model);
			}
			else { // Insert successful
				switch ($this->model) {
				
				case "Article":
					$this->message = "Artikeln har lagts till.";
				break;

				case "Object":
					$this->message = "Objektet har lagts till.";
				break;
				}
				// Reroute to edit View with the new post id
				$this->reroute('edit', $this->model, $res);
			}
			
		}
	}

	// Login
	public function login() {
		// Try to login, get result in html and add it to the View
		$res = $this->login->UserLogin($this->baseUrl, self::$user, sha1(self::$password));
		// Success
		if ($res!==false) {
			$this->redirectPage('admin');
		} else {
			$this->data['view'] = $this->login->userLoginForm(
									$this->baseUrl, 
									"Du lyckades ej logga in. Felaktigt konto eller lösenord.", 
									"error" );
			$this->data['pageStyle']  = "div.primary { width: 100%; } ";
		}
	}
	
	// Logout and redirect
	public function logout() {
			$this->login->userLogout();
			$this->redirectPage('admin');
	}

	// Gets the needed ID and model type for editing etc
	private function requestParser() {

		// Arguments from request, ie 'article' or 'object'
		$this->model = 	!isset($this->model) 
											? isset($this->request->arguments[2]) ? $this->request->arguments[2] : null 
										: $this->model;

		// Convert to 'Example' or 'Object'
		$this->model = ucfirst($this->model);

		// Check if the model class exists
		$this->model = class_exists($this->model) ? $this->model : null;

		// Check for id in $_POST first, then in request URL 		
		$this->id = !isset($this->id) 
									? !isset($_POST['id']) 
										?  isset($this->request->arguments[3]) ? $this->request->arguments[3] : null 
									: strip_tags($_POST['id']) 
								: $this->id;
	}

	// Reroute internally after successful update etc
	private function reroute($route, $model = null, $id = null) {
		$this->model = $model;
		$this->id = $id;
		$this->$route();
	}

}

?>