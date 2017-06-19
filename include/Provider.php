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
        $query = db()->query("
          SELECT `server_id`, `server_game`, `server_mode`,
          `server_ip`, `server_location`, `server_vip`,
          `server_steam`, `server_regdata`, `server_email`,
          `server_icq`, `server_site`, `about`,
          `votes`, `status_change`, `server_top`,
          `server_row_style`, `server_ipport_style`, `server_top_time`,
          `server_color_time`, `server_vip_time`
          FROM " . DB_SERVERS
        );

        while ($r = db()->fetch_array($query)) {
            $this->items[] = $r;
            $this->total++;
            //print_r($r);
            echo "\n";
        }
    }

    /**
     * Переходим к следующему элементу и возвращаем его
     *
     * @return mixed
     */
    public function getNext()
    {
        if ($this->processed === $this->total) {
            return null;
        }
        $i = $this->processed;

        $this->processed++;

        return $this->items[$i];
    }
}