<?php
/* 1371002741 */
/* require('../wp-blog-header.php'); */
/* echo strtotime("24 minute")."<br />"; */
/* $x = date("Y-m-d h:m:s",1371002741); */
/* echo $x; */
$con=mysql_connect("localhost","c2socialgalaxy","WaffleKingd0m");
// Check connection
$db_selected = mysql_select_db('c2socialgalaxy', $con);
$sql = mysql_query("select * FROM timer ORDER BY timer_id DESC LIMIT 1");
$row = mysql_fetch_array($sql);
$time = mysql_query("select TIMEDIFF('".date("Y-m-d h:m:s",$row['value'])."',now()) as x");
$trow = mysql_fetch_array($time);
if($trow['x']<0){
	mysql_query("INSERT INTO timer (value) VALUES ('".strtotime("24 hour UTC")."')");
	mysql_query("UPDATE tumblr_account SET points = 0, feature_credit = (feature_credit - 1),time_travel_credit = (time_travel_credit - 1)");
	mysql_query("UPDATE tumblr_account SET feature_credit = 0 WHERE feature_credit <= 0");
	mysql_query("UPDATE tumblr_account SET time_travel_credit = 0 WHERE time_travel_credit <= 0");
	mysql_query("TRUNCATE TABLE `tumblr_posts`");
	mysql_query("TRUNCATE TABLE `featured_links`");
	mysql_query("TRUNCATE TABLE `motherboard`");
	mysql_query("TRUNCATE TABLE `hack`");
	/* mysql_query("INSERT INTO points(`user`, `points`, `from`)VALUES('".$row['tumblr_username']."',100,'Orbit Countdown')"); */
	/* echo 'finish'; */
} else {	
	mysql_query("UPDATE timer SET value = ".$time." WHERE timer_id = ".$row['timer_id']."");
	/* mysql_query("TRUNCATE TABLE `whosonline`"); */
	$data = explode("#",$_POST['data']);
	$sql = mysql_query("SELECT *, UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(`otime`) as x FROM `whosonline` ORDER BY id DESC LIMIT 1");
	$row = mysql_fetch_array($sql);
	/*  */
	$sqlg = mysql_query("SELECT b.id as x, a.ID as z FROM wp_users as a RIGHT JOIN tumblr_account as b ON b.user_id = a.ID");
	while($rowg = mysql_fetch_array($sqlg)){
		if($rowg['z']==''){
			mysql_query("DELETE FROM tumblr_account WHERE id=".$rowg['x']."");
		}
	}	
	/*  */
	if($row['x'] >= 1200) {
		mysql_query("TRUNCATE TABLE `whosonline`");
	}
	foreach($data as $datus) {
		if($datus != ''){
			mysql_query("INSERT INTO `whosonline` (`user`) VALUES ('".$datus."');");
		}
	}
}
/* echo $x = date("Y-m-d h:m:s",$trow['x']); */
?>
<div id="timer"><?php echo $trow['x'];?></div>