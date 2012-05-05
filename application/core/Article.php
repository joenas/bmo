<?php

class Article {

	static private $table = 'Article';
	private $db;

	public function __construct($database) {
		$this->db = $database;
	}

	public function getAllArticles() {
		$query = 'SELECT * FROM ' . self::$table;

		return $this->db->ExecuteSelectQueryAndFetchAll($query);
	} 		
	
	public function getArticle($id) {
		$query = 'SELECT * FROM ' . self::$table . " where id=? or category=?";
		$params[] = $id;
		$params[] = $id;
		return $this->db->ExecuteSelectQueryAndFetchAll($query, $params);
	} 

	
}


?>