<?php

class Article extends CoreModel {

	protected $table = 'Article';
	protected $db;

	public $fields = array( 					
							'title' 	=> array('name' => 'title', 'label' => 'Titel', 'type' =>'text', 'tags' => 'inga'),
							'category' 	=> array('name' => 'category', 'label' => '<br>Kategori', 'type' => 'text', 'tags' => 'inga'),
							'author'	=> array('name' => 'author', 'label' => 'Författare','type' =>'text', 'tags' => 'inga'),
							'pubdate'	=> array('name' => 'pubdate', 'label' => 'Datum','type' =>'text', 'tags' => 'inga'),
							'content'	=> array('name' => 'content', 'label' => '', 'type' =>'textarea', 'tags' => '<img><p><b><i><blockquote>')
					);

	 public function __construct($database) {
	 	$this->db = $database;
	 	parent::__construct($database);
	 }

	 public function getByLink($link) {
		$query = 'SELECT * FROM ' . $this->table . " where permalink=?";
		$params[] = $link;
		return $this->db->ExecuteSelectQueryAndFetchAll($query, $params);
	}

	// Create a new article.
  	//-----------------------
  	public function create( array $array ) {

  		// Remove unwanted tags
  		$this->clean($array);
  		extract($array);

			$permalink = $this->slugify($title);

	    $query = "INSERT INTO ".$this->table." (title, category, author, pubdate, content, permalink ) VALUES(?, ?, ?, ?, ?, ?)";
	    $params = array($title, $category, $author, $pubdate, $content, $permalink);
    	$this->db->ExecuteQuery($query, $params);
    	
    	return $this->db->LastInsertId();
  	}


	// Update an article.
	//---------------------
	public function update(array $array) {

		// Remove unwanted tags
		$this->clean($array);
		extract($array);
		
		$permalink = $this->slugify($title);

		$query = "UPDATE ".$this->table." SET title=?, category=?, author=?, pubdate=?, content=?, permalink=? WHERE id='{$id}'";
		$params = array($title, $category, $author, $pubdate, $content, $permalink);
		$this->db->ExecuteQuery($query, $params);
	}

}


?>