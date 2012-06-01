<?php 

class Controller_Search extends CoreController {

	protected $data;	

	public function __contruct() { 

	}

	public function getData() {
		$this->data['title'] = "Sökresultat";
		$this->data['pageStyle'] = '';

		return $this->data;

	}

	public function index() {

		$db = Database::Instance();

		$this->data['view_title'] = "Sökresultat";
		//$this->data['view_content'] = "<p>Inget hittades</p>";

		//

		if (isset($_POST['search'])) {
			$search = strip_tags(trim($_POST['search']));

			if (strlen($search) < 3 ) {
				$this->data['view_content'] = "<p>Söksträngen måste vara längre än 3 tecken</p>";
			} else {
				$found = false;
				$this->data['view_content'] = "";

				$db = Database::Instance();
				$query = "SELECT * FROM Article WHERE category='article' AND content LIKE '%{$search}%' OR title LIKE '%{$search}%';";
				$res = $db->ExecuteSelectQueryAndFetchAll($query);	
				//var_dump($res);			

				if (!empty($res)) {
					$found = true;
					$html = '<h3>Artiklar</h3>';
					foreach ($res as $val ) {
						$html .= "<p class=search-result><a href={$this->baseUrl}articles/show/".$val['permalink'].">".$val['title']."</a></p>";
					}
					$this->data['view_content'] .= $html;
				}

				$query = "SELECT * FROM Object WHERE text LIKE '%{$search}%' OR title LIKE '%{$search}%';";
				$res = $db->ExecuteSelectQueryAndFetchAll($query);
				if (!empty($res)) {
					$found = true;
					$html = "<h3>Objekt</h3>";
					foreach ($res as $val) {
						$html .= "<p class=search-result><a href={$this->baseUrl}objects/show/".$val['permalink'].">".$val['title']."</a></p>";
					}
					$this->data['view_content'] .= $html;
				}

				if ($found===false) {
					$this->data['view_content'] = "Inga artiklar eller objekt matchade sökningen.</p>";
				}
			}

		} else {
			$this->data['view_content'] = "<p>Ingen sökning gjordes.</p>";
		}

	}
	
}

?>