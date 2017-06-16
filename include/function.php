<?php

if (!function_exists('getmicrotime')) {
    /**
     * @return float
     */
    function getmicrotime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}

/**
 * @param $packet
 * @return string
 */
function getString(&$packet)
{
    $str = "";
    $n = strlen($packet);

    for ($i = 0; ($packet[$i] != chr(0)) && ($i < $n); ++$i) {
        $str .= $packet[$i];
    }

    $packet = substr($packet, strlen($str));
    return trim($str);
}

/**
 * @param $packet
 * @return mixed
 */
function getChar(&$packet)
{
    $char = $packet[0];
    $packet = substr($packet, 1);
    return $char;
}

/**
 * @param $a
 * @param $b
 * @return int
 */
function sortByKills($a, $b)
{
    if ($a['kills'] == $b['kills']) {
        return 0;
    }
    return ($a['kills'] > $b['kills']) ? -1 : 1;
}

/**
 * @param $server
 * @return array
 */
function serverInfo($server)
{
    list($ip, $port) = explode(":", $server);
    $timeStart = getmicrotime();
    $fp = @fsockopen('udp://' . $ip, $port);
    if ($fp) {
        stream_set_timeout($fp, 2);
        fwrite($fp, "\xFF\xFF\xFF\xFFTSource Engine Query\x00");
        fread($fp, 4);
        $status = socket_get_status($fp);

        if ($status['unread_bytes'] > 0) {
            //$temp = fread($fp, $status['unread_bytes']);
            $temp = stream_get_contents($fp);
            $version = ord(getChar($temp));
            $array = array();
            $array['ping'] = (int)((getmicrotime() - $timeStart) * 1000);
            $array['status'] = "on";

            if ($version == 109) {
                $array['ip'] = getString($temp);
                $temp = substr($temp, 1);
                $array['name'] = getString($temp);
                $temp = substr($temp, 1);
                $array['map'] = getString($temp);
                $temp = substr($temp, 1);
                getString($temp);
                $temp = substr($temp, 1);
                getString($temp);
                $temp = substr($temp, 1);
                $array['players'] = ord(getChar($temp));
                $array['max_players'] = ord(getChar($temp));
            } elseif ($version == 73) {
                getChar($temp);
                $array['name'] = getString($temp);
                $temp = substr($temp, 1);
                $array['map'] = getString($temp);
                $temp = substr($temp, 1);
                getString($temp);
                $temp = substr($temp, 1);
                getString($temp);
                $temp = substr($temp, 3);
                $array['players'] = ord(getChar($temp));
                $array['max_players'] = ord(getChar($temp));
            }
        } else {
            $array['status'] = 'off';
        }
        return $array;
    }
}

/**
 * @param $server
 * @return array
 */
function playersInfo($server)
{
    list($ip, $port) = explode(":", $server);
    $array = array();
    $fp = @fsockopen('udp://' . $ip, $port);

    if ($fp) {
        stream_set_timeout($fp, 2);
        $command = pack("V", -1) . 'W';
        fwrite($fp, $command, strlen($command));
        $temp = fread($fp, 5);
        $lo = (ord($temp[1]) << 8) | ord($temp[0]);
        $hi = (ord($temp[3]) << 8) | ord($temp[2]);
        $data = "\xFF\xFF\xFF\xFF\x55" . pack("V", ($hi << 16) | $lo);
        fwrite($fp, $data);
        fread($fp, 4);
        $status = socket_get_status($fp);

        if ($status['unread_bytes'] > 0) {
            echo $status['unread_bytes'];
            $temp = fread($fp, $status['unread_bytes']);
            while (strlen($temp) > 0) {
                $player['name'] = getString($temp);
                $temp = substr($temp, 1);
                $lo = (ord($temp[1]) << 8) | ord($temp[0]);
                $hi = (ord($temp[2]) << 8) | ord($temp[3]);
                $player['kills'] = ($hi << 16) | $lo;
                $temp = substr($temp, 4);
                $f = @unpack("f1float", $temp);
                $temp = substr($temp, 4);
                $player['time'] = gmdate("H:i:s", (int)$f['float']);
                $array[] = $player;
            }
            usort($array, "sortByKills");
        }
    }
    return $array;
}

