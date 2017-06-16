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
            print_r($r);
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

        $this->processed++;

        return $this->items[$this->processed];
    }
}