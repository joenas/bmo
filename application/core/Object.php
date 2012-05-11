<?php

class Object {

	static private $table = 'Object';
	private $db;

	public $fields = array( 
							'category' 	=> array('name' => 'category', 'label' => 'Kategori', 'type' => 'text'),
							'title' 	=> array('name' => 'title', 'label' => 'Titel', 'type' =>'text'),
							'text'	=> array('name' => 'text', 'label' => 'Text', 'type' =>'text'),
							'image'	=> array('name' => 'image', 'label' => 'Bildfil', 'type' =>'text'),
							'owner'	=> array('name' => 'owner', 'label' => 'Ägare','type' =>'text')							
					);

	public function __construct($database) {
		$this->db = $database;
	}

	public function getAllObjects() {
		$query = 'SELECT * FROM ' . self::$table;
		return $this->db->ExecuteSelectQueryAndFetchAll($query);
	} 		
	
	public function getObject($id) {
		$query = 'SELECT * FROM ' . self::$table . " where id=? or category=?";
		$params[] = $id;
		return $this->db->ExecuteSelectQueryAndFetchAll($query, $params);
	} 
	
	// Create a new Object.
  	//-----------------------
  	public function createObject( $title, $category, $image, $owner, $text ) {

	    $query = "INSERT INTO ".self::$table." (title, category, image, owner, text) VALUES(?, ?, ?, ?, ?)";
	    $params = array($title, $category, $image, $owner, $text);
    	$this->db->ExecuteQuery($query, $params);
    	return $this->db->LastInsertId();
  	}

	// Update an Object.
	//---------------------
	public function updateObject($id, $title, $category, $image, $owner, $text) {

		$query = "UPDATE ".self::$table." SET title=?, category=?, image=?, owner=?, text=? WHERE id='{$id}'";
		$params = array($title, $category, $image, $owner, $text);
		$this->db->ExecuteQuery($query, $params);
	    
		return $this->db->LastInsertId();
	}

  	// Delete an Object.
	//----------------------
	public function deleteObject($id) {
  
		$query = "DELETE FROM ".self::$table." WHERE id='$id'";
		$this->db->ExecuteQuery($query);
	}	
}


?>