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

    private $connection;

    /**
     * @param Provider $provider
     */
    public function __construct(Provider $provider)
    {
        $this->connection = $GLOBALS['db'];
        print_r($this->connection);
        $this->provider = $provider;
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

    /**
     * @return mixed|null
     */
    public function getConnection() {
        return $this->connection;
    }
}