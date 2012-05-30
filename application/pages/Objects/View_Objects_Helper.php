<?php 

class View_Objects_Helper {

	public function __construct($baseUrl) {
		$this->baseUrl = $baseUrl;

		$this->db = Database::Instance();
		$this->objects = new Object($this->db);
	}

	// Create html for showing an article
	public function objectView($array) {
				$html = "<h2 class=object-view-title>".$array['title']."</h2><div class='content'>";
				$html .= "<img class=object-view-image src={$this->baseUrl}".str_replace('img/bmo', "img/bmo/250", $array['image']).">";
				$html .= "<span class='object-view-text'> <small>".$array['text']." - Ägare: </small>".$array['owner']."</span></div>";
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

	/*public function viewSidebar() {
		$categories = $this->objects->getColumnDistinct('category');
		$objects = $this->objects->getAll();

		$html = '<h2>Kategorier</h2><div id=categories-accordion>';
		
		foreach ($categories as $val) {
			$html .= "\n\t<a href='#'>".$val['category']."</a>";
			$html .= "\n\t\t<div>";
			foreach ($objects as $array) {
			  if ($array['category']==$val['category']) {
			  	$html .= "<a href={$this->baseUrl}".$array['permalink'].">".$array['title']."</a><br>";
			  	//$html .= $array['title']."<br>";
			  }
			}
			$html .= "</div>";
		}
		
		$html .= "</ul></div>";
		ViewHelper::Instance()->jsDocumentReadyFunction("$(function() {
		$( '#categories-accordion' ).accordion({
			autoHeight: false,
			navigation: true
		});
	});");
		return $html;

	}*/
}