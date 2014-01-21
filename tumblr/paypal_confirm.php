<?php
require('../wp-blog-header.php');
$current_user = wp_get_current_user();
$request = "cmd=_notify-validate"; 
foreach ($_POST as $varname => $varvalue){
	$email .= "$varname: $varvalue\n";  
	if(function_exists('get_magic_quotes_gpc') and get_magic_quotes_gpc()){  
		$varvalue = urlencode(stripslashes($varvalue)); 
	}
	else { 
		$value = urlencode($value); 
	} 
	$request .= "&$varname=$varvalue"; 
	/* mysql_query("INSERT INTO test (`value`) VALUES ('".$request."')"); */
} 
mysql_query("INSERT INTO test (`value`) VALUES ('".$request." = user: ".$current_user->user_login.": user2 ".$_GET['user']." - ".$_GET['pay']."')");
$sql = mysql_query("SELECT * FROM test");
while($row = mysql_fetch_array($sql)){
	echo $row['value']."<br />";
}
/* 
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://www.sandbox.paypal.com/cgi-bin/webscr");
//curl_setopt($ch,CURLOPT_URL,"https://www.paypal.com");
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$request);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,false);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$result = curl_exec($ch);
curl_close($ch);
switch($result){
	case "VERIFIED":
		// verified payment
		break;
	case "INVALID":
		// invalid/fake payment
		break;
	default:
		// any other case (such as no response, connection timeout...)
} */

?>