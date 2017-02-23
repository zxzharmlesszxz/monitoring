<?php

/**
* Database Class
**/

//namespace Database;

abstract class Database {

    private $connection;
    private $config;
    public $last_query;

// Create a database connection function
    abstract function open_connection();

// Close a database connection function
    abstract function close_connection();

// Perform database query function
    abstract function query($sql);

// prepare values
    abstract function escape_value($value);

// "database-neutral" methods	
    abstract function fetch_array($result_set);

    abstract function num_rows($result_set);

    abstract function insert_id();

    abstract function affected_rows();

// Confirm database query function
    abstract protected function confirm_query($result);
}
