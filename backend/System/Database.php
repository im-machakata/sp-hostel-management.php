<?php

/**
 * Connects you to the database server easily.
 *
 * Uses a PHP Data Object to connect you to mysql or sqlite database
 */
class Database
{
    /**
     * Stores the current pdo session
     * @var PDO
     */
    private $database;

    /**
     * Stores the current sql statement request
     * @var PDOStatement
     */
    private $statement;

    /**
     * Returns a list of errors that occured
     * @var array
     */
    private $log = [];

    /**
     * Return true if the connection was successful
     */
    private $connected;

    /**
     * Connects to your database and returns true if successful.
     * This class uses a PDO (PHP Data Object) extension to connect to your database.
     */
    public function __construct()
    {
        try {

            // instantiate database
            $this->database = new PDO(
                sprintf("%s:host=%s;dbname=%s;charset=utf8", DB_TYPE, DB_HOST, DB_NAME),
                DB_USER,
                DB_PASS,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );

            // prevent emulation of prepared statements
            $this->database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // store state of the database
            $this->connected = $this->database !== null;
        } catch (PDOException $e) {
            $this->connected = false;
            $this->log[] = $e->getMessage();
        }
    }

    /**
     * Returns true when connected to the database.
     * @return bool
     */
    public function isConnected()
    {
        return $this->connected;
    }
    /**
     * Sends query to the database engine
     * @param string $query The SQL query to be executed.
     */
    public function query($query)
    {
        $this->statement = $this->database->prepare($query);
        $this->execute();
        return $this;
    }

    /**
     * Perfoms a single query returning only the first resultif any, in a select query
     * @return array
     */
    public function querySingle($query)
    {
        $query .= " LIMIT 0,1";
        $this->query($query);
        return $this->getRow();
    }

    /**
     * Prepares an SQL Query
     */
    public function prepare($query, $values = [])
    {
        try {
            $this->statement = $this->database->prepare($query);
            if ($values) {
                $this->bindValues($values);
            }
        } catch (PDOException $e) {
            $this->log[] = $e->getMessage();
        }
        return $this;
    }
    /**
     * Bind prepared values for any type
     * @param array $params A single array with keys and their respective values
     */
    public function bindValues($params = [])
    {
        foreach ($params as $key => $value) {
            if (is_string($value))
                $type = PDO::PARAM_STR;
            elseif (is_int($value))
                $type = PDO::PARAM_INT;
            elseif (is_bool($value))
                $type = PDO::PARAM_BOOL;
            else
                $type = PDO::PARAM_NULL;
            $this->statement->bindValue(':' . $key, $value, $type);
        }
        return $this;
    }

    /**
     * Executes an sql transaction
     */
    public function execute()
    {
        return $this->exec();
    }

    /**
     * Executes a transaction
     */
    public function exec()
    {
        try {
            return $this->statement->execute();
        } catch (PDOException $e) {
            $this->log[] = $e->getMessage();
        }
        return false;
    }

    /**
     * Returns the row count of
     */
    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    /**
     * Returns an associative results array
     * @return array
     */
    public function getRow()
    {
        return $this->fetch();
    }

    /**
     * Returns an array of associative results array
     * @return array
     */
    public function getRows()
    {
        return $this->fetchAll();
    }

    /**
     * Returns the numbers of rows found.
     * @return int
     */
    public function getRowCount()
    {
        return $this->rowCount();
    }

    /**
     * Returns all error messages logged
     * @return array
     */
    public function getErrors()
    {
        return $this->log;
    }

    /**
     * Initializes the transaction
     * @return bool
     */
    public function startTransaction()
    {
        return $this->database->beginTransaction();
    }

    /**
     * Returns true if in an SQL transaction
     * @return bool
     */
    public function inTransaction()
    {
        return $this->database->inTransaction();
    }

    /**
     * Rolls back an SQL transaction and returns true when successfull
     * @return bool
     */
    public function rollbackTransaction()
    {
        return $this->database->rollback();
    }

    /**
     * Commits an SQL transaction and returns true when successfull
     * @return bool
     */
    public function endTransaction()
    {
        return $this->database->commit();
    }

    /*
     * Last Insert Id
     * To Get Last Insert Id After Use Insert Model
     */

    public function lastInsertId()
    {
        return $this->database->lastInsertId();
    }

    /*
     * Close Databse Connect
     * Use It When you Want Close Connection
     */
    public function __destruct()
    {
        // Setting the handler to NULL closes the connection propperly
        $this->database = NULL;
    }

    /**
     * Fetchs and returns data from the database server
     * @return array
     */
    private function fetch(int $method = PDO::FETCH_ASSOC)
    {
        return $this->statement->fetch($method);
    }

    /**
     * You Can Use it To get All Rows As an array
     * @return array
     */
    private function fetchAll(int $method = PDO::FETCH_ASSOC)
    {
        return $this->statement->fetchAll($method);
    }
}
