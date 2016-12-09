<?php

/**
 * Copyright (C) Daniel Retzl
 */
namespace YAWK {
    /**
     * <b>Database class db</b> <i>extends \mysqli</i>
     * @package YAWK
     */
    final class db extends \mysqli {
        private $config;
        public static $connection;

        /**
         * db constructor.
         */
        public function __construct()
        {
            // TODO: cfg file for installer!
            $this->config['server'] = "localhost";
            $this->config['username'] = "root";
            $this->config['password'] = "";
            $this->config['dbname'] = "yawk_lte";
            $this->config['prefix'] = "cms_";
            $this->config['port'] = "3306";
        }

        /**
         * Connect to the database
         *
         * @return object | bool false on failure / mysqli MySQLi object instance on success
         */
        public function connect()
        {
            // Try and connect to the database
            if (!isset($this->connection)) {
                $this->connection = @new \mysqli($this->config['server'], $this->config['username'], $this->config['password'], $this->config['dbname']);
            }
            // If connection was not successful, die and show the error
            if (mysqli_connect_errno()) {
                die ('Database error: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
            }
            return $this->connection;
        }

        /**
         * query database
         *
         * @param $query | the query string
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
            return $connection->query($query);
        }

        /**
         * Fetch rows from the database (SELECT query)
         *
         * @param $query | The query string
         * @return array | bool on failure
         */
        public function select($query)
        {
            $rows = array();
            $result = $this->query($query);
            if ($result === false) {
                $error = $this->error();
                \YAWK\sys::setSyslog($db, 5, "$error", 0, 0, 0, 0);
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