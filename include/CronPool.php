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
         $connection = new mysqli(
             $hostname,
             $username,
             $password,
             $database,
             $port
          );

        $connection->set_charset($charset);
        $servers = array();
        $sql = $connection->query("SELECT * FROM " . DB_SERVERS . ";");
        $online = 0;
        while ($r = $sql->fetch_array()) {
            $servers[] = $r;
            if($r['server_status'] == 1)
                $online++;
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