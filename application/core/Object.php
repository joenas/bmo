<?php

class Object {

	static private $table = 'Object';
	private $db;

	public function __construct($database) {
		$this->db = $database;
	}

	public function getAllObjects() {
		$query = 'SELECT * FROM ' . $this->table;

		return $this->db->ExecuteSelectQueryAndFetchAll($query);
	} 		
	
	public function getObject($id) {
		$query = 'SELECT * FROM ' . self::$table . ' where id=?';
		$params[] = $id;
		return $this->db->ExecuteSelectQueryAndFetchAll($query, $params);
	} 

	
}


?>