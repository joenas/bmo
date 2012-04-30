<?php

class Database {
	
	private $dataPath;
	private $isWritable;
	private $dirIsWritable;
	private $db = null;
	private $stmt = null;
	private static $numQueries = 0;
	private static $queries = array();	

	public function __construct() {

		$this->dataPath = ROOT.DB_PATH;
//		$this->dataPath = rtrim($this->$dataPath, '/');
		$this->isWritable = is_writable($this->dataPath);
		$this->dirIsWritable = is_writable(dirname($this->dataPath));

		if (is_file($this->dataPath)) // Database exists, open connection
		{
			$this->db = new PDO('sqlite:'.$this->dataPath);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // Display errors, but continue script
		}

	}

	public function isWritable() {
		return $this->isWritable;
	}

	public function dirIsWritable() {
		return $this->dirIsWritable;
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