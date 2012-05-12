<?php

class CoreModel {

	private $db;
	protected $table;

	public function __construct($database) {
		$this->db = $database;
	}

	public function getAll() {
		$query = 'SELECT * FROM ' . $this->table;
		return $this->db->ExecuteSelectQueryAndFetchAll($query);
	} 		
	
	public function getById($id) {
		$query = 'SELECT * FROM ' . $this->table . " where id=?";
		$params[] = $id;
		return $this->db->ExecuteSelectQueryAndFetchAll($query, $params);
	} 

	public function getAllByIndex($index, $search) {
		$query = 'SELECT * FROM ' . $this->table . " where {$index}=?";
		$params[] = $search;
		return $this->db->ExecuteSelectQueryAndFetchAll($query, $params);
	}

	//----------------------
	public function deleteById($id) {
  
		$query = "DELETE FROM ".$this->table." WHERE id='$id'";
		$this->db->ExecuteQuery($query);
	}
	
	protected function slugify($string){
		$string = mb_strtolower(trim($string),'UTF-8');
		$string = str_replace(array('å', 'ä', 'ö'), array('a', 'a', 'o'), $string);
		$string = preg_replace('/[^a-z0-9-]/', '-', $string);
		$string = preg_replace('/-+/', "-", $string);
		return $string;
  }

	protected function clean(&$array) {
		foreach ($array as $key => $val ) {
			if (array_key_exists($key, $this->fields)) {
				$array[$key] = strip_tags($val, $this->fields[$key]['tags']);
			}
		}
	}
}


?>