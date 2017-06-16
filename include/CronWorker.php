<?php

/**
 * Created by PhpStorm.
 * User: harmless
 * Date: 01.06.17
 * Time: 10:56
 */

/**
 * Worker тут используется, чтобы расшарить провайдер между экземплярами Work.
 */
class CronWorker extends Worker
{
    /**
     * @var Provider
     */
    private $provider;
    /**
     * @var
     */
    protected $hostname;
    /**
     * @var
     */
    protected $username;
    /**
     * @var
     */
    protected $password;
    /**
     * @var
     */
    protected $database;
    /**
     * @var
     */
    protected $charset;
    /**
     * @var int
     */
    protected $port;

    /**
     * @var
     */
    protected $redisHost;

    /**
     * @var
     */
    protected $redisPassword;
    /**
     * @var
     */
    protected static $connection;

    /**
     * @var
     */
    protected static $redis;

    /**
     * @param Provider $provider
     * @param $hostname
     * @param $username
     * @param $password
     * @param $database
     * @param $charset
     * @param $redis_host
     * @param $redis_password
     * @param int $port
     * @internal param Provider $provider
     */
    public function __construct(Provider $provider, $hostname, $username, $password, $database, $charset, $redis_host, $redis_password, $port = 3306)
    {
        $this->provider = $provider;
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->charset = $charset;
        $this->redisHost = $redis_host;
        $this->redisPassword = $redis_password;
        $this->port = $port;
    }

    /**
     * @return mysqli
     */
    public function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new mysqli(
                $this->hostname,
                $this->username,
                $this->password,
                $this->database,
                $this->port);
            self::$connection->set_charset($this->charset);
        }

        return self::$connection;
    }

    /**
     * @return Redis
     */
    public function getRedis()
    {
        if (!self::$redis) {
            self::$redis = new Redis();
            self::$redis->connect($this->redisHost);
            self::$redis->auth($this->redisPassword);
            self::$redis->select(1);
        }

        return self::$redis;
    }

    /**
     * Вызывается при отправке в Pool.
     */
    public function run()
    {
        // В этом примере нам тут делать ничего не надо
    }

    /**
     * Возвращает провайдера
     *
     * @return Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

}