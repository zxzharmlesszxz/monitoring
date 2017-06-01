<?php

/**
 * Created by PhpStorm.
 * User: harmless
 * Date: 01.06.17
 * Time: 18:59
 */
class CronPool extends Pool
{
    private function destruct()
    {
        $servers = array();
        $online = self::$connection->query("SELECT COUNT(*) FROM " . DB_SERVERS . "WHERE server_status = '1';");
        var_dump($online);
        $sql = self::$connection->query("SELECT * FROM " . DB_SERVERS . ";");
        while ($r = self::$connection->fetch_array($sql)) {
            $servers[] = $r;
        }
        //var_dump($servers);
        $map = topMap((array) $servers);
        $result = self::$connection->query("
            UPDATE " . DB_SETTINGS . " SET
            last_update='" . time() . "',
            servers_total='" . count($servers) . "',
            servers_online='{$online}',
            top_map='{$map}';"
        );
    }

    public function shutdown($hostname, $username, $password, $database, $charset, $port = 3306)
    {
self::$connection = new mysqli(
                $hostname,
                $username,
                $password,
                $database,
                $port);
        }

        //self::$connection->set_charset($charset);
        $this->destruct();
        parent::shutdown();
    }
}