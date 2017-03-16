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
            require_once ("dbconfig.php");
        }

        /**
         * Connect to the database
         *
         * @return object | bool false on failure / mysqli MySQLi object instance on success
         */
        public function connect()
        {
            // Try and connect to the database
            if (!isset($this->connection))
            {
                $this->connection = new \mysqli($this->config['server'], $this->config['username'], $this->config['password'], $this->config['dbname'], $this->config['port']);
                if (!$this->connection)
                {
                    return false;
                }
                else
                    {
                        return $this->connection;
                    }
            }
            else
                {
                    return $this->connection;
                }
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
            if ($connection = $this->connect())
            {   // if connection is successful
                // replace {} in str for db prefix
                $query = str_replace("}", "", $query);
                $query = str_replace("{", $this->config['prefix'], $query);
                // query the database
                return $connection->query($query);
            }
            else
                {   // could not connect to database, exit with error
                    die ('Database error: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
                }
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

        public function import($sqlfile, $lang)
        {
            // http://stackoverflow.com/questions/19751354/how-to-import-sql-file-in-mysql-database-using-php
            if (!isset($sqlfile) || (empty($sqlfile)))
            {
                $filename = 'database.sql';
            }
            else
                {
                    $filename = $sqlfile;
                }
            // filename
            $maxRuntime = 8; // less then your max script execution limit

            $deadline = time()+$maxRuntime;
            $progressFilename = $filename.'_filepointer'; // tmp file for progress
            $errorFilename = $filename.'_error'; // tmp file for erro

            ($fp = fopen($filename, 'r')) OR die('failed to open file:'.$filename);

            // check for previous error
            if(file_exists($errorFilename) )
            {
               // die('<pre> previous error: '.file_get_contents($errorFilename));
            }

            // go to previous file position
            $filePosition = 0;
            if(file_exists($progressFilename))
            {
                $filePosition = file_get_contents($progressFilename);
                fseek($fp, $filePosition);
            }

            $queryCount = 0;
            $query = '';
            while($deadline>time() AND ($line=fgets($fp, 1024000)))
            {
                if(substr($line,0,2)=='--' OR trim($line)=='' )
                {
                    continue;
                }

                $query .= $line;
                if( substr(trim($query),-1)==';' )
                {
                    if(!$this->query($query))
                    {
                       $error = 'Error performing query \'<strong>' . $query . '\': ' . mysqli_error($this);
                       file_put_contents($errorFilename, $error."\n");
                       //exit;
                    }
                    $query = '';
                    file_put_contents($progressFilename, ftell($fp)); // save the current file position for
                    $queryCount++;
                }
            }

            $status = '';
            if(feof($fp))
            {
                $status .= "$lang[DB_IMPORT_OK]";
            }
            else
                {
                    $status .= ftell($fp).'/'.filesize($filename).' '.(round(ftell($fp)/filesize($filename), 2)*100).'%'."\n";
                    $status .= $queryCount." $lang[DB_QUERIES_PROCESSED]";
                }
            return $status;
        } // ./ import


        public function deleteDatabase($database)
        {
            $result = $this->query("SHOW TABLES IN `$database`");
            // $result = mysqli_query($db, "SHOW TABLES IN `$databaseName`");
            while ($table = mysqli_fetch_array($result))
            {
                $tableName = $table[0];
                if ($this->query("TRUNCATE TABLE `$database`.`$tableName`"))
                {
                    echo "$tableName was cleared <br>";
                }
                else
                    {
                        echo mysqli_errno($this). ' ' . mysqli_error($this).'<br>';
                    }
            }
        }

    } // ./dbclass
}// ./namespace