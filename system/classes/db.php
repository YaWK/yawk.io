<?php
namespace YAWK
{
    use Exception;
    /**
     * @details <b>Database class - connect to mysqli and return connection object</b>
     * <p>This class establish the database connection if none already exists.
     * It serves some handy methods as well, like quote data, get and delete tables,
     * import .sql files, as well as typical select and query methods. </p>
     *
     * @author     Daniel Retzl <danielretzl@gmail.com>
     * @copyright  2012-2018 Daniel Retzl yawk.io
     * @license    https://opensource.org/licenses/MIT
     * @version    1.0.0
     * @brief Mysqli database class; returns db connection object
     */
    class db {

        /** @param array $config mysql configuration (host, username, database etc...) */
        public $config;
        /** @param object $connection holds the mysqli database connection */
        public $connection;

        /**
         * db constructor - Include the database config file
         */
        public function __construct()
        {   // include config array
            $fullPathToConfigFile = __dir__.'/dbconfig.php';
            if (!is_file($fullPathToConfigFile))
            {   // db config file not found.
                die('The Database configuration file is missing. It has been created during the installation process, but it is not reachable.');
            }
            else
            {   // include config file
                require_once ($fullPathToConfigFile);
            }
        }

        /**
         * @brief Connect to the database
         * @return object|bool false on failure / mysqli MySQLi object instance on success
         * @throws Exception
         */
        public function connect(): object|bool
        {
            // if connection is not set
            if (!isset($this->connection))
            {
                try {
                    // create new database object
                    $this->connection = new \mysqli(
                        $this->config['server'],
                        $this->config['username'],
                        $this->config['password'],
                        $this->config['dbname'],
                        $this->config['port']
                    );
                    // connection established successfully
                    return $this->connection;
                } catch (\mysqli_sql_exception $e) {
                    // failed to connect to database (wrong credentials?)
                    throw new Exception('Failed to connect to database: ' . $e->getMessage());
                } catch (Exception $e) {
                    throw new Exception('Database connection error: ' . $e->getMessage());
                }
            }
            else
            {
                // connection already established...
                return $this->connection;
            }
        }

        public function close(): void
        {
            $this->connection->close();
        }

        /**
         * @throws Exception
         */
        public function beginTransaction(): void
        {
            $this->connection->begin_transaction();
        }

        public function multi_query($query)
        {   // query database
            return $this->connection->multi_query($query);
        }

        public function prepare($sql)
        {   // prepare statement
            return $this->connection->prepare($sql);
        }

        public function commit(): void
        {   // commit transaction
            $this->connection->commit();
        }

        public function real_escape_string($migrationSql){
            return $this->connection->real_escape_string($migrationSql);
        }

        /**
         * Rollback the current transaction
         *
         * @return bool true if rollback succeeded, false otherwise
         */
        public function rollback()
        {
            try
            {
                while ($this->connection->more_results())
                {
                    $this->connection->next_result();
                }

                // Rollback the transaction
                $result = $this->connection->rollback();

                if ($result)
                {   // Rollback succeeded
                    return true;
                }

            }
            catch (\Exception $e)
            {
                // An exception was thrown, so rollback failed
                return false;
            }
            return false;
        }

        /**
         * @brief Move to next result set of a multi query
         * @return bool
         */
        public function next_result()
        {
            if (method_exists($this->connection, 'next_result'))
            {
//                sys::setSyslog($this->connection, 53, 0, "next result called", 0, 0, 0, 0);
                return $this->connection->next_result();
            }
            else
            {
                // Free any active result sets
                while ($this->more_results() && $this->connection->next_result()) {
//                    sys::setSyslog($this->connection, 53, 0, "free any active result sets", 0, 0, 0, 0);
                }
                return true;
            }
        }

        /**
         * @brief Checks if there are more query results from a multi query
         * @return bool
         */
        public function more_results(): bool
        {
            if (method_exists($this->connection, 'more_results'))
            {
//                sys::setSyslog($this->connection, 53, 0, "more migration results available", 0, 0, 0, 0);
                return $this->connection->more_results() && $this->connection->next_result() && $this->connection->store_result();
            }
            else
            {
                return false;
            }
        }

        /**
         * Clear all pending result sets after a multi-query
         * @return bool true if successful, false otherwise
         */
        public function clearResults()
        {
            try
            {
                // Check if there are more result sets available
                while ($this->connection->more_results() && $this->connection->next_result())
                {
                    // Store the current result set
                    $result = $this->connection->store_result();

                    // Free the current result set
                    if ($result !== false)
                    {
                        $result->free();
                    }
                }

                return true;
            }
            catch (\Exception $e)
            {
                error_log("Error clearing result sets: " . $e->getMessage());
                return false;
            }
        }




