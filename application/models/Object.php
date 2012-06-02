<?php

class Object extends CoreModel {

	protected $table = 'Object';
	private $db;

	public $fields = array( 
							'category' 	=> array('name' => 'category', 'label' => 'Kategori', 'type' => 'text', 'tags' => 'inga', 'validate' => ''),
							'title' 	=> array('name' => 'title', 'label' => 'Titel', 'type' =>'text', 'tags' => 'inga', 'validate' => 'required'),
							'text'	=> array('name' => 'text', 'label' => 'Text', 'type' =>'text', 'tags' => 'inga', 'validate' => ''),
							'image'	=> array('name' => 'image', 'label' => 'Bildfil', 'type' =>'text', 'tags' => 'inga', 'validate' => 'required'),
							'owner'	=> array('name' => 'owner', 'label' => 'Ägare','type' =>'text', 'tags' => 'inga', 'validate' => '')
					);

	public function __construct($database) {
		$this->db = $database;
		parent::__construct($database);
	}
	
	// Create a new Object.
  //-----------------------
  public function create( array $array ) {

 		// Remove unwanted tags
  	$this->clean($array);
  	extract($array);
  	$permalink = $this->slugify($title);

    $query = "INSERT INTO ".$this->table." (title, category, image, owner, text, permalink) VALUES(?, ?, ?, ?, ?, ?)";
    $params = array($title, $category, $image, $owner, $text, $permalink);
    $this->db->ExecuteQuery($query, $params);
   	return $this->db->LastInsertId();
  }

	// Update an Object.
	//---------------------
	public function update( array $array ) {

		// Remove unwanted tags
  	$this->clean($array);
  	extract($array);
  	$permalink = $this->slugify($title);

		$query = "UPDATE ".$this->table." SET title=?, category=?, image=?, owner=?, text=?, permalink=? WHERE id='{$id}'";
		$params = array($title, $category, $image, $owner, $text, $permalink);
		$this->db->ExecuteQuery($query, $params);
	    
		return $this->db->LastInsertId();
	}

}


?>