<?php

/**
 * Created by PhpStorm.
 * User: harmless
 * Date: 01.06.17
 * Time: 11:06
 */

/**
 * Work это задача, которая может выполняться параллельно
 */
class Work extends Threaded
{

    public function run()
    {
        do {
            $value = null;

            $provider = $this->worker->getProvider();

            // Синхронизируем получение данных
            $provider->synchronized(function($provider) use (&$value) {
                $value = $provider->getNext();
            }, $provider);

            if ($value === null) {
                continue;
            }

            // Некая ресурсоемкая операция
            $count = 100;
            for ($j = 1; $j <= $count; $j++) {
                sqrt($j+$value) + sin($value/$j) + cos($value);
            }
        }
        while ($value !== null);
    }

}