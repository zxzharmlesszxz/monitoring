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
    protected $hostname;
    protected $username;
    protected $password;
    protected $database;
    protected $charset;
    protected $port;
    protected static $connection;

    /**
     * @param Provider $provider
     * @param $hostname
     * @param $username
     * @param $password
     * @param $database
     * @param $charset
     * @param int $port
     * @internal param Provider $provider
     */
    public function __construct(Provider $provider, $hostname, $username, $password, $database, $charset, $port = 3306)
    {
        $this->provider = $provider;
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->charset = $charset;
        $this->port = $port;
    }

    public function getConnection()
    {
        if (!self::$connection) {
            self::$connection = new mysqli(
                $this->hostname,
                $this->username,
                $this->password,
                $this->database,
                $this->port);
        }

        self::$connection->set_charset($this->charset);

        return self::$connection;
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