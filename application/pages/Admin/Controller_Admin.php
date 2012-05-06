<?php 

class Controller_Admin extends CoreController {

	static private $user = 'admin';
	static private $password = 'test';
	private $login;
	protected $authenticated;


	public function __construct() { 
		
		spl_autoload_register(array($this, 'editloader'), true, true);	

		// Login functionality.
		//----------------------
		$this->login = new Login;
		$this->authenticated = $this->login->userIsAuthenticated();
		//var_dump($this->authenticated);
		//echo ($this->authenticated!==false) ? "inloggad" : "ej inloggad";

		// Basic variables for template
		$this->data['pageId'] = "admin";
		$this->data['title'] = "BMO Admin";
		
	}

	function editloader($className) {
		if (is_file( dirname(__FILE__).SEPARATOR.$className.'.php' )) {
			require_once( dirname(__FILE__).SEPARATOR.$className.'.php' );
		}	
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

		if ($this->authenticated===false) {
			$this->index();
		} else {			
			$type = isset($this->arguments[2]) ? $this->arguments[2] : null;

			// Check for id in $_POST first, then request URL 
			$id = !isset($_POST['editId']) ?  isset($this->arguments[3]) ? $this->arguments[3] : null : $_POST['editId'];
			$editor = new View_Admin_Helper($type, $id, $this->baseUrl);
			$this->data['editView'] = $editor->SetupView();
		}

	}	

	public function add() {
		if ($this->authenticated===false) {
			$this->index();
		} else {			
			$type = isset($this->arguments[2]) ? $this->arguments[2] : null;

			// Check for id in $_POST first, then request URL 
			$id = !isset($_POST['editId']) ?  isset($this->arguments[3]) ? $this->arguments[3] : null : $_POST['editId'];
			$editor = new View_Admin_Helper($type, $id, $this->baseUrl);
			$this->data['editView'] = $editor->SetupView();
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
			$this->data['loginView'] = 	$this->login->userLoginForm(
														$this->baseUrl, 
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