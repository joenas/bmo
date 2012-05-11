<?php

class Article {

	static private $table = 'Article';
	private $db;
	public $fields = array( 					
							'title' 	=> array('name' => 'title', 'label' => 'Titel', 'type' =>'text', 'tags' => ''),
							'category' 	=> array('name' => 'category', 'label' => '<br>Kategori', 'type' => 'text', 'tags' => ''),							
							'author'	=> array('name' => 'author', 'label' => 'Författare','type' =>'text', 'tags' => ''),
							'pubdate'	=> array('name' => 'pubdate', 'label' => 'Datum','type' =>'text', 'tags' => ''),
							'content'	=> array('name' => 'content', 'label' => '', 'type' =>'textarea', 'tags' => '<img><p><b><i><blockquote>')
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
/*  	public function createArticle( $title, $category, $author, $pubdate, $content ) {

		$permalink = $this->slugify($title);

	    $query = "INSERT INTO ".self::$table." (title, category, author, pubdate, content, permalink ) VALUES(?, ?, ?, ?, ?, ?)";
	    $params = array($title, $category, $author, $pubdate, $content, $permalink);
    	$this->db->ExecuteQuery($query, $params);
    	return $this->db->LastInsertId();
  	}
*/
	// Create a new article.
  	//-----------------------
  	public function createArticle( array $array ) {

  		// Remove unwanted tags
  		$this->clean($array);

  		extract($array);
		$permalink = $this->slugify($title);

	    $query = "INSERT INTO ".self::$table." (title, category, author, pubdate, content, permalink ) VALUES(?, ?, ?, ?, ?, ?)";
	    $params = array($title, $category, $author, $pubdate, $content, $permalink);
    	$this->db->ExecuteQuery($query, $params);
    	
    	return $this->db->LastInsertId();
  	}


	// Update an article.
	//---------------------
	public function updateArticle(array $array) {

		// Remove unwanted tags
		$this->clean($array);
		extract($array);
		$permalink = $this->slugify($title);

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
	
	private function slugify($string){
		$string = mb_strtolower(trim($string),'UTF-8');
		$string = str_replace(array('å', 'ä', 'ö'), array('a', 'a', 'o'), $string);
		$string = preg_replace('/[^a-z0-9-]/', '-', $string);
		$string = preg_replace('/-+/', "-", $string);
		return $string;
  }

	private function clean(&$array) {
		foreach ($array as $key => $val ) {
			if (array_key_exists($key, $this->fields)) {
				$array[$key] = strip_tags($val, $this->fields[$key]['tags']);
			}
		}
	}
}


?>