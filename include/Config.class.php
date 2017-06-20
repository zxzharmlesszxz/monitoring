<?php
prof_flag("Including " . __FILE__);
/**
 * Class Config
 */
class Config
{
    /**
     * @var
     */
    static public $instance;
    /**
     * @var string
     */
    protected $_configFile;
    /**
     * @var
     */
    protected $_configuration;

    /**
     * Config constructor.
     */
    private function __construct()
    {
        $this->_configFile = __DIR__ . '/config.php';
        include_once($this->_configFile);
        $this->_configuration = $config;
    }

    /**
     * @param $key
     * @return null
     */
    final public function __get($key)
    {
        return isset($this->_configuration[$key]) ? $this->_configuration[$key] : NULL;
    }

    /**
     *
     */
    private function __clone()
    {
    }

    /**
     *
     */
    private function __wakeup()
    {
    }


    /**
     * @return Config
     */
    static public function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
