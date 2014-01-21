<?php
require('config.php');
$sqlpoints = mysql_query("SELECT * FROM tumblr_account WHERE tumblr_username = '".$_POST['user']."'");
$sqlcheck = mysql_query("SELECT * FROM hack WHERE user = '".$_POST['user']."' AND status = '".$_POST['up']."'");
$rowpoints = mysql_fetch_array($sqlpoints);
$rowcheck = mysql_num_rows($sqlcheck);
$up = $_POST['up'];
/* motherboard skip */
if($up == 'ms' AND $rowpoints['points'] > 100 AND $rowcheck != 1){
	mysql_query("INSERT INTO hack (user,status) VALUES ('".$_POST['user']."','ms')");
	mysql_query("UPDATE tumblr_account SET points = (points - 100) WHERE tumblr_username = '".$_POST['user']."'");		
	$msg = 'congratulations you can skip bulletin board limit.';		
} else if($up == 'ms' AND $rowcheck == 1) {	
	$msg = 'you haven\'t used your previous bulletin board skip.';		
} else if($up == 'ms' AND $rowpoints['points'] < 100) {
	$msg = 'not enough points to use bulletin board skip.';
}
/* super traveler */
if($up == 'st' AND $rowpoints['points'] > 500 AND $rowcheck != 1){
	mysql_query("INSERT INTO hack (user,status) VALUES ('".$_POST['user']."','st')");
	mysql_query("UPDATE tumblr_account SET points = (points - 500) WHERE tumblr_username = '".$_POST['user']."'");		
	$msg = 'Congratulations you can add live users again.';		
} else if($up == 'st' AND $rowcheck == 1) {	
	$msg = 'you haven\'t used your previous add live users.';		
} else if($up == 'st' AND $rowpoints['points'] < 500) {
	$msg = 'not enough points to use add live users.';
}
/* time travel credit */
if($up == 'ttc' AND $rowpoints['points'] > 9500 AND $rowcheck != 1){
	mysql_query("INSERT INTO hack (user,status) VALUES ('".$_POST['user']."','ttc')");
	mysql_query("UPDATE tumblr_account SET points = (points - 9500), time_travel_credit = (time_travel_credit + 1) WHERE tumblr_username = '".$_POST['user']."'");
	echo 'congratulations you gain 1 content credit.';
} else if($up == 'ttc' AND $rowcheck == 1) {
	echo 'you have gain this reward only once per day.';
} else if($up == 'ttc' AND $rowpoints['points'] < 9500) {
	echo 'not enough points to gain content credit.';
}
/* feature credit */
if($up == 'fc' AND $rowpoints['points'] > 9500 AND $rowcheck != 1){
	mysql_query("INSERT INTO hack (user,status) VALUES ('".$_POST['user']."','fc')");
	mysql_query("UPDATE tumblr_account SET points = (points - 9500), feature_credit = (feature_credit + 1) WHERE tumblr_username = '".$_POST['user']."'");
	echo 'congratulations you gain 1 featured credit.';
} else if($up == 'fc' AND $rowcheck == 1) {
	echo 'you have gain this reward only once per day.';
} else if($up == 'fc' AND $rowpoints['points'] < 9500) {
	echo 'not enough points to use featured credit.';
}
?>
<p class="msgbox"><?php echo $msg;?></p>