<?php
prof_flag("Including " . __FILE__);
/**
 * Class MySQL_Database
 */
class MySQL_Database extends Database
{

    /**
     * @var
     */
    private $connection;
    /**
     * @var
     */
    public $last_query;
    /**
     * @var int
     */
    private $magic_quotes_active;
    /**
     * @var bool
     */
    private $real_escape_string_exists;

    /**
     * MySQL_Database constructor.
     */
    public function __construct()
    {
        $this->open_connection();
        $this->magic_quotes_active = get_magic_quotes_gpc();
        $this->real_escape_string_exists = function_exists("mysqli_real_escape_string");

    }

    /**
     *
     */
    public function open_connection()
    {
        $config = config()->mysql;
        $this->connection = mysqli_connect($config['host'], $config['user'], $config['password']);
        if (!$this->connection) {
            die("Database connection failed: " . mysqli_error($this->connection));
        } else {
            mysqli_set_charset($this->connection, $config['charset']);
            $db_select = mysqli_select_db($this->connection, $config['database']);
            if (!$db_select) {
                die("Database selection failed: " . mysqli_error($this->connection));
            }
        }
    }

    /**
     *
     */
    public function close_connection()
    {
        if (isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    /**
     * @param $sql
     * @return bool|mysqli_result
     */
    public function query($sql)
    {
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);

        return $result;
    }

    /**
     * @param $value
     * @return string
     */
    public function escape_value($value)
    {
        $value = htmlspecialchars(trim($value));
        if ($this->real_escape_string_exists) {
            if ($this->magic_quotes_active) {
                $value = stripslashes($value);
            }
            $value = mysqli_real_escape_string($this->connection, $value);
        } else {
            if (!$this->magic_quotes_active) {
                $value = addslashes($value);
            }
        }
        return $value;
    }

    /**
     * @param $result_set
     * @return array|null
     */
    public function fetch_array($result_set)
    {
        return mysqli_fetch_array($result_set, MYSQLI_ASSOC);
    }

    /**
     * @param $result_set
     * @return int
     */
    public function num_rows($result_set)
    {
        return mysqli_num_rows($result_set);
    }

    /**
     * @return int|string
     */
    public function insert_id()
    {
        return mysqli_insert_id($this->connection);
    }

    /**
     * @return int
     */
    public function affected_rows()
    {
        return mysqli_affected_rows($this->connection);
    }

    /**
     * @param $result
     * @return string
     */
    protected function confirm_query($result)
    {
        if (!$result) {
            $output = "Database query failed: " . mysqli_error($this->connection) . "<br />";
            $output .= "Last SQL query: " . $this->last_query;
            return ($output);
        }
    }

}
