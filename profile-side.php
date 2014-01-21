<?php
define('WP_USE_THEMES', false);
require('wp-blog-header.php');
$current_user = wp_get_current_user();
/* is_user_logged_in(39); */
if($current_user->ID == 0) {
	header('location:' .get_bloginfo('home'));
}
$sql = mysql_query("SELECT * FROM tumblr_account WHERE user_id = ".$current_user->ID."");
$row = mysql_fetch_array($sql);
$sql2 = mysql_query("SELECT * FROM tumblr_account WHERE ref = '".$current_user->user_login."'");
$refpoints = mysql_num_rows($sql2);
$sql3 = mysql_query("SELECT sum(points) as tt FROM time_travel_credit WHERE user = '".$current_user->user_login."'");
$tt_credit = mysql_fetch_array($sql3);
$sql4 = mysql_query("SELECT * FROM follow WHERE user = '".$current_user->user_login."'");
$follow = mysql_num_rows($sql4);
$sql5 = mysql_query("SELECT sum(points) as fc FROM featured_credit WHERE user = '".$current_user->user_login."'");
$featured_credit = mysql_fetch_array($sql5);
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<div id="dialog" style="display:none;" title="Refer your friends"><?php bloginfo('home');?>/tumblr/login_with_tumblr.php?ref=<?php echo $current_user->user_login;?></div>
<script>
var f = jQuery.noConflict();
  f(function() {
    f( "#dialog" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    f( "#opener" ).click(function() {
      f( "#dialog" ).dialog( "open" );
    });
  });
</script>
<style>
.ui-dialog {
	width: 600px!important;
}
#dialog {
	min-height: 0!important;
}
</style>

<div class="widget widget_text" id="text-3">		
	<div class="textwidget">	
	<div class="greeting">Greetings Astronaut</div>
	<div class="name"><?php echo $current_user->user_login;?></div>
	<div class="profile-picture"><img src="<?php echo $row['tumblr_avatar'];?>" width="120"></div>
	<?php if(!empty($_GET['error'])){ ?>
	<div id="error" title="Error"><?php echo $_GET['error'];?></div>
	<?php } ?>
	<ul class="profile-points">
		<li class="featured">Featured Credits: <span><?php echo number_format($row['feature_credit'], 0, '', ',');?></span></li>
		<li class="time">Content Credits: <span><?php echo number_format($row['time_travel_credit'], 0, '', ',');?></span></li>
		<li class="points">Points : <span><?php echo number_format($row['points'], 0, '', ',');?></span></li>
		<li class="followed">Followed : <span><?php echo number_format($follow, 0, '', ',');?></span></li>
		<li class="referrals">Referrals : <span><?php echo number_format($refpoints, 0, '', ',');?></span></li>
	</ul>
	<ul class="sub-menu">
		<li><a href="<?php bloginfo('home');?>/tumblr/connect_with_tumblr.php"><input type="button" value="Connect your Tumblr"></li>
		<li><a href="<?php bloginfo('home');?>/tumblr/follow_with_tumblr.php"><input type="button" value="Add live users"></a></li>
		<li><input type="button" id="opener" value="Refer your friends"></li>
		<!--<li><a href="<?php bloginfo('home');?>/time-travelers/"><input type="button" value="Time Travel"></a></li>
		<li><a href="use-points/"><input type="button" value="Use Points"></a></li>-->
		<li><a href="motherboard?tumblr_name=<?php echo $current_user->user_login;?>"><input type="button" value="Post a bulletin"></a></li>
	</ul>
	<div class="ads">
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-7058234020142948";
	/* SG Sidebar */
	google_ad_slot = "3379454088";
	google_ad_width = 300;
	google_ad_height = 250;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</div></div>
</div>