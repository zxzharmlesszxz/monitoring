<?php
prof_flag("Including " . __FILE__);
/**
 * Class Registry
 */
class Registry
{
    /**
     * @var array
     */
    static private $store = array();

    /**
     * Registry constructor.
     */
    protected function __construct()
    {
    }

    /**
     *
     */
    protected function __clone()
    {
    }

    /**
     * @param $key
     * @param $value
     */
    static public function _set($key, $value)
    {
        self::$store[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    static public function _get($key)
    {
        return isset(self::$store[$key]) ? self::$store[$key] : null;
    }

    /**
     * @param $key
     */
    static public function _remove($key)
    {
        unset(self::$store[$key]);
    }
}