        /**
         * @brief Execute any sql query
         * @param string $query the sql query string
         * @return mixed The mysqli result
         */
        public function query($query)
        {
            // connect to database
            if ($this->connection = $this->connect())
            {
                // if connection is successful

                // replace {} in str to add table prefix
                $query = str_replace("}", "", $query);
                $query = str_replace("{", $this->config['prefix'], $query);

                // query database
                return $this->connection->query($query);
            }
            else
                {   // could not connect to database, exit with error
                    die ('Database error: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
                }
        }

        /**
         * @brief Fetch rows from database (SELECT query)
         * @param string $query the sql query string
         * @return array|bool on failure
         */
        public function select($query)
        {
            // init result rows array
            $rows = array();
            // query database
            $result = $this->query($query);
            // check if result is false
            if ($result === false)
            {
                // $error = $this->error();
                //\YAWK\sys::setSyslog($db, 5, "$error", 0, 0, 0, 0);
                return false;
            }
            else
            {   // fetch associative result
                while ($row = $result->fetch_assoc())
                {   // fill array
                    $rows[] = $row;
                }
            }
            // check if result rows array is set
            if (isset($rows) && (!empty($rows) && (is_array($rows))))
            {   // ok, return result rows
                return $rows;
            }
            else
                {   // no result set
                    return false;
                }
        }

        /**
         * @brief Fetch last error from the database
         * @return string database error
         */
        public function error()
        {
            // connect to database
            $this->connection = $this->connect();
            // return latest error
            return $this->connection->error;
        }

        /**
         * @brief Quote and escape value for use in a database query         *
         * @param string $value the value to be quoted and escaped
         * @return string the quoted and escaped string
         */
        public function quote($value)
        {
            // connect to database
            $this->connection = $this->connect();
            // escape and return string
            return $this->connection->real_escape_string($value);
        }

        /**
         * @brief Import data from .sql file into database
         * @param $sqlfile
         * @param $lang
         * @return bool
         */
        public function import($sqlfile, $lang)
        {
            // http://stackoverflow.com/questions/19751354/how-to-import-sql-file-in-mysql-database-using-php
            if (!isset($sqlfile) || (empty($sqlfile)))
            {
                $filename = 'yawk_database.sql';
            }
            else
                {
                    $filename = $sqlfile;
                }
            // filename
            // $maxRuntime = 8; // less then your max script execution limit
            // $maxRuntime = 8; // less then your max script execution limit

            // $deadline = time()+$maxRuntime;
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
            while($line=fgets($fp, 1024000))
            {
                if(substr($line,0,2)=='--' OR trim($line)=='' )
                {
                    continue;
                }

                $query .= $line;
                if( substr(trim($query),-1)==';' )
                {
                    if(!$this->query($query))
                    {   // error handling
                       $error = 'Error performing query \'<strong>' . $query . '\': ' . @mysqli_error($this);
                       @file_put_contents($errorFilename, $error."\n");
                       //exit;
                    }
                    $query = '';
                    @file_put_contents($progressFilename, ftell($fp)); // save the current file position for
                    $queryCount++;
                }
            }

            if(feof($fp))
            {
                return true;
            }
            else
                {
                    // $status .= ftell($fp).'/'.filesize($filename).' '.(round(ftell($fp)/filesize($filename), 2)*100).'%'."\n";
                    return false;
                }
        } // ./ import


        /**
         * @brief Delete a whole database (including all tables)
         * @param $database
         */
        public function deleteDatabase($database): bool
        {
            $deletedTables = 0;
            $errors = 0;

            // get all tables as array
            $result = $this->query("SHOW TABLES IN `$database`");
            // check if result is set

            if (isset($result) && (!empty($result)))
            {
                // walk through result array
                while ($table = mysqli_fetch_array($result))
                {   // store tablename in var
                    $tableName = $table[0];
                    // try to delete table
                    if ($this->query("DROP TABLE `$database`.`$tableName`"))
                    {   // output(?)
                        //echo "$tableName was cleared <br>";
                        $deletedTables++;
                    }
                    else
                    {   // output error
                        $errors++;
                    }
                }
            }
            // something went wrong
            if ($errors > 0)
            {   // output error
                return false;
            }
            else {
                return true;
            }
        }

        /**
         * @brief Get all tables from a database and return as array
         * @return array tableList
         */
        public function get_tables()
        {
            // set tableList array
            $tableList = array();
            // get tables from database
            $res = $this->query("SHOW TABLES");
            // walk through result
            while($row = mysqli_fetch_array($res))
            {   // fill array
                $tableList[] = $row[0];
            }
            return $tableList;
        }

        /**
         * @brief Truncate a table
         * @param $table string the table to truncate
         * @return bool
         */
        public function truncateTable(string $table): bool
        {
            if (!empty($table))
            {
                $table = '{'.$table.'}';
                if ($this->query("TRUNCATE TABLE $table"))
                {   // success
                    return true;
                }
                else
                    {   // error
                        return false;
                    }
            }
            return false;
        }

        /**
         * @brief Drop table from a database
         * @param array $tables the tables to drop
         * @return bool
         */
        public function dropTables($tables)
        {
            $processed = 0;
            // check if table was set
            if (!isset($tables) || (empty($tables)) || (!array($tables)))
            {
                return false;
            }
            foreach ($tables as $table)
            {
                if ($this->query("DROP TABLE `".$table."`") === true)
                {
                    $processed++;
                }
            }
            return true;
        }
    } // EOF ./dbclass
}// ./namespace