/*
function getlistservers() {
 $sql = "SELECT adress FROM amx_servers";
 $result = db()->query($sql);
 dbquery("SELECT adress FROM amx_servers");
 if (db()->num_rows($result) == 0) {
  echo "No Servers";
  exit;
 }

 $result=array();
 while ($row=dbarray(adress)) $result[]=$row;
 // или $result[$row['adress']]=$row так красивее
 return $result
}
*/

/**
 * @param $needle
 * @param $replacement
 * @param $haystack
 * @return string
 */
function mb_str_replace($needle, $replacement, $haystack)
{
    $needle_len = mb_strlen($needle);
    $replacement_len = mb_strlen($replacement);
    $pos = mb_strpos($haystack, $needle);
    while ($pos !== false) {
        $haystack = mb_substr($haystack, 0, $pos) . $replacement . mb_substr($haystack, $pos + $needle_len);
        $pos = mb_strpos($haystack, $needle, $pos + $replacement_len);
    }
    return $haystack;
}

/**
 * @param $email
 * @param $message
 * @return bool
 */
function send_mail($email, $message)
{
    global $settings;
    $mailer = new PHPMailer();
    $mailer->CharSet = 'utf-8';
    $mailer->Host = $settings['mail_host'];
    $mailer->Port = $settings['mail_port'];
    $mailer->Mailer = "smtp";
    $mailer->SMTPAuth = true;
    $mailer->SMTPSecure = $settings['mail_secure'];
    $mailer->Username = $settings['mail_user'];
    $mailer->Password = $settings['mail_password'];
    $mailer->Priority = 3;
    $mailer->Subject = "From: Monitoring System https://www.monitoring.contra.net.ua";
    $mailer->Body = $message;
    $mailer->SetFrom($settings['mail_email'], "Monitoring System");
    $mailer->AddAddress($email);
    $mailer->Send();
    $mailer->ClearAddresses();
    $mailer->ClearAttachments();
    return true;
}

/**
 * @param $url
 * @return bool
 */
function parse_site($url)
{
    $page = new DOMDocument;
    libxml_use_internal_errors(true);
    @$page->loadHTML(get_page_html($url));
    libxml_clear_errors();
    foreach ($page->getElementsByTagName('a') as $el) {
        if ($el->getAttribute('href') == 'https://contra.net.ua/' or $el->getAttribute('href') == 'http://contra.net.ua/') {
            if ($el->nodeValue == "Игровые сервера cs 1.6 Украина") {
                return true;
            }
        }
    }
    return false;
}

/**
 * @param $url
 * @return mixed
 */
function get_page_html($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}

/**
 * @param $img
 * @param $color
 * @return int
 */
function htmlcolor($img, $color)
{
    $red = $green = $blue = '';
    sscanf($color, "%2x%2x%2x", $red, $green, $blue);
    return ImageColorAllocate($img, $red, $green, $blue);
}

/**
 * @param $text
 * @param string $style
 */
function displayMessage($text, $style = 'warning')
{
    if (!empty($text)) {
        $styles = Array(
            'error' => 'warning-red',
            'warning' => 'warning-yellow',
            'info' => 'warning-blue',
            'success' => 'warning-green'
        );

        if (empty($styles[$style])) {
            $style = 'warning';
        }

        echo "<div class='{$styles[$style]}'>$text</div>";
    }
}

/**
 * @param $text
 * @return mixed|string
 */
function stripinput($text)
{
    if (QUOTES_GPC) {
        $text = stripslashes($text);
    }

    $search = array("&", "\"", "'", "\\", '\"', "\'", "<", ">", "&nbsp;");
    $replace = array("&amp;", "&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&lt;", "&gt;", " ");
    $text = str_replace($search, $replace, $text);

    return $text;
}

/**
 * @param $query
 * @return bool
 */
function dbquery($query)
{
    global $db_connect;
    $result = db()->query($query);
    if (!$result) {
        echo mysqli_error($db_connect);
        return false;
    } else {
        return $result;
    }
}

/**
 * @param $forma
 * @param $time
 * @return false|string
 */
function formatDate($forma, $time)
{
    return gmdate($forma, $time + 3600 * (3 + date("I")) + 3600);
}

