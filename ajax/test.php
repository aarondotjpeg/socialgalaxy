<?php
$con=mysql_connect("localhost","c2socialgalaxy","WaffleKingd0m");
$db_selected = mysql_select_db('c2socialgalaxy', $con);
$time = mysql_query("select TIMEDIFF('".date("Y-m-d h:m:s",strtotime("20 hours"))."',now()) as x");
$trow = mysql_fetch_array($time);
echo strtotime("20 hours ago")."<br />";
echo $trow['x'];
?>