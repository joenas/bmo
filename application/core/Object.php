<?php

class Object {

	static private $table = 'Object';
	private $db;

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
	
}


?>