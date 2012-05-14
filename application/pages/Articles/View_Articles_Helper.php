<?php 

class View_Articles_Helper {

	public function __construct($baseUrl) {
		$this->baseUrl = $baseUrl;

		$this->db = Database::Instance();
		$this->articles = new Article($this->db);
	}

	// Create html for showing an article
	public function articleView($link) {
			$array = $this->articles->getByLink($link);

			if (!empty($array)) {
				$html = "<h2>".$array[0]['title']."</h2><div class='content'>";
				$html .= str_replace('img/', "{$this->baseUrl}img/", $array[0]['content']);
				$html .= "</div><span class='articlefooter'> <small>".$array[0]['author']." - Publicerad: </small><span class='date'>".$array[0]['pubdate']."</span></span>";
			} else {
				$html = "<p>Artikeln hittades inte</p>";
			}
			return $html;			
	}

	// Create a nice list of articles
	public function articleList() {
		$array = $this->articles->getAllByIndex('category', 'article');

		$html = "";
		foreach ($array as $val) {
			$html .= "<h3>".$val['title']."</h3>";	
			//$html .= " <small><em>".$val['author']." - Publicerad: </small><span class='date'>".$val['pubdate']."</span></em>";
			$html .= substr($val['content'], 0, 250)."...";
			$html .= " <a href='{$this->baseUrl}articles/show/".$val['permalink']."'>Läs mer </a>";
			$html .= "<div class='spacer'></div>";
		}
		return $html;
	}

	// Create html for the sidebar with links
	public function articleSidebar() {
		$array = $this->articles->getAllByIndex('category', 'article');

		$html = "<h2>Artiklar</h2><ul>";
		foreach ($array as $val) {
			$html .= "<li><a href='{$this->baseUrl}articles/show/".$val['permalink']."'>".$val['title']."</a></li>";
		}
		$html .= "</ul>";
		return $html;
	}

	public function articleImages($link) {

		$article = $this->articles->getByLink($link);
		$objects = new Object($this->db);
		$array = $objects->getAllByIndex('category', $article[0]['imagecategory']);
		
		$html = "<div class=article-image-container style='clear: both;'>Relaterade bilder!";
		$i = 0;
		foreach ($array as $val) {
			$divmain = ($i%2 == 0) ? "</div><div class='articles-image'>" : '';
			$float = ($i%2 == 0) ? "left" : "right";
			$i++;
			$html .= $divmain."\n\t<figure class='articles {$float}'><img class='articles' src='{$this->baseUrl}".str_replace('/bmo/', '/bmo/250/', $val['image'])."' alt='".$val['title']."'";
			//$html .= "\n\t<figcaption class='articles'>".$val['text']."</figcaption></figure>";
			$html .= "title='".$val['text']."'>\n\t<figcaption class='articles'>".$val['text']."</figcaption></figure>";
		}
		$html .= "</div>";
	
		return $html;

	}
}

?>