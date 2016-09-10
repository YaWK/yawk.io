<?php 

/**
 * Database wrapper for a MySQL with PHP tutorial
 * 
 * @copyright Eran Galperin
 * @license MIT License
 * @see http://www.binpress.com/tutorial/using-php-with-mysql-the-right-way/17
 */
namespace YAWK {
	final class db extends \mysqli {
		private $config;
		public static $connection;

		public function __construct()
		{
			$this->config['username'] = "root";
			$this->config['password'] = "";
			$this->config['dbname'] = "yawk_lte";
			$this->config['prefix'] = "cms_";
		}

		/**
		 * Connect to the database
		 *
		 * @return bool false on failure / mysqli MySQLi object instance on success
		 */

		public function connect()
		{
			// Try and connect to the database
			if (!isset($this->connection)) {
				$this->connection = new \mysqli('localhost', $this->config['username'], $this->config['password'], $this->config['dbname']);
			}
			// If connection was not successful, handle the error
			if ($this->connection === false) {
				// Handle error - notify administrator, log to a file, show an error screen, etc.
				return false;
			}
			return $this->connection;
		}

        /**
		 * query database
		 *
		 * @param $query the query string
		 * @return mixed The result of the mysqli::query() function
		 */
		public function query($query)
		{
			// connect to the database
			$connection = $this->connect();
			// replace {} in str for db prefix
            $query = str_replace("}", "", $query);
            $query = str_replace("{", $this->config['prefix'], $query);
			// query the database
			$result = $connection->query($query);

			return $result;
		}

		/**
		 * Fetch rows from the database (SELECT query)
		 *
		 * @param $query The query string
		 * @return bool False on failure / array Database rows on success
		 */
		public function select($query)
		{
			$rows = array();
			$result = $this->query($query);
			if ($result === false) {
				return false;
			}
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}
			return $rows;
		}

		/**
		 * Fetch the last error from the database
		 *
		 * @return string Database error message
		 */
		public function error()
		{
			$connection = $this->connect();
			return $connection->error;
		}

		/**
		 * Quote and escape value for use in a database query
		 *
		 * @param string $value The value to be quoted and escaped
		 * @return string The quoted and escaped string
		 */
		public function quote($value)
		{
			$connection = $this->connect();
			return $connection->real_escape_string($value);
		}
	} // ./dbclass
}// ./namespace