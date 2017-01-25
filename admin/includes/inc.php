<?php
/*
 * Some important checks
 * Made by starky
*/

/* Script security */
if(!defined("MONENGINE")) {
	header("Location: index.php");
	exit();
}
/* Other code */
session_start();
if(!empty($_SESSION['admin_name']) and !empty($_SESSION['admin_id']) and !empty($_SESSION['admin_password'])) {
	$username = stripinput($_SESSION['admin_name']);
	$userid = stripinput($_SESSION['admin_name']);
	$userpassword = stripinput($_SESSION['admin_password']);
	$check_admin = dbquery("SELECT * FROM `".DB_ADMIN."` WHERE `admin_name` = '{$username}' AND `admin_pass` = '{$userpassword}'");
	if(mysql_num_rows($check_admin) == 0) {
		session_destroy();
		$logged_in = false;
	} else {
		$logged_in = true;
	}
} else {
	session_destroy();
	$logged_in = false;
}
?>