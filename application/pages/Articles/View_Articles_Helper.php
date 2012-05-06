<?php 

class View_Articles_Helper {

	public function __construct($baseUrl) {
		$this->baseUrl = $baseUrl;
		$this->db = Database::Instance();
		$this->articles = new Article($this->db);

	}

	// Create html for showing an article
	public function articleView($id) {
			$array = $this->articles->getArticle($id);
			$html = "<h2>".$array[0]['title']."</h2>";
			$html .= str_replace('img/', "{$this->baseUrl}img/", $array[0]['content']);
			$html .= "<span class='articlefooter'> <small>".$array[0]['author']." - Publicerad: </small><span class='date'>".$array[0]['pubdate']."</span></span>";
			return $html;
	}

	// Create a nice list of articles
	public function articleList() {
		$array = $this->articles->getAllArticlesByCategory('article');

		$html = "";
		foreach ($array as $val) {
			$html .= "<h3>".$val['title']."</h3>";	
			//$html .= " <small><em>".$val['author']." - Publicerad: </small><span class='date'>".$val['pubdate']."</span></em>";
			$html .= substr($val['content'], 0, 250)."...";
			$html .= " <a href='{$this->baseUrl}articles/show/".$val['id']."'>Läs mer </a>";
			$html .= "<div class='spacer'></div>";
		}
		return $html;
	}

	// Create html for the sidebar with links
	public function articleSidebar() {
		$array = $this->articles->getAllArticlesByCategory('article');

		$html = "<h2>Artiklar</h2><ul>";
		foreach ($array as $val) {
			$html .= "<li><a href='{$this->baseUrl}articles/show/".$val['id']."'>".$val['title']."</a></li>";
		}
		$html .= "<ul>";
		return $html;
	}
}

?>