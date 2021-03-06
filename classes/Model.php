<?php

/**
 * Main DB Connect class
 */
class Model
{
    /**
     * summary
     */
    protected $dbh;
    protected $stmt;
    public function __construct()
    {
        $this->dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    }

    public function query($query)
    {
    	$this->stmt = $this->dbh->prepare($query);
    }
    // bind the prepare statement
    public function bind($param, $value, $type = null)
    {
    	if (is_null($type)) {
    		switch (true) {
    			case is_int($value):
    				$type = PDO::PARAM_INT;
    				break;
    			case is_bool($value):
    				$type = PDO::PARAM_BOOL;
    				break;
    			case is_null($value):
    				$type = PDO::PARAM_NULL;
    				break;
    			default:
    				$type = PDO::PARAM_STR;
    				break;
    		}
    	}
    	$this->stmt->bindValue($param, $value, $type);
    }

    // execute query
    public function execute()
    {
    	$this->stmt->execute();
    }

    // Get Result set
    public function resultSet()
    {
    	$this->execute();
    	return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Last insertedID
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    // Get Single Result
    public function singleResult()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}