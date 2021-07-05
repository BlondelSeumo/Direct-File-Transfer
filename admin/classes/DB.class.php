<?php 

/*==========================================================================
 * Copyright (c) 2020
 * =========================================================================
 * 
 *
 * Project: Upload & Share
 * Author: Berkine 
 * Version: 1.0.0
 * 
 * 
 * =========================================================================
 */

include_once __DIR__ . "/../core/dbconfig.core.php";

class DB {

	# Local variables
	private static $_instance = null;
	private $_pdo; 				# PDO object
	private	$_query;			# Last query executed
	private $_error = false;	# Whether query failed or not
	private $_results;			# Result set of query
	private $_count = 0;		# Check if any result returned or not


	/**
 	*
 	* Constructor
 	*
 	*/
	private function __construct() {
		try {

			$this->_pdo = new PDO('mysql:host=' . DBSERVER . ';dbname='  . DBNAME, DBUSER, DBPASSWORD);

		} catch (PDOException $e) {
			die($e->getMesage());
		}
	}


	/**
 	*
 	* Singleton method
 	* @return db class instance
 	*
 	*/
	public static function getInstance() {
		if (!isset(self::$_instance)) {
			self::$_instance = new DB();
		}

		return self::$_instance;

	}


	/**
 	*
 	* Execute SQL Query Securely
 	* @param sql query
 	* @return results
 	*
 	*/
	public function query($sql, $params = array()) {
		$this->_error = false;
		if ($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if (count($params)) {
				foreach ($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}

		return $this;
	}


	/**
 	*
 	* Actions that you want to execute on db
 	* @param action, table name, where clause 
 	* @return results
 	*
 	*/
	private function action($action, $table, $where = array()) {
		if (count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=');

			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];

			if (in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

				if (!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}

		return false;
	}


	/**
 	*
 	* Get method
 	* @param table name, where clause 
 	* @return results from action method
 	*
 	*/
	public function get($table, $where) {
		return $this->action('SELECT *', $table, $where);
	}


	/**
 	*
 	* Process general queries
 	* @param sql query
 	* @return results from action method
 	*
 	*/
	public function generalQuery($sql) {
		if ($this->_query = $this->_pdo->prepare($sql)) {
			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll();
				$this->_count = $this->_query->rowCount();
			}
		}
	}


	/**
 	*
 	* Delete method
 	* @param table name, where clause 
 	* @return results from action method
 	*
 	*/
	public function delete($table, $where) {
		return $this->action('DELETE ', $table, $where);
	}


	/**
 	*
 	* Insert method
 	* @param table name, where clause 
 	* @return results from action method
 	*
 	*/
	public function insert($table, $fields = array()) {
		
		$keys = array_keys($fields);
		$values = '';
		$x = 1;

		foreach($fields as $field) {
			$values .= '?';
			if ($x < count($fields)) {
				$values .= ',';
			}
			$x++;
		}

		$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

		if (!$this->query($sql, $fields)->error()) {
			return true;
		}
		
		return false;
	}


	/**
 	*
 	* Update method
 	* @param table name, id value, update fields 
 	* @return results from action method
 	*
 	*/
	public function update($table, $id, $fields) {
		$set = '';
		$x = 1;

		foreach($fields as $name => $value) {
			$set .= "{$name} = ?";
			if ($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

		if (!$this->query($sql, $fields)->error()) {
			return true;
		}

		return false;
	}


	/**
 	*
 	* Results method
 	* @return results 
 	*
 	*/
	public function results() {
		return $this->_results;
	}


	/**
 	*
 	* First method
 	* @return first result of the query 
 	*
 	*/
	public function first() {
		return $this->results()[0];
	}


	/**
 	*
 	* Error method
 	* @return $_error
 	*
 	*/
	public function error() {
		return $this->_error;
	}


	/**
 	*
 	* Count method
 	* @return actual number of results
 	*
 	*/
	public function count() {
		return $this->_count;
	}
}