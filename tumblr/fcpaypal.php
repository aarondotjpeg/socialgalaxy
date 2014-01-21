<?php
require('../wp-blog-header.php');

if($_POST['mc_gross']==6.00){
	$credit = 1;
} else if($_POST['mc_gross']==15.00) {
	$credit = 3;
} else if($_POST['mc_gross']==30.00) {
	$credit = 7;
} else if($_POST['mc_gross']==75.00) {
	$credit = 30;
}
/* mysql_query("INSERT INTO test (`value`) VALUES ('".urlencode(stripslashes($_POST['auth'])).": ".urlencode(stripslashes($_POST['payment_date'])).": ".urlencode(stripslashes($_POST['option_selection1']))."-".urlencode(stripslashes($_POST['option_selection2']))."-".urlencode(stripslashes($_POST['payment_status']))."')"); */
/* Insert Payment Info */
$sql = mysql_query("SELECT * FROM paypal WHERE auth = '".$_POST['txn_id']."'");
$row = mysql_fetch_array($sql);
$check = mysql_num_rows($sql);
if($check > 0){
	if($row['status'] != 'Completed'){
		mysql_query("UPDATE paypal SET status = '".$_POST['payment_status']."' WHERE id = ".$row['id']."");
		if($_POST['payment_status'] == 'Completed'){
			mysql_query("UPDATE tumblr_account SET time_travel_credit = (feature_credit + ".$credit.")  WHERE tumblr_username = '".$_POST['option_selection2']."'");
		}
	}
} else {
	mysql_query("INSERT INTO paypal (`username`,`paypal_id`,`credit_type`,`credit_qty`,`auth`,`status`) VALUES ('".$_POST['option_selection2']."','".$_POST['payer_id']."','fc',".$credit.",'".$_POST['txn_id']."','".$_POST['payment_status']."')");
}