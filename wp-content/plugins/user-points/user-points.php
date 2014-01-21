<?php
/*
Plugin Name: Galaxy Points
Plugin URI: http://archmages.com
Description: Customized Plugin
Version: 1.0
Author: Yami Ruinmer
Author URI: http://archmages.com
License: Not yet
*/

/*  Copyright 2011 Yami Ruinmer (email : yamidemichaos@live.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

*/
function user_points() {
	echo "<p id='yami2'>$chosen</p>";
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'admin_notices', 'user_points' );

/* add_action( 'admin_head', 'user_points_css2' ); */
add_action( 'admin_menu', 'user_points_add_pages2' );
function user_points_add_pages2() {
    add_menu_page('User Points', 'User Points', 0, 'user_points', 'user_points_wp_admin');
}
// Top Level Menu Page (Configs)
function user_points_wp_admin() {
?>
<style>
td, th {
	border: 1px solid #111;
	padding: 3px 5px;
}
td {
	color: #fff;
	background: #111;
}
th {
	color: #111;
	background: #fff;
}
table a:link,table a:visited {
	color: #fff;
}
</style>
<?php
if(isset($_GET['edit'])){
$sql2 = mysql_query("SELECT * FROM tumblr_account WHERE id = ".$_GET['edit']."");
$row2 = mysql_fetch_assoc($sql2);
?>
<form action="?page=user_points" method="POST">
<input type="hidden" name="id" value="<?php echo $_GET['edit'];?>" />
<h1><?php echo $row2['tumblr_username'];?></h1>
<h2>Add Point(s)/Credit(s)</h2>
<table>
<tr><td>Point(s)</td><td><input type="number" name="points" value="0" /></td></tr>
<tr><td>Featured Credit(s)</td><td><input type="number" name="fc" value="0" /></td></tr>
<tr><td>Content Credit(s)</td><td><input type="number" name="ttc" value="0" /></td></tr>
<tr><td colspan=2><input type="submit" name="add" value="ADD" /></td></tr>
</table>
</form>
<?php	
} else {
	if(isset($_POST['add'])){
		mysql_query("UPDATE tumblr_account SET points = (points + ".$_POST['points']."), feature_credit = (feature_credit + ".$_POST['fc']."), time_travel_credit = (time_travel_credit + ".$_POST['ttc'].") WHERE id = ".$_POST['id']."");
	}
if(isset($_POST['change'])){
	mysql_query("UPDATE `system_update` SET `value` = '".$_POST['system']."' WHERE id = 1");
}
$sqlx = mysql_query("SELECT * FROM `system_update` WHERE id = 1");
$rowx = mysql_fetch_assoc($sqlx);
?>
<form action="?page=user_points" method="POST">
<h2>User Update NOTE: <input type="text" name="system" value="<?php echo $rowx['value'];?>" size="40" /></h2>
<input type="submit" value="CHANGE" name="change" />
</form>
<hr />
<h2>USER LIST</h2>
<table>
<tr>
<th>Username</th>
<th>Points</th>
<th>Featured Credit</th>
<th>Content Credit</th>
<th>Online</th>
<th>Option</th>
</tr>
<?php
$sql = mysql_query("SELECT * FROM tumblr_account, wp_users WHERE tumblr_username = display_name ORDER BY wp_users.id DESC");
while($row = mysql_fetch_array($sql)) {
?>
<tr>
<td><?php echo $row['tumblr_username'];?></td>
<td><?php echo $row['points'];?></td>
<td><?php echo $row['feature_credit'];?></td>
<td><?php echo $row['time_travel_credit'];?></td>
<td><?php echo $row['online'];?></td>
<td><a href="?page=user_points&edit=<?php echo $row['id'];?>">Add Point(s)/Credit(s)</a></td>
</tr>
<?php
}
?>
</table>
<?php
	}
}
?>