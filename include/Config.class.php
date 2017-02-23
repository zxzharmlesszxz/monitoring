<?php

/**
* Config class(Singleton)
**/

//namespace Core;

class Config {
 static public $instance;
 protected $_configFile;
 protected $_configuration;

 private function __construct() {
  $this->_configFile = __DIR__.'/../config/config.inc.php';
  include_once($this->_configFile);
  $this->_configuration = $config;
 }

 final public function __get($key) {
  return isset($this->_configuration[$key]) ? $this->_configuration[$key] : NULL;
 }

 private function __clone() {}
 private function __wakeup() {}
 
  
 static public function getInstance() {
  if (is_null(self::$instance)) {
   self::$instance = new self;
  }
  return self::$instance;
 }
}
