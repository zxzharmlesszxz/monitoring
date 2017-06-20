<?php
prof_flag("Including " . __FILE__);
/**
 * Class Database
 */
abstract class Database {
    /**
     * @return mixed
     */
    abstract function open_connection();

    /**
     * @return mixed
     */
    abstract function close_connection();

    /**
     * @param $sql
     * @return mixed
     */
    abstract function query($sql);

    /**
     * @param $value
     * @return mixed
     */
    abstract function escape_value($value);

    /**
     * @param $result_set
     * @return mixed
     */
    abstract function fetch_array($result_set);

    /**
     * @param $result_set
     * @return mixed
     */
    abstract function num_rows($result_set);

    /**
     * @return mixed
     */
    abstract function insert_id();

    /**
     * @return mixed
     */
    abstract function affected_rows();

    /**
     * @param $result
     * @return mixed
     */
    abstract protected function confirm_query($result);
}
