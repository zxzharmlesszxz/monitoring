<?php

/**
 * Created by PhpStorm.
 * User: harmless
 * Date: 01.06.17
 * Time: 18:59
 */
class CronPool extends Pool
{
    /**
     * @param $hostname
     * @param $username
     * @param $password
     * @param $database
     * @param $charset
     * @param int $port
     * @return $this
     */
    public function destruct($hostname, $username, $password, $database, $charset, $port = 3306)
    {
        global $servers;
         $connection = new mysqli(
             $hostname,
             $username,
             $password,
             $database,
             $port
          );

        $connection->set_charset($charset);
        $online = 0;

        foreach ($servers as $id => $server) {
            if(!empty($server['info']['serverName']))
                $online++;
        }

        $map = topMap((array) $servers);
        $connection->real_query("
            UPDATE " . DB_SETTINGS . " SET
            last_update='" . time() . "',
            servers_total='" . count($servers) . "',
            servers_online='{$online}',
            top_map='{$map}';"
        );
        return $this;
    }
}