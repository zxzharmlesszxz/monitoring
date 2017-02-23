<?php

if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
 define("MONENGINE", true);
 require_once("../include/core.php");

 $task = $_REQUEST['task'];

 switch ($task) {
  case 'delreply':
   $id = db()->escape_value($_REQUEST['id']);
   $result = dbquery("DELETE FROM `".DB_COMMENTS."` WHERE `id` = '$id'");

   if ($result) exit('success');
   exit('fail');
   break;
  case 'changestatus':
   $id = db()->escape_value($_REQUEST['id']);
   $get_server = db()->query("SELECT * FROM `".DB_SERVERS."` WHERE `server_id` = '$id'") or exit();
   $server = db()->fetch_array($get_server);
   
   if ($server['server_off'] == 1) {
    $new_status = 0;
   } else {
    $new_status = 1;
   }
   
   $result = db()->query("UPDATE `".DB_SERVERS."` SET `server_off` = '$new_status' WHERE `server_id` = '$id'");
   
   if ($result) {
    exit('success');
   } else {
    exit('fail');
   }
   break;
  case 'approvereply':
   $id = db()->escape_value($_REQUEST['id']);
   $type = db()->escape_value($_REQUEST['type']);
   $result = db()->query("UPDATE `".DB_COMMENTS."` SET `type` = '$type' WHERE `id` = '$id'");
   if ($result) {
    exit('success');
   } else {
    exit('error');
   }
   break;
  default :
   exit('fail');
   break;
 }
} else {
 exit('Hacking attempt!');
}
