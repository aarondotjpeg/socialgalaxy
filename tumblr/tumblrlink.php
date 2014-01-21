<?php
 /* 
Legends for Scoring
af = 5 points = online users
ed = 10 points = top users
ex = 10 points = top users page
h2 = 25 points = featured users
wg = 10 points = motherboard users
ft = 
 */
require('../wp-blog-header.php');
$sql = mysql_query("SELECT * FROM tumblr_account WHERE user_id = ".$_GET['id']."");
$row = mysql_fetch_array($sql);
$points = substr($_GET['token'],10,1).substr($_GET['token'],20,1); 
	if($points == 'af'){
		$pt = 10;
		$from = 'followed top users page';
	} else if($points == 'ex'){
		$pt = 10;
		$from = 'followed top users';
	} else if($points == 'ed'){
		$pt = 20;
		$from = 'followed top users';
	} else if($points == 'h2'){
		$pt = 50;
		$from = 'followed featured users';
	} else if($points == 'wg'){
		$pt = 10;
		$from = 'followed motherboard users';
	} else if($_GET['ok'] == 1){
		
	}
$sql2 = mysql_query("SELECT * FROM follow WHERE user = '".$row['tumblr_username']."' AND follow = '".$_GET['follow']."'");
$check = mysql_num_rows($sql2);
if($check < 1 and ($row['tumblr_username'] != $_GET['follow'])){
	mysql_query("INSERT INTO follow(`user`, `follow`)VALUES('".$row['tumblr_username']."','".$_GET['follow']."')");
	mysql_query("UPDATE tumblr_account SET `points` = points + ".$pt." WHERE tumblr_username = '".$row['tumblr_username']."'");
	mysql_query("INSERT INTO points(`user`, `points`, `from`)VALUES('".$row['tumblr_username']."',".$pt.",'".$from."')");
}
/* echo $points."<br />";
echo $pt." | ". $from;  */
header("location: http://www.tumblr.com/follow/".$_GET['follow']."");
?>