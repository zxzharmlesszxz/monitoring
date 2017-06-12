<?php

mb_language('uni');
mb_internal_encoding('UTF-8');

error_reporting(E_ALL);
include "inc/ServerQueries.php";
include "inc/SourceServerQueries.php";

$url = "banner.png";

function toUnicodeEntities($text, $from = "w")
{
    $text = convert_cyr_string($text, $from, "i");
    $uni = "";
    for ($i = 0, $len = strlen($text); $i < $len; $i++) {
        $char = $text{$i};
        $code = ord($char);
        $uni .= ($code > 175) ? "&#" . (1040 + ($code - 176)) . ";" : $char;
    }
    return $uni;
}

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
        $players = $info['playerNumber'] . " / " . $info['maxPlayers'];
        $status = "Включен";
        $color = $green;
    } else {
        $server_full = " ";
        $players = "Нет игроков";
        $status = "Выключен";
        $color = $red;
    }

    imagettftext($img, 10, 0, 40, 18, $brown, "fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Сервер:")));
    imagettftext($img, 10, 0, 40, 34, $white, "fonts/arialbd.ttf", $info['serverName'] ?? '');
    imagettftext($img, 10, 0, 320, 18, $brown, "fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Время на карте:")));
    imagettftext($img, 9, 0, 320, 34, $white, "fonts/arialbd.ttf", $rules['amx_timeleft'] ?? '');
    imagettftext($img, 10, 0, 490, 18, $brown, "fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Статус:")));
    imagettftext($img, 9, 0, 490, 34, $color, "fonts/arialbd.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', $status)));
    imagettftext($img, 10, 0, 40, 57, $brown, "fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Адрес:")));
    imagettftext($img, 9, 0, 40, 72, $white, "fonts/arialbd.ttf", $server);
    imagettftext($img, 10, 0, 40, 95, $brown, "fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Карта:")));
    imagettftext($img, 9, 0, 40, 108, $white, "fonts/arialbd.ttf", $info['mapName'] ?? '');
    imagettftext($img, 10, 0, 320, 57, $brown, "fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "След.карта:")));
    imagettftext($img, 9, 0, 320, 72, $white, "fonts/arialbd.ttf", $rules['amx_nextmap'] ?? '');
    imagettftext($img, 10, 0, 490, 57, $brown, "fonts/arial.ttf", toUnicodeEntities(iconv('UTF-8', 'WINDOWS-1251', "Игроки:")));
    imagettftext($img, 9, 0, 490, 72, $white, "fonts/arialbd.ttf", $players);
    imagettftext($img, 8, 0, 415, 88, $green, "fonts/arialbd.ttf", $server_full ?? '');

    imagePNG($img);
    imagedestroy($img);
}
