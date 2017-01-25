<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
	define("MONENGINE", true);
	require_once("../core.php");

	$task = $_REQUEST['task'];

	switch($task) {
		case 'delreply':
			$id = mysql_real_escape_string($_REQUEST['id']);
			$result = dbquery("DELETE FROM `".DB_COMMENTS."` WHERE `id` = '$id'");
			if($result) exit('success');
			exit('fail');
			break;
		case 'changestatus':
			$id = mysql_real_escape_string($_REQUEST['id']);
			$get_server = dbquery("SELECT * FROM `".DB_SERVERS."` WHERE `server_id` = '$id'") or exit(mysql_error());
			$server = dbarray_fetch($get_server);
			
			if($server['server_off'] == 1) {
				$new_status = 0;
			} else {
				$new_status = 1;
			}
			
			$result = dbquery("UPDATE `".DB_SERVERS."` SET `server_off` = '$new_status' WHERE `server_id` = '$id'");
			
			if($result) {
				exit('success');
			} else {
				exit('fail');
			}
			break;
		case 'approvereply':
			$id = mysql_real_escape_string($_REQUEST['id']);
			$type = mysql_real_escape_string($_REQUEST['type']);
			$result = dbquery("UPDATE `".DB_COMMENTS."` SET `type` = '$type' WHERE `id` = '$id'");
			if($result) {
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
?>