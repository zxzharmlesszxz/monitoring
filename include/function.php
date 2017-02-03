<?php

if (!function_exists('getmicrotime')) {
 function getmicrotime() {
  list($usec, $sec) = explode(" ", microtime());
  return ((float)$usec + (float)$sec);
 }
}

function getString(&$packet) {
 $str = "";
 $n = strlen($packet);

 for ($i=0;($packet[$i]!=chr(0)) && ($i < $n);++$i) {
  $str .= $packet[$i];
 }

 $packet = substr($packet, strlen($str));
 return trim($str);
}

function getChar(&$packet) {
 $char = $packet[0];
 $packet = substr($packet, 1);
 return $char;
}

function sortByKills($a, $b) {
 if ($a['kills'] == $b['kills']) {
  return 0;
 }
 return ($a['kills'] > $b['kills']) ? -1 : 1;
}

function serverInfo($server) {
 list($ip,$port) = explode(":", $server);
 $timeStart = getmicrotime();
 $fp = @fsockopen('udp://'.$ip, $port);
 if ($fp) {
  stream_set_timeout($fp, 2);
  fwrite($fp,"\xFF\xFF\xFF\xFFTSource Engine Query\0\r");
  $temp = fread($fp, 4);
  $status = socket_get_status($fp);

  if ($status['unread_bytes']>0) {
   $temp = fread($fp, $status['unread_bytes']);
   $version = ord(getChar($temp));
   $array = array();
   $array['ping'] = (int)((getmicrotime() - $timeStart)*1000);
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
  if ($array['status']== 'off') continue;
 }
}

function playersInfo($server) {
 list($ip,$port) = explode(":", $server);
 $array = array();
 $fp = @fsockopen('udp://'.$ip, $port);

 if ($fp) {
  stream_set_timeout($fp, 2);
  $command = pack("V", -1) . 'W';
  fwrite($fp, $command, strlen($command));
  $temp = fread($fp, 5);
  $lo = (ord($temp[1]) << 8) | ord($temp[0]);
  $hi = (ord($temp[3]) << 8) | ord($temp[2]);
  $data = "\xFF\xFF\xFF\xFF\x55".pack("V", ($hi << 16) | $lo);
  fwrite($fp, $data);
  $temp = fread($fp, 4);
  $status = socket_get_status($fp);

  if ($status['unread_bytes']>0) {
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
 $result = mysql_query($sql);
 dbquery("SELECT adress FROM amx_servers");
 if (mysql_num_rows($result) == 0) {
  echo "No Servers";
  exit;
 }

 if (mysql_error()!=='') return mysql_error
 $result=array();
 while ($row=dbarray(adress)) $result[]=$row;
 // или $result[$row['adress']]=$row так красивее
 return $result
}
*/

function mb_str_replace($needle, $replacement, $haystack) {
 $needle_len = mb_strlen($needle);
 $replacement_len = mb_strlen($replacement);
 $pos = mb_strpos($haystack, $needle);
 while ($pos !== false) {
  $haystack = mb_substr($haystack, 0, $pos).$replacement.mb_substr($haystack, $pos + $needle_len);
  $pos = mb_strpos($haystack, $needle, $pos + $replacement_len);
 }
 return $haystack;
}

function send_mail($email, $message) {
 if (empty($email) or empty($message)) {
  return true;
 }
 mail($email, "From: Monitoring System http://www.monitoring.contra.net.ua\n", $message);
}

function parse_site($url) {
 $str = "<a href='http://contra.net.ua/' target='_blank'>Игровые сервера cs 1.6 Украина</a>";
 $page = new DOMDocument;
 libxml_use_internal_errors(true);
 $page->loadHTMLfile($url);
 libxml_clear_errors();
 foreach ($page->getElementsByTagName('a') as $el) {
  if ($el->getAttribute('href') == 'http://contra.net.ua/') {
   if ($el->nodeValue == "Игровые сервера cs 1.6 Украина") {
    return true;
   }
  }
 }
 return false;
}

function get_page_html($url) {
 $ch = curl_init($url);
 $page = curl_exec($ch);
 curl_close($ch);
 return $page;
}

//функция для перевода из HEX кода в RBG
function htmlcolor($img,$color) {
 sscanf($color, "%2x%2x%2x", $red, $green, $blue);
 return ImageColorAllocate($img,$red,$green,$blue);
 return($c);
}

//функция для русского текста
function iso2uni($isoline) {
 $isoline = convert_cyr_string($isoline, "w", "k");
 $isoline = convert_cyr_string($isoline, "k", "i");
 for ($i=0; $i < strlen($isoline); $i++) {
  $thischar=substr($isoline,$i,1);
  $charcode=ord($thischar);
  $uniline.=($charcode>175) ? "&#".(1040+($charcode-176)). ";" : $thischar;
 }
 return $uniline;
}

function displayMessage($text, $style='warning') {
 if(!empty($text)) {
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

// Функция, извлекающая HTML теги
function stripinput($text) {
 if (QUOTES_GPC) {
  $text = stripslashes($text);
 }

 $search = array("&", "\"", "'", "\\", '\"', "\'", "<", ">", "&nbsp;");
 $replace = array("&amp;", "&quot;", "&#39;", "&#92;", "&quot;", "&#39;", "&lt;", "&gt;", " ");
 $text = str_replace($search, $replace, $text);

 return $text;
}

// MySQL функции
function dbquery($query) {
 $result = @mysql_query($query);
 if (!$result) {
  echo mysql_error();
  return false;
 } else {
  return $result;
 }
}

function dbresult($query, $row) {
 $result = @mysql_result($query, $row);
 if (!$result) {
  echo mysql_error();
  return false;
 } else {
  return $result;
 }
}

function formatDate($forma,$time) {
 return gmdate($forma,$time +3600*(3+date("I"))+3600);
}

function time2string($sal,$day=true,$has=true,$min=true,$sek=true) {
 $days = '';
 $return = '';
 if ($sal > 10) {
  $days = preg_replace('/(.*?)\.(.*)/',"\\1",$sal/86400);
  $sal -= $days*86400;
 }

 $h = preg_replace('/(.*?)\.(.*)/',"\\1",$sal/3600);
 $sal -= $h*3600;
 $m = preg_replace('/(.*?)\.(.*)/',"\\1",$sal/60);
 $sal -= $m*60;
 $txt = array(
  'day'=>(substr($days,strlen($days)-1,1)==1) ?"день" : ((substr($days,strlen($days)-1,1)>1 AND (substr($days,strlen($days)-1,1)<5)) ?"дня" : "дней"),
  'h'=>(substr($h,strlen($h)-1,1)==1) ?"час" : ((substr($h,strlen($h)-1,1)>1 AND (substr($h,strlen($h)-1,1)<5)) ?"часа" : "часов"),
  'm'=>(substr($m,strlen($m)-1,1)==1) ?"минуту" : ((substr($m,strlen($m)-1,1)>1 AND (substr($m,strlen($m)-1,1)<5)) ?"минуты" : "минут"),
  's'=>(substr($sal,strlen($sal)-1,1)==1) ?"секунду" : ((substr($sal,strlen($sal)-1,1)>1 AND (substr($sal,strlen($sal)-1,1)<5)) ?"секунды" : "секунд"));

 $return .= ($day && $days >0) ?"{$days} {$txt['day']}": "";
 $return .= ($has && $h >0) ?" {$h} {$txt['h']}": "";
 $return .= ($min && $m >0) ?" {$m} {$txt['m']}": "";
 $return .= ($sek && $sal >0) ?" {$sal} {$txt['s']}": "";
 return $return;
}

function dbarray($query) {
 $result = @mysql_fetch_assoc($query);
 if (!$result) {
  echo mysql_error();
  return false;
 } else {
  return $result;
 }
}

function dbarray_fetch($query) {
 $result = @mysql_fetch_array($query);
 if (!$result) {
  echo mysql_error();
  return false;
 } else {
  return $result;
 }
}

function redirect($location) {
 echo "<script type='text/javascript'>document.location.href='".str_replace("&amp;", "&", $location)."'</script>\n";
 exit;
}

function stripslash($text) {
 return (QUOTES_GPC) ? stripslashes($text) : $text;
}

function addslash($text) {
 return (!QUOTES_GPC) ? addslashes(addslashes($text)) : addslashes($text);
}

function descript($text, $striptags = true) {
 // Функция убирает все скрипты из запроса
 $search = array("40","41","58","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80","81","82","83","84","85","86","87","88","89","90","97","98","99","100","101","102","103","104","105","106","107","108","109","110","111","112","113","114","115","116","117","118","119","120","121","122");
 $replace = array("(",")",":","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
 $entities = count($search);

 for ($i=0; $i < $entities; $i++) {
  $text = preg_replace("#(&\#)(0*".$search[$i]."+);*#si", $replace[$i], $text);
 }

 $text = preg_replace('#(&\#x)([0-9A-F]+);*#si', "", $text);
 $text = preg_replace('#(<[^>]+[/\"\'\s])(onmouseover|onmousedown|onmouseup|onmouseout|onmousemove|onclick|ondblclick|onfocus|onload|xmlns)[^>]*>#iU', ">", $text);
 $text = preg_replace('#([a-z]*)=([\`\'\"]*)script:#iU', '$1=$2nojscript...', $text);
 $text = preg_replace('#([a-z]*)=([\`\'\"]*)javascript:#iU', '$1=$2nojavascript...', $text);
 $text = preg_replace('#([a-z]*)=([\'\"]*)vbscript:#iU', '$1=$2novbscript...', $text);
 $text = preg_replace('#(<[^>]+)style=([\`\'\"]*).*expression\([^>]*>#iU', "$1>", $text);
 $text = preg_replace('#(<[^>]+)style=([\`\'\"]*).*behaviour\([^>]*>#iU', "$1>", $text);

 if ($striptags) {
  do {
   $thistext = $text;
   $text = preg_replace('#</*(applet|meta|xml|blink|link|style|script|embed|object|iframe|frame|frameset|ilayer|layer|bgsound|title|base)[^>]*>#i', "", $text);
  } while ($thistext != $text);
 }

 return $text;
}

function makefilelist($folder, $filter, $sort=true, $type="files") {
 $res = array();
 $filter = explode("|", $filter);
 $temp = opendir($folder);

 while ($file = readdir($temp)) {
  if ($type == "files" && !in_array($file, $filter)) {
   if (!is_dir($folder.$file)) {
    $res[] = $file;
   }
  } elseif ($type == "folders" && !in_array($file, $filter)) {
   if (is_dir($folder.$file)) { $res[] = $file; }
  }
 }
 closedir($temp);

 if ($sort) {
  sort($res);
 }
 return $res;
}

function makefileopts($files, $selected = "") {
 $res = "";
 for ($i = 0; $i < count($files); $i++) {
  $sel = ($selected == $files[$i] ? " selected='selected'" : "");
  $res .= "<option value='".$files[$i]."'$sel>".$files[$i]."</option>\n";
 }
 return $res;
}

function servers($server_num_data) {
 //$sql = "SELECT * FROM ".DB_SERVERS." WHERE server_new != 1 AND server_status != 0 AND server_off != 1 ORDER BY server_vip desc, votes DESC".(($server_num_data != 'all') ? " LIMIT $server_num_data" : "");
 return dbquery("SELECT * FROM ".DB_SERVERS." WHERE server_new != 1 AND server_status != 0 AND server_off != 1 ORDER BY server_vip desc, votes DESC".(($server_num_data != 'all') ? " LIMIT $server_num_data" : ""));
}

function dbrows($query) {
 return @mysql_num_rows($query);
}

function dbconnect($db_host, $db_user, $db_pass, $db_name) {
 $db_connect = @mysql_connect($db_host, $db_user, $db_pass);
 $db_select = @mysql_select_db($db_name);

 if (!$db_connect) {
  die("<div style='font-family:Verdana;font-size:11px;text-align:center;'><b>Не могу подключиться к MySQL</b><br />".mysql_errno()." : ".mysql_error()."</div>");
 } elseif (!$db_select) {
  die("<div style='font-family:Verdana;font-size:11px;text-align:center;'><b>НЕ могу подключиться к MySQL базе данных</b><br />".mysql_errno()." : ".mysql_error()."</div>");
 }

 // Fix кодировки
 mysql_query("SET NAMES 'utf8'");
}

function isValidURL($url) {
 return filter_var($url, FILTER_VALIDATE_URL);
}

function isValidEmail($email) {
 return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isOnOff($int) {
 return ($int == 1 or $int == 0) ? true : false;
}

function myempty($var) {
 return ($var != "") ? false : true;
}

function getdomain($url) {
 preg_match("/^(http:\/\/|https:\/\/)?([^\/]+)/i", $url, $matches);

 //$host = $matches[2];

 preg_match("/[^\.\/]+\.[^\.\/]+$/", $matches[2], $matches);

 return strtolower($matches[0]);
}

function socketmail($server='localhost', $to, $from, $subject, $message) {
 $connect = fsockopen ($server, 25, $errno, $errstr, 30);
 sleep(10);
 fputs($connect, "HELO $server\r\n");
 sleep(3);
 fputs($connect, "MAIL FROM: $from\n");
 sleep(3);
 fputs($connect, "RCPT TO: $to\n");
 sleep(3);
 fputs($connect, "DATA\r\n");
 sleep(1);
 fputs($connect, "Content-Type: text/plain; charset=utf8\n");
 fputs($connect, "To: $to\n");
 fputs($connect, "Subject: $subject\n");
 fputs($connect, "\n\n");
 fputs($connect, stripslashes($message)." \r\n");
 fputs($connect, ".\r\n");
 fputs($connect, "RSET\r\n");
}

function isEmail($email) {
 return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}
