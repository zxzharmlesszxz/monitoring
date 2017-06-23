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
        $mysqlConnection = $this->worker->getConnection();
        $redisConnection = $this->worker->getRedis();
        $provider = $this->worker->getProvider();
        $sq = new SourceServerQueries();

        do {
            $value = null;

            // Синхронизируем получение данных
            $provider->synchronized(function ($provider) use (&$value) {
                $value = $provider->getNext();
            }, $provider);

            if ($value === null) {
                continue;
            }

            // Некая ресурсоемкая операция
            list($ip, $port) = explode(':', $value['server_ip']);
            $sq->connect($ip, $port);
            $info = $sq->getInfo();
            $players = $sq->getPlayers();
            $rules = $sq->getRules();
            $sq->disconnect();

            if ($value['server_top_time'] < time()) {
                $mysqlConnection->real_query("UPDATE " . DB_SERVERS . " SET `server_top` = 0 WHERE `server_id` = '{$value['server_id']}';");
            }

            if ($value['server_vip_time'] < time()) {
                $mysqlConnection->real_query("UPDATE " . DB_SERVERS . " SET `server_vip` = 0 WHERE `server_id` = '{$value['server_id']}';");
            }

            if ($value['server_color_time'] < time()) {
                $mysqlConnection->real_query("UPDATE " . DB_SERVERS . " SET `server_ipport_style` = '', `server_row_style` = '' WHERE `server_id` = '{$value['server_id']}';");
            }

            $serverForRedis = json_encode(array('info' => $info, 'players' => $players, 'rules' => $rules, 'dbInfo' => (array) $value));

            $server = array_merge((array)$value, $info);
            $server['status'] = (!empty($info['serverName'])) ? 'on' : 'off';

            $site = !empty($server['server_site']) ? parse_site($server['server_site']) : false;

            if ($server['status'] == 'off' and time() - $server['status_change'] > 86400) {
                $mysqlConnection->real_query(
                    "DELETE FROM " . DB_SERVERS . " WHERE server_id = '{$server['server_id']}';"
                );
                $redisConnection->hDel('servers', $value['server_id']);
                print "DELETE FROM " . DB_SERVERS . " WHERE server_id = '{$server['server_id']}';" . PHP_EOL;
                continue;
            }

            if (!empty($server['serverName'])) {
                    $mysqlConnection->real_query("UPDATE " . DB_SERVERS . " SET status_change = " . time() . " WHERE server_id='{$server['server_id']}';");
                    print "UPDATE " . DB_SERVERS . " SET status_change = " . time() . " WHERE server_id='{$server['server_id']}';" . PHP_EOL;
            }

            $redisConnection->hSet('servers', $value['server_id'], $serverForRedis);
        } while ($value !== null);
    }
}