/**
 * @param $sal
 * @param bool $day
 * @param bool $has
 * @param bool $min
 * @param bool $sek
 * @return string
 */
function time2string($sal, $day = true, $has = true, $min = true, $sek = true)
{
    $days = '';
    $return = '';
    if ($sal > 10) {
        $days = preg_replace('/(.*?)\.(.*)/', "\\1", $sal / 86400);
        $sal -= $days * 86400;
    }

    $h = preg_replace('/(.*?)\.(.*)/', "\\1", $sal / 3600);
    $sal -= $h * 3600;
    $m = preg_replace('/(.*?)\.(.*)/', "\\1", $sal / 60);
    $sal -= $m * 60;
    $txt = array(
        'day' => (substr($days, strlen($days) - 1, 1) == 1) ? "день" : ((substr($days, strlen($days) - 1, 1) > 1 AND (substr($days, strlen($days) - 1, 1) < 5)) ? "дня" : "дней"),
        'h' => (substr($h, strlen($h) - 1, 1) == 1) ? "час" : ((substr($h, strlen($h) - 1, 1) > 1 AND (substr($h, strlen($h) - 1, 1) < 5)) ? "часа" : "часов"),
        'm' => (substr($m, strlen($m) - 1, 1) == 1) ? "минуту" : ((substr($m, strlen($m) - 1, 1) > 1 AND (substr($m, strlen($m) - 1, 1) < 5)) ? "минуты" : "минут"),
        's' => (substr($sal, strlen($sal) - 1, 1) == 1) ? "секунду" : ((substr($sal, strlen($sal) - 1, 1) > 1 AND (substr($sal, strlen($sal) - 1, 1) < 5)) ? "секунды" : "секунд"));

    $return .= ($day && $days > 0) ? "{$days} {$txt['day']}" : "";
    $return .= ($has && $h > 0) ? " {$h} {$txt['h']}" : "";
    $return .= ($min && $m > 0) ? " {$m} {$txt['m']}" : "";
    $return .= ($sek && $sal > 0) ? " {$sal} {$txt['s']}" : "";
    return $return;
}

/**
 * @param $query
 * @return bool
 */
function dbarray_fetch($query)
{
    $result = db()->fetch_array($query);
    if (!$result) {
        return false;
    } else {
        return $result;
    }
}

/**
 * @param $url
 * @return mixed
 */
