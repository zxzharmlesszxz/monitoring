<?php

if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
 define("MONENGINE", true);
 
 require_once("/include/core.php");
 
 $hash = $_POST['hash'];
 $id = mysql_real_escape_string($_POST['id']);
 $action = $_POST['action'];
 
 if ($hash != md5("m0n3ng1ne.s4lt:P{]we$id@._)%;")) {
  exit("Ошибка.");
 }

 @$day = date("Y-m-d H:i:s");

 dbquery("DELETE FROM ".DB_VOTES." WHERE date_resp < '$day'");

 function getAllVotes($id) {
  /**
  Returns an array whose first element is votes_up and the second one is votes_down
  **/
  $votes = array();
  $select_server = "SELECT * FROM ".DB_SERVERS." WHERE server_id = $id";
  $select_server = dbquery($select_server);

  if (mysql_num_rows($select_server) == 1) {
   $row = dbarray($select_server);
   $votes[0] = $row['votes'];
  }

  return $votes;
 }

 function getEffectiveVotes($id) {
  /**
  Returns an integer
  **/
  $votes = getAllVotes($id);
  $effectiveVote = $votes[0];
  return $effectiveVote;
 }

 //get the current votes
 $cur_votes = getAllVotes($id);
 $ip = $_SERVER['REMOTE_ADDR'];
 $check_voted = dbquery("SELECT * FROM ".DB_VOTES." WHERE id_resp='$id' AND ip='$ip'");
 
 if (mysql_num_rows($check_voted) == 1 ) {
  echo getEffectiveVotes($id);
  exit();
 }
 
 $votes_new = (($action == 'voteup') ? $cur_votes[0] + 1 : $cur_votes[0] - 1);
 
 if ($votes_new < 0) {
  exit("cant_down");
 }
 
 $votes_upd_query = "UPDATE ".DB_SERVERS." SET votes='$votes_new' WHERE server_id='$id'";

 mysql_query($votes_upd_query);
 
 if (mysql_affected_rows()) {
  $effectiveVote = getEffectiveVotes($id);
  echo $effectiveVote;
  @$date_resp = date("Y-m-d",time()+ 60*60*24);
  dbquery("INSERT INTO ".DB_VOTES."(id_resp, ip, date_resp) VALUES ('".$id."','".$ip."','".$date_resp."')");
 } elseif (!$check_voted) {
  echo "Произошла ошибка.";
 }
} else {
 header("Location: /");
 exit();
}
