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
        $online = db()->query("SELECT COUNT(*) FROM " . DB_SERVERS . "WHERE server_status = '1';");
        var_dump($online);
        $sql = db()->query("SELECT * FROM " . DB_SERVERS . ";");
        while ($r = db()->fetch_array($sql)) {
            $servers[] = $r;
        }
        var_dump($servers);
        $map = topMap((array) $servers);
        $result = db()->query("
            UPDATE " . DB_SETTINGS . " SET
            last_update='" . time() . "',
            servers_total='" . count($servers) . "',
            servers_online='{$online}',
            top_map='{$map}';"
        );
    }

    public function shutdown()
    {
        $this->destruct();
        parent::shutdown();
    }
}