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
    /**
     *
     */
    public function run()
    {
        do {
            $value = null;

            $provider = $this->worker->getProvider();

            // Синхронизируем получение данных
            $provider->synchronized(function ($provider) use (&$value) {
                $value = $provider->getNext();
            }, $provider);

            if ($value === null) {
                continue;
            }

            // Некая ресурсоемкая операция
            $server = array_merge((array)$value, serverInfo($value['server_ip']));
            if ($server['status'] == 'off' || empty($server['name'])) {
//                $result = db()->query("UPDATE " . DB_SERVERS . " SET server_status = '0', server_map = '-', server_players = '-', server_maxplayers = '-' " . (($server['server_status'] == 1) ? ", status_change = " . time() : "") . " WHERE server_id='{$server['server_id']}';");
//                var_dump($result);
                print("UPDATE " . DB_SERVERS . " SET server_status = '0', server_map = '-', server_players = '-', server_maxplayers = '-' " . (($server['server_status'] == 1) ? ", status_change = " . time() : "") . " WHERE server_id='{$server['server_id']}';" . PHP_EOL);
                continue;
            }
            $name = $this->worker->getConnection()->real_escape_string(htmlspecialchars(trim($server['name'])));
//            $result = db()->query("UPDATE " . DB_SERVERS . " SET server_name = '{$name}'," . " server_map = '{$server['map']}', server_players = '{$server['players']}'," . " server_maxplayers = '{$server['max_players']}', server_status = '1' " . (($server['server_status'] == 0) ? ", status_change = " . time() : "") . " WHERE server_id='{$server['server_id']}';");
//            var_dump($result);
            print("UPDATE " . DB_SERVERS . " SET server_name = '{$name}'," . " server_map = '{$server['map']}', server_players = '{$server['players']}'," . " server_maxplayers = '{$server['max_players']}', server_status = '1' " . (($server['server_status'] == 0) ? ", status_change = " . time() : "") . " WHERE server_id='{$server['server_id']}';" . PHP_EOL);
            //$provider->items[]
        } while ($value !== null);
    }

}