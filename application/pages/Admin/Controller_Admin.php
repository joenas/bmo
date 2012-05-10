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
		$this->data['pageStyle'] = "header.logo { display: none; }"; 
		
	}

	// Default View
	public function index() {

		// User not logged in
		if ($this->authenticated===false) {
				// Default action, show the login form
				$this->data['loginView'] = $this->login->userLoginForm($this->baseUrl);
		} 
		// User is logged in
		else {
			$this->data['loginView'] = "<p>Du är nu inloggad. Välj en funktion till höger.</p>";
		}
	}

	// Editor view, requires that user is logged in
	public function edit() {

		//var_dump($_POST);

		if ($this->authenticated===false) {
			$this->index();
		} else {
			$message = isset($this->message) ? $this->message : null;
			$type = isset($this->arguments[2]) ? $this->arguments[2] : null;

			// Check for id in $_POST first, then in request URL 
			$id = !isset($_POST['editId']) ?  isset($this->arguments[3]) ? $this->arguments[3] : null : $_POST['editId'];
			//$action = (isset($id)) ? 'update' : 'edit';
			$viewHelper = new View_Admin_Helper('update', $type, $id, $this->baseUrl);
			$this->data['editView'] = $viewHelper->EditorView($message);
		}

	}	

	public function add() {

		if ($this->authenticated===false) {
			$this->index();
		} else if (isset($this->arguments[2])) {
			$type = $this->arguments[2];

			$viewHelper = new View_Admin_Helper('add', $type, null, $this->baseUrl);
			$this->data['addView'] = $viewHelper->addView();
		}		
	}

	//($id, $title, $category, $author, $pubdate, $content)
	public function update() {

		if ($this->authenticated===false || !isset($_POST['save'])) {
			$this->index();
		}	else if ( isset($_POST['save']) && $_POST['save']==true) {
			$db = Database::Instance();
			$article = new Article($db);
			$res = $article->updateArticle($_POST['id'], $_POST['title'],$_POST['category'],$_POST['author'],$_POST['pubdate'],$_POST['content']);
			$this->message = "Artikeln har uppdaterats.";
			$this->arguments[2] = 'article';
			$this->arguments[3] = $_POST['id'];
			$this->edit();
		}
	}

	public function delete() {
		if ($this->authenticated===false) {
			$this->index();
		}	else if ( isset($_POST['delete']) && $_POST['delete']==true) {
			$db = Database::Instance();
			switch ($_POST['type']) {
				case "article";
					$article = new Article($db);
			}
			$object = ($_POST['type']=='article') ? new Article($db) : new Object($db);
			
		}
	}

	public function insert() {
		if ($this->authenticated===false) {
			$this->index();
		} else if (isset($_POST['save']) && $_POST['save']==true) { 
			$db = Database::Instance();
			$article = new Article($db);
			$res = $article->createArticle( $_POST['title'], $_POST['category'], 
																			$_POST['author'], $_POST['pubdate'], $_POST['content'] );
			if ($res!=='0') {
				$this->message = "Artikeln har uppdaterats.";
				$this->arguments[2] = 'article';
				$this->arguments[3] = $_POST['id'];
				$this->edit();
			}
			else {
				;
			}
			var_dump($res);
			var_dump($_POST);
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
			$this->data['loginView'] = 	$this->login->userLoginForm($this->baseUrl, 
																	"Du lyckades ej logga in. Felaktigt konto eller lösenord.", 
																	"error"
																	);
		}

	}
	
	// Logout
	public function logout() {
			$this->login->userLogout();
			$this->redirectPage('admin');
	}

}

?>