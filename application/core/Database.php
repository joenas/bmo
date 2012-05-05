<?php

class Database {
	
	private $db = null;
	private $stmt = null;
	private static $numQueries = 0;
	private static $queries = array();	
	private static $instance;

	public static function Instance() {
		if(self::$instance == null) {
			self::$instance = new Database(DSN);
		}
		return self::$instance;
	}

	private function __construct($dsn, $username = null, $password = null, $driver_options = null) {
		try { 
			$this->db = new PDO($dsn, $username, $password, $driver_options);
		} catch (PDOException $e) {
    	echo 'Connection failed: ' . $e->getMessage();
		}
	}

	/**
 	* Getters
 	*/
	public function GetNumQueries() { return self::$numQueries; }
	public function GetQueries() { return self::$queries; }


	/**
	* Execute a select-query with arguments and return the resultset.
	*/
	public function ExecuteSelectQueryAndFetchAll($query, $params=array()) {
		
		$this->stmt = $this->db->prepare($query);
		self::$queries[] = $query; 
		self::$numQueries++;
		$this->stmt->execute($params);
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}


	/**
	* Execute a SQL-query and ignore the resultset.
	*/
	public function ExecuteQuery($query, $params = array()) {
		$this->stmt = $this->db->prepare($query);
		self::$queries[] = $query; 
		self::$numQueries++;
		return $this->stmt->execute($params);
	}


	/**
	* Return last insert id.
	*/
	public function LastInsertId() {
		return $this->db->lastInsertid();
	}


	/**
	* Return rows affected of last INSERT, UPDATE, DELETE
	*/
	public function RowCount() {
		return is_null($this->stmt) ? $this->stmt : $this->stmt->rowCount();
	}

}