<?php

/**
 * Created by PhpStorm.
 * User: harmless
 * Date: 01.06.17
 * Time: 18:59
 */
class CronPool extends Pool
{
    public function destruct($hostname, $username, $password, $database, $charset, $port = 3306)
    {
         $connection = new mysqli(
             $hostname,
             $username,
             $password,
             $database,
             $port
          );

        $connection->set_charset($charset);
        $servers = array();
        $sql = $connection->query("SELECT COUNT(*) FROM " . DB_SERVERS . " WHERE server_status = '1';");
        var_dump($sql);
        $online = $sql->fetch_field();
        var_dump($online);
        $sql = $connection->query("SELECT * FROM " . DB_SERVERS . ";");

        while ($r = $sql->fetch_array()) {
            $servers[] = $r;
        }

        $map = topMap((array) $servers);
        $result = $connection->real_query("
            UPDATE " . DB_SETTINGS . " SET
            last_update='" . time() . "',
            servers_total='" . count($servers) . "',
            servers_online='{$online}',
            top_map='{$map}';"
        );
        return $this;
    }
}