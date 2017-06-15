<?php

mb_language('uni');
mb_internal_encoding('UTF-8');

$url = "../images/banner/banner.png";
var_dump($_GET);
if (isset($_GET["serv"])) {
    $sq = new SourceServerQueries();
    $server = $_GET["serv"];
    $address = explode(':', $server);
    $sq->connect($address[0], $address[1]);
    $info = $sq->getInfo();
    $players = $sq->getPlayers();
    $rules = $sq->getRules();
    $sq->disconnect();

    header("Content-type: image/png");
    $img = imagecreatefrompng($url);
    $white = imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);
    $green = imagecolorallocate($img, 0, 255, 0);
    $brown = imagecolorallocate($img, 255, 85, 0);
    $red = imagecolorallocate($img, 255, 0, 0);

    if ($info['serverName']) {
        if (strlen($info['serverName']) > 40)
            $info['serverName'] = substr($info['serverName'], 0, 40) . "...";
        $players = $info['playerNumber'] . " / " . $info['maxPlayers'];
        $status = "Включен";
        $color = $green;
    } else {
        $server_full = " ";
        $players = "Нет игроков";
        $status = "Выключен";
        $color = $red;
    }

    imagettftext($img, 10, 0, 40, 18, $brown, "../images/banner/fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Сервер:")));
    imagettftext($img, 10, 0, 40, 34, $white, "../images/banner/fonts/arialbd.ttf", $info['serverName'] ?? '');
    imagettftext($img, 10, 0, 320, 18, $brown, "../images/banner/fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Время на карте:")));
    imagettftext($img, 9, 0, 320, 34, $white, "../images/banner/fonts/arialbd.ttf", $rules['amx_timeleft'] ?? '');
    imagettftext($img, 10, 0, 490, 18, $brown, "../images/banner/fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Статус:")));
    imagettftext($img, 9, 0, 490, 34, $color, "../images/banner/fonts/arialbd.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', $status)));
    imagettftext($img, 10, 0, 40, 57, $brown, "../images/banner/fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Адрес:")));
    imagettftext($img, 9, 0, 40, 72, $white, "../images/banner/fonts/arialbd.ttf", $server);
    imagettftext($img, 10, 0, 40, 95, $brown, "../images/banner/fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Карта:")));
    imagettftext($img, 9, 0, 40, 108, $white, "../images/banner/fonts/arialbd.ttf", $info['mapName'] ?? '');
    imagettftext($img, 10, 0, 320, 57, $brown, "../images/banner/fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "След.карта:")));
    imagettftext($img, 9, 0, 320, 72, $white, "../images/banner/fonts/arialbd.ttf", $rules['amx_nextmap'] ?? '');
    imagettftext($img, 10, 0, 490, 57, $brown, "../images/banner/fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Игроки:")));
    imagettftext($img, 9, 0, 490, 72, $white, "../images/banner/fonts/arialbd.ttf", $players);
    imagettftext($img, 8, 0, 415, 88, $green, "../images/banner/fonts/arialbd.ttf", $server_full ?? '');

    imagePNG($img);
    imagedestroy($img);
}
