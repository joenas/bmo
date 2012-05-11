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
			$message = isset($this->message) ? $this->message : null;		
			$viewHelper = new View_Admin_Helper('update', $this->type, $this->id, $this->baseUrl);
			$this->data['view'] = $viewHelper->editView($message);
		}

	}	

	// View for adding article or object
	public function add() {

		if ($this->authenticated===false) {
			$this->index();
		} else {
			$this->requestParser();
			$viewHelper = new View_Admin_Helper('add', $this->type, null, $this->baseUrl);
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
					$res = $article->updateArticle($_POST);
					$this->message = "Artikeln har uppdaterats.";
					$this->type = 'article';
					break;

				case "object":
					$object = new Object($db);
					$res = $object->updateObject($_POST['id'], $_POST['title'],$_POST['category'],$_POST['image'],$_POST['owner'],$_POST['text']);
					$this->message = "Objektet har uppdaterats.";
					$this->type = 'object';
					break;
				}
				$this->id = $_POST['id'];
				$this->edit();
		}
	}

	// Deletes from database and redirects to edit View
	public function delete() {
		if ($this->authenticated===false) {
			$this->index();
		}	
		else if ( isset($_POST['delete']) && $_POST['delete']==true) {

			$this->requestParser();
			$db = Database::Instance();

			switch ($_POST['type']) {
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

			unset($this->id, $_POST['id']);
			$this->type = $_POST['type'];
			$this->edit();
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
					$this->type = 'article';
					$this->id = $res;		
				}
				break;

			case "object":
				$object = new Object($db);
				$res = $object->createObject( $_POST['title'], $_POST['category'], 
												$_POST['image'], $_POST['owner'], $_POST['text'] );
				// Insert successful
				if ($res!=='0') {
					$this->message = "Objektet har lagts till.";
					$this->type = "object";
					$this->id = $res;
				}
				break;
			}

			$this->edit();
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
		$this->type = !isset($this->type) ? isset($this->request->arguments[2]) ? $this->request->arguments[2] : null : $this->type;
		// Check for id in $_POST first, then in request URL 		
		$this->id = !isset($this->id) ? !isset($_POST['id']) ?  isset($this->request->arguments[3]) ? $this->request->arguments[3] : null : $_POST['id'] : $this->id;
	}

	// Reroute internally after successful update etc
	private function reroute($callback, $type = null, $id = null) {

	}

}

?>