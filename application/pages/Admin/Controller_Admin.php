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

		// Basic variables for template
		$this->data['pageId'] = "admin";
		$this->data['title'] = "BMO Admin";
		if (!isset($this->data['pageStyle'])) { $this->data['pageStyle'] = "header.logo { display: none; }"; }
		
	}


	// Default View
	public function index() {

		// User not logged in
		if ($this->authenticated===false) {
				// Default action, show the login form
				$this->data['view'] = $this->login->userLoginForm($this->baseUrl);
		} 
		// User is logged in
		else {
			$this->data['view'] = "<p>Du är nu inloggad. Välj en funktion till höger.</p>";
		}
		$this->data['pageStyle'] = '';
	}


	// Editor view, requires that user is logged in
	public function edit() {

		if ($this->authenticated===false) {
			$this->index();
		} else {
			$this->requestParser();
			$viewHelper = new View_Admin_Helper($this->type, $this->id);
			$message = isset($this->message) ? $viewHelper->notice($this->message) : null;		
			$this->data['view'] = $viewHelper->editView();
		}
	}	

	// View for adding article or object
	public function add() {

		if ($this->authenticated===false) {
			$this->index();
		} else {
			$this->requestParser();
			$viewHelper = new View_Admin_Helper($this->type, null);
			$this->data['view'] = $viewHelper->addView();
		}		
	}

	// Updates the database and redirects to edit View for posted object
	public function update() {

		if ($this->authenticated===false || !isset($_POST['save'])) {
			$this->index();
		}	else if ( isset($_POST['save']) && $_POST['save']==true) {
				$this->requestParser();
				$db = Database::Instance();

				switch ($this->type) {

				case "article":
					$article = new Article($db);
					//$res = $article->updateArticle($_POST['id'], $_POST['title'],$_POST['category'],$_POST['author'],$_POST['pubdate'],$_POST['content']);
					$article->updateArticle($_POST);
					$this->message = "Artikeln har uppdaterats.";
					break;

				case "object":
					$object = new Object($db);
					$object->updateObject($_POST['id'], $_POST['title'],$_POST['category'],$_POST['image'],$_POST['owner'],$_POST['text']);
					$this->message = "Objektet har uppdaterats.";
					break;
				}
				$this->reroute('edit', $this->type, $this->id);
		}
	}

	// Deletes from database and redirects to edit View
	public function delete() {
		
		$this->requestParser();
		
		// Not logged in / id OR type isnt set
		if ($this->authenticated===false || !(isset($this->type) && isset($this->id)) ) {
			$this->index();
		}
		// Both id and type are set	
		else  {
				$db = Database::Instance();

			  switch ($this->type) {

				case "article";
					$article = new Article($db);
					$article->deleteArticle($this->id);
					$this->message = "Artikeln har tagits bort.";
					break;
				case "object": 
					$object = new Object($db);
					$object->deleteObject($this->id);
					$this->message = "Objektet har tagits bort.";
					break;
			}
			unset($_POST['id']);
			$this->reroute('edit', $this->type);
		}
	}

	// Inserts a new object/article to database and redirects to edit View
	public function insert() {
		if ($this->authenticated===false) {
			$this->index();
		} 
		else if (isset($_POST['save']) && $_POST['save']==true) { 

			$this->requestParser();
			$db = Database::Instance();
			switch ($this->type) {
			
			case "article":
				$article = new Article($db);
				$res = $article->createArticle( $_POST );
				// Insert successful
				if ($res!=='0') {
					$this->message = "Artikeln har lagts till.";
				}
				break;

			case "object":
				$object = new Object($db);
				$res = $object->createObject( $_POST['title'], $_POST['category'], 
												$_POST['image'], $_POST['owner'], $_POST['text'] );
				// Insert successful
				if ($res!=='0') {
					$this->message = "Objektet har lagts till.";
				}
				break;
			}
			$this->reroute('edit', $this->type, $res);
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
			$this->data['view'] = 	$this->login->userLoginForm(
									$this->baseUrl, 
									"Du lyckades ej logga in. Felaktigt konto eller lösenord.", 
									"error" );
			$this->data['pageStyle'] = '';
		}
	}
	
	// Logout
	public function logout() {
			$this->login->userLogout();
			$this->redirectPage('admin');
	}

	// Gets the need id and object type for editing etc
	private function requestParser() {
		// Arguments from request, ie 'article' or 'object'
		$this->type = 	!isset($this->type) 
											? isset($this->request->arguments[2]) ? $this->request->arguments[2] : null 
										: $this->type;

		// Check for id in $_POST first, then in request URL 		
		$this->id = !isset($this->id) 
									? !isset($_POST['id']) 
										?  isset($this->request->arguments[3]) ? $this->request->arguments[3] : null 
									: strip_tags($_POST['id']) 
								: $this->id;
	}

	// Reroute internally after successful update etc
	private function reroute($route, $type = null, $id = null) {
		$this->type = $type;
		$this->id = $id;
		$this->$route();
	}

}

?>