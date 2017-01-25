<?php
if(!function_exists('getmicrotime')) {
	function getmicrotime() { 
		list($usec, $sec) = explode(" ", microtime()); 
		return ((float)$usec + (float)$sec); 
	}
}
function getString(&$packet){
	$str = "";
	$n = strlen($packet);
	for($i=0;($packet[$i]!=chr(0)) && ($i < $n);++$i)
		$str .= $packet[$i];
	$packet = substr($packet, strlen($str));
	return trim($str);
}
function getChar(&$packet){
	$char = $packet[0];
	$packet = substr($packet, 1);
	return $char;
}
function sortByKills($a, $b) {
    if ($a['kills'] == $b['kills'])
        return 0;
    return ($a['kills'] > $b['kills']) ? -1 : 1;
}
function serverInfo($server) {
	list($ip,$port) = explode(":", $server);
	$timeStart = getmicrotime();
	$fp = @fsockopen('udp://'.$ip, $port);
	if($fp) {
		stream_set_timeout($fp, 2);
		fwrite($fp,"\xFF\xFF\xFF\xFFTSource Engine Query\0\r");
		$temp = fread($fp, 4);
		$status = socket_get_status($fp); 
		if($status['unread_bytes']>0) {
			$temp = fread($fp, $status['unread_bytes']);
			$version = ord(getChar($temp));
			$array = array();
			$array['ping'] = (int)((getmicrotime() - $timeStart)*1000);
			$array['status'] = "on";
			if($version == 109) {
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
			} elseif($version == 73) {
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
		} else
			$array['status'] = 'off';
		
	}
	return $array;
	if ($array['status']== 'off') continue;

	
	
}


function playersInfo($server) {
	list($ip,$port) = explode(":", $server);
	$array = array();
	$fp = @fsockopen('udp://'.$ip, $port);
	if($fp) {
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
		if($status['unread_bytes']>0) {
			echo $status['unread_bytes'];
			$temp = fread($fp, $status['unread_bytes']);
			while(strlen($temp) > 0) {
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
function getlistservers(){
$sql = "SELECT adress 
        FROM   amx_servers";
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


function mb_str_replace($needle, $replacement, $haystack)
{
    $needle_len = mb_strlen($needle);
    $replacement_len = mb_strlen($replacement);
    $pos = mb_strpos($haystack, $needle);
    while ($pos !== false)
    {
        $haystack = mb_substr($haystack, 0, $pos) . $replacement
                . mb_substr($haystack, $pos + $needle_len);
        $pos = mb_strpos($haystack, $needle, $pos + $replacement_len);
    }
    return $haystack;
}


function send_mail($email, $message){
	if(empty($email) or empty($message)){return true;}
	mail($email, "From: Monitoring System http://www.monitoring.contra.net.ua\n", $message);
}

function parse_site($url){
	$str = "<a href='http://contra.net.ua/' target='_blank'>Игровые сервера cs 1.6 Украина</a>";
	$page = new DOMDocument;
	libxml_use_internal_errors(true);
        $page->loadHTMLfile($url);
	libxml_clear_errors();
	foreach($page->getElementsByTagName('a') as $el){
		if($el->getAttribute('href') == 'http://contra.net.ua/'){
			if($el->nodeValue == "Игровые сервера cs 1.6 Украина")
			return true;
		}
	}
	return false;
}

function get_page_html($url){
	$ch = curl_init($url);
	$page = curl_exec($ch);
	curl_close($ch);
	return $page;
}
?>
