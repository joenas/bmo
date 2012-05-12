<?php

class Object extends CoreModel {

	protected $table = 'Object';
	private $db;

	public $fields = array( 
							'category' 	=> array('name' => 'category', 'label' => 'Kategori', 'type' => 'text', 'tags' => 'inga'),
							'title' 	=> array('name' => 'title', 'label' => 'Titel', 'type' =>'text', 'tags' => 'inga'),
							'text'	=> array('name' => 'text', 'label' => 'Text', 'type' =>'text', 'tags' => 'inga'),
							'image'	=> array('name' => 'image', 'label' => 'Bildfil', 'type' =>'text', 'tags' => 'inga'),
							'owner'	=> array('name' => 'owner', 'label' => 'Ägare','type' =>'text', 'tags' => 'inga')
					);

	public function __construct($database) {
		$this->db = $database;
		parent::__construct($database);
	}
	
	// Create a new Object.
  	//-----------------------
  	public function create( $title, $category, $image, $owner, $text ) {

	    $query = "INSERT INTO ".$this->table." (title, category, image, owner, text) VALUES(?, ?, ?, ?, ?)";
	    $params = array($title, $category, $image, $owner, $text);
    	$this->db->ExecuteQuery($query, $params);
    	return $this->db->LastInsertId();
  	}

	// Update an Object.
	//---------------------
	public function update($id, $title, $category, $image, $owner, $text) {

		$query = "UPDATE ".$this->table." SET title=?, category=?, image=?, owner=?, text=? WHERE id='{$id}'";
		$params = array($title, $category, $image, $owner, $text);
		$this->db->ExecuteQuery($query, $params);
	    
		return $this->db->LastInsertId();
	}

}


?>