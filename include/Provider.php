<?php

/**
 * Created by PhpStorm.
 * User: harmless
 * Date: 01.06.17
 * Time: 10:56
 */

/**
 * Провайдер данных для потоков
 */
class Provider extends Threaded
{
    /**
     * @var int Сколько элементов в нашей воображаемой БД
     */
    private $total = 0;

    /**
     * @var int Сколько элементов было обработано
     */
    private $processed = 0;

    /**
     * @var array
     */
    private $items = array();

    /**
     * Provider constructor.
     */
    public function __construct()
    {
        $query = db()->query("SELECT * FROM " . DB_SERVERS);

        while ($r = db()->fetch_array($query)) {
            $this->items[] = $r;
            $this->total++;
        }
    }

    private function destruct()
    {
        $servers = array();
        $online = db()->query("SELECT COUNT(*) FROM " . DB_SERVERS . "WHERE server_status = '1';");
        var_dump($online);
        $sql = db()->query("SELECT * FROM " . DB_SERVERS . ";");
        while ($r = db()->fetch_array($sql)) {
            $servers[] = $r;
        }
        var_dump($servers);
        $map = topMap((array) $servers);
        db()->query("
            UPDATE " . DB_SETTINGS . " SET
            last_update='" . time() . "',
            servers_total='{$this->total}',
            servers_online='{$online}',
            top_map='{$map}';"
        );
    }

    /**
     * Переходим к следующему элементу и возвращаем его
     *
     * @return mixed
     */
    public function getNext()
    {
        if ($this->processed === $this->total) {
            $this->destruct();
            return null;
        }

        $this->processed++;

        return $this->items[$this->processed];
    }
}