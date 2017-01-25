<?php

ini_set('default_socket_timeout', "15");

$db=mysql_connect("localhost","user","pass");
mysql_select_db("db_name",$db);
 
$result = mysql_query("SELECT * FROM backlinks WHERE activ=0 ORDER BY date LIMIT 1");
if (mysql_num_rows($result)<1){
 exit('Все ссылки проверены<br/><br/>');
}

$myrow = mysql_fetch_array($result);
$url=$myrow['back_url'];
$main_url=$myrow['main_url'];
$email=$myrow['email'];
$date_in=$myrow['date_in'];
echo $url;
$yes='Есть';
$no='Нет';
$sa = mysql_query("UPDATE backlinks SET date=NOW() WHERE back_url='$url'");

include 'backlink.php';

$bl = new backlink($url);

if (!$bl->check('http://www.you_site.ru')) {
 echo $bl->errors;
 
 $sano = mysql_query("UPDATE backlinks SET status='$no' WHERE back_url='$url'");
 $from    = 'noise98@ukr.net';
 $to      = 'noise98@ukr.net';
 $subject = 'ссылка отсутствует';
 $message = 'ссылки нет на странице '.$url.'
  обратка на вашем сайте здесь '.$main_url.'
  ссылка добавлена '.$date_in.'
  Почта партнёра '.$email.'
  Дополнительно: '.$bl->errors.'';
 $headers = "From: $from\r\n";
 $headers .= "MIME-Version: 1.0\r\n";
 $headers .= "Content-Type: text/plain; charset=utf-8\r\n"."Content-Transfer-Encoding: 8bit\r\n";
 mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $message, $headers, "-f ".$from);
} else {
 echo 'OK!';
 $sayes = mysql_query("UPDATE backlinks SET status='$yes' WHERE back_url='$url'");
 $from    = 'noise98@ukr.net';
 $to      = 'noise98@ukr.net';
 $subject = 'ссылка присутствует';
 $message = 'ссылка есть на странице '.$url.'
  обратка на вашем сайте здесь '.$main_url.'';
 $headers = "From: $from\r\n";
 $headers .= "MIME-Version: 1.0\r\n";
 $headers .= "Content-Type: text/plain; charset=utf-8\r\n"."Content-Transfer-Encoding: 8bit\r\n";
 mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $message, $headers, "-f ".$from);
}

echo "<a href='http://contra.net.ua/' target='_blank'>Игровые сервера cs 1.6 Украина</a>";