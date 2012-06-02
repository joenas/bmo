<?php 

class View_Objects_Helper {

	public function __construct($baseUrl) {
		$this->baseUrl = $baseUrl;

		$this->db = Database::Instance();
		$this->objects = new Object($this->db);
	}

	// Create html for showing an object
	public function objectView($array) {
		$html = "\n\t<h2 class=object-view-title>".$array['title']."</h2><div class='object-view-content'>";
		$html .= "\n\t<img class=object-view-image src={$this->baseUrl}".str_replace('img/bmo', "img/bmo/250", $array['image'])." alt='".$array['title']."'>";
		$html .= "\n\t<div class='object-view-text'><p>".$array['text']."</p> <p>Ägare: ".$array['owner']."</div></div>";
		return $html;			
	}

	// Create html for showing objects from a category
	public function categoryView($array) {

		$html = "";
		foreach($array as $val) {
			$html .= $this->objectView($val);
			$html .= "<hr class=object-view-spacer>";
		}

		return $html;
	}

	 public function viewSidebar() {
	 	$array = $this->objects->getColumnDistinct('category');
	 	$html = '<h2>Kategorier</h2><ul>';
	 	foreach ($array as $val) {
	 		$html .= "<li><a href={$this->baseUrl}objects/category/".$val['category'].">".$val['category']."</a></li>";
	 	}
	 	$html .= "</ul>";
	 	return $html;

	 }

	public function randomObject() {
		 $query = "SELECT * FROM Object ORDER BY RANDOM() LIMIT 1;";
		 $res = $this->db->ExecuteSelectQueryAndFetchAll($query);

		 return $this->objectView($res[0]);

	}

}