function isValidURL($url)
{
    return filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * @param $email
 * @return mixed
 */
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * @param $int
 * @return bool
 */
function isOnOff($int)
{
    return ($int == 1 or $int == 0) ? true : false;
}

/**
 * @param $var
 * @return bool
 */
function myempty($var)
{
    return !empty($var) ? false : true;
}

/**
 * @param $email
 * @return int
 */
function isEmail($email)
{
    return (preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}

/**
 * @param $tpl
 * @return string
 */
function use_top_tpl($tpl)
{
    global $server_location;
    global $server_game;
    global $server_map;
    global $server_players_num;
    global $server_players_num_max;
    global $server_id;
    global $server_name;
    global $server_address;
    $vars = Array(
        '{location}' => $server_location,
        '{game}' => $server_game,
        '{map}' => $server_map,
        '{players}' => $server_players_num,
        '{players_max}' => $server_players_num_max,
        '{id}' => $server_id,
        '{name}' => $server_name,
        '{address}' => $server_address
    );
    $tpl = strtr($tpl, $vars);
    return $tpl;
}

/**
 * @param $map
 * @param string $game
 * @return bool
 */
function create_map_image($map, $game = 'cs16')
{
    $file = __DIR__ . "/../images/maps/$game/$map";

    if (file_exists("$file.png")) {
        $ext = ".png";
    } elseif (file_exists("$file.jpg")) {
        $ext = ".jpg";
    } elseif (file_exists("$file.jpeg")) {
        $ext = ".jpeg";
    } elseif (file_exists("$file.gif")) {
        $ext = ".gif";
    } elseif (file_exists("$file.bmp")) {
        $ext = ".bmp";
    } else {
        unset($file, $game);
    }

    if (isset($file) and $ext !== '.png') {
        $img = new imagick($file . $ext);
        $watermark = new Imagick(__DIR__ . "/../images/watermark/watermark.png");
        $watermark->resizeImage(32, 32, Imagick::FILTER_LANCZOS, 1, true);
        $width = $img->getImageWidth();
        $height = $img->getImageHeight();
        $img->resizeImage(160, $height * $width / 160, Imagick::FILTER_LANCZOS, 1, true);
        $img->compositeImage($watermark, imagick::COMPOSITE_OVER, 3, 3);
        $img->writeImage("$file.png");
        $img->destroy();
        $watermark->destroy();
        unlink($file . $ext);
        return true;
    }

    return false;
}

/**
 * @param $map
 * @param string $game
 * @return bool
 */
function check_map_image($map, $game = 'cs16')
{
    if (file_exists(__DIR__ . "/../images/maps/$game/$map.png")) {
        return check_map_image_size(__DIR__ . "/../images/maps/$game/$map.png");
    }
    return false;
}

/**
 * @param $image
 * @return bool
 */
function check_map_image_size($image)
{
    $img = imagecreatefrompng($image);
    $width = imagesx($img);
    imagedestroy($img);
    return ($width == 160) ? true : false;
}

/**
 * @param $map
 * @param string $game
 */
function get_map_image($map, $game = 'cs16')
{
    header("Content-Type: image/png");
    if (check_map_image($map, $game)) {
        readfile(__DIR__ . "/../images/maps/$game/$map.png");
    } else {
        if (create_map_image($map, $game)) {
            get_map_image($map, $game);
        } else {
            create_map_image('no_map', '/');
            readfile("no_map.png");
            file_put_contents(__DIR__ . '/../data/needed_maps_icons.txt', "\n$map\n", FILE_APPEND | LOCK_EX);
        }
    }
}

/**
 * @param array $servers
 * @return int|string
 */
function topMap(array $servers)
{
    $max = "";
    $count = 0;
    $maps = array();
    foreach ($servers as $server) {
        if (!array_key_exists($server['server_map'], $maps))
            $maps[$server['server_map']] = 1;
        else
            $maps[$server['server_map']] += 1;
    }

    foreach ($maps as $map => $num) {
        if ($num > $count) {
            $count = $num;
            $max = $map;
        }
    }
    return $max;
}

/**
 * @return mixed|null
 */
function config()
{
    return Registry::_get('config');
}

/**
 * @return mixed|null
 */
function db()
{
    return Registry::_get('database');
}

/**
 * @param $name
 * @return mixed|string
 */
function name_filtered($name)
{
    $name = iconv('UTF-8', 'windows-1251', $name);
    $name = preg_replace("/[^(\x9|\xA|\xD|\x20-\xD7FF|\xE000-\xFFFD|\x10000\-\x10FFFF)]*/", "", $name);
    if (strlen($name) <= 50) return $name;
    return substr($name, 0, 50) . '... ';
}

/**
 *
 */
function games_menu()
{
    global $games;
    $str = "
    <div id='sort'>
     <ul>
      <li><a title='Все сервера мониторинга' href='/' rel='nofollow'>Все сервера</a></li>
 ";

    foreach ($games as $game => $name) {
        $str .= "<li><a title=\"Игровые сервера {$name}\" href='/{$game}' rel='nofollow'>{$name}</a></li>";
    }

    $str .= "
     </ul>
    </div>";

    return $str;
}

/**
 * @return string
 */
function select_games()
{
    global $games;
    $gamess = array();

    foreach ($games as $game => $title) {
        $gamess[$game] = "<option value='{$game}'>{$title}</option>";
    }

    return implode('\n', $gamess);
}

/**
 *
 */
function modes_menu()
{
    global $modes;
    $str = "
    <div class='sort'>
     <ul class='sort_nav'>
 ";

    foreach ($modes as $mode => $title) {
        $str .= "<li><a title='Сервера с модом {$title}' href='/{$mode}' rel='nofollow'>{$title}</a></li>";
    }

    $str .= "
     </ul>
    </div>";

    return $str;
}

/**
 * @return string
 */
function select_modes()
{
    global $modes;
    $modess = array();

    foreach ($modes as $mode => $title) {
        $modess[$mode] = "<option value='{$mode}'>{$title}</option>";
    }

    return implode('\n', $modess);
}

/**
 * @param $text
 * @param string $from
 * @return string
 */
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