<?php

class Article {

	static private $table = 'Article';
	private $db;
	public $fields = array( 					
							'title' 	=> array('name' => 'title', 'label' => 'Titel', 'type' =>'text'),
							'category' 	=> array('name' => 'category', 'label' => '<br>Kategori', 'type' => 'text'),							
							'author'	=> array('name' => 'author', 'label' => 'Författare','type' =>'text'),
							'pubdate'	=> array('name' => 'pubdate', 'label' => 'Datum','type' =>'text'),
							'content'	=> array('name' => 'content', 'label' => '', 'type' =>'textarea')
							/*,
							'permalink'	=> array('name' => 'permalink', 'label' => 'permalänk', 'type' =>'text')*/
					);

	public function __construct($database) {
		$this->db = $database;
	}

	public function getAllArticles() {
		$query = 'SELECT * FROM ' . self::$table;

		return $this->db->ExecuteSelectQueryAndFetchAll($query);
	} 		
	
	public function getArticle($link, $search = 'id') {
		$query = 'SELECT * FROM ' . self::$table . " where {$search}=?";
		$params[] = $link;
		return $this->db->ExecuteSelectQueryAndFetchAll($query, $params);
	} 

	public function getAllArticlesByCategory($category) {
		$query = 'SELECT * FROM ' . self::$table . " where category=?";
		$params[] = $category;
		return $this->db->ExecuteSelectQueryAndFetchAll($query, $params);
	}


	// Create a new article.
  	//-----------------------
  	public function createArticle( $title, $category, $author, $pubdate, $content ) {

    	//$title = basename(trim(strip_tags($title)));
			$permalink = $this->slugify($title);

	    $query = "INSERT INTO ".self::$table." (title, category, author, pubdate, content, permalink ) VALUES(?, ?, ?, ?, ?, ?)";
	    $params = array($title, $category, $author, $pubdate, $content, $permalink);
    	$this->db->ExecuteQuery($query, $params);
    	return $this->db->LastInsertId();
  	}

	// Update an article.
	//---------------------
	public function updateArticle($id, $title, $category, $author, $pubdate, $content) {
		$permalink = $this->slugify($title);

		// Remove unwanted tags
		$query = "UPDATE ".self::$table." SET title=?, category=?, author=?, pubdate=?, content=?, permalink=? WHERE id='{$id}'";
		$params = array($title, $category, $author, $pubdate, $content, $permalink);
		$this->db->ExecuteQuery($query, $params);
	    
		return $this->db->LastInsertId();
	}

  	// Delete an article.
	//----------------------
	public function deleteArticle($id) {
  
		$query = "DELETE FROM ".self::$table." WHERE id='$id'";
		$this->db->ExecuteQuery($query);
	}
	
	function slugify($string){
		$string = mb_strtolower(trim($string),'UTF-8');
		$string = str_replace(array('å', 'ä', 'ö'), array('a', 'a', 'o'), $string);
		$string = preg_replace('/[^a-z0-9-]/', '-', $string);
		$string = preg_replace('/-+/', "-", $string);
		return $string;
  }
}


?>