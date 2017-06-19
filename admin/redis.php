<?php

error_reporting(E_ERROR);
ini_set('display_errors', 0);

$servers = array();

foreach ($items as $id => $item) {
    $servers[$id] = unserialize($item);
}

ksort($servers);

echo <<<EOT
<div id='right'>
    <div class='section'>
        <div class='box'>
            <div class='title'>Servers in redis<span class='hide'></span></div>
            <div class='content'>
EOT;

foreach ($servers as $id => $server) {
    $server['info']['serverName'] = htmlspecialchars($server['info']['serverName']);
    echo <<<EOT
   <div class='box'>
        <div class='title'>{$id}. {$server['info']['serverName']}<span class='hide'></span></div>
        <div class='content'>
            <div class='row'>
                <div class='right'>
                    {$server['info']['mapName']} - {$server['info']['playerNumber']} - {$server['info']['maxPlayers']} - {$server['info']['version']} - {$server['info']['operatingSystem']} - {$server['info']['passwordProtected']} - {$server['info']['secureServer']}
                </div>
            </div>
        </div>
   </div>
EOT;
}
echo <<<EOT
            </div>
        </div>
    </div>
</div>
EOT;
