<?php
/**
 * Template Name: Profile Page Template
 *
 */

get_header(); ?>

<?php if ( is_user_logged_in() ) {?> 
<div class="profile">
	<?php //if ( function_exists('dynamic_sidebar') && dynamic_sidebar('left_sidebar') ) : else : ?>
	<?php //endif; ?>
	<?php include 'profile-side.php';?>
</div>
<div class="content">
<?php
$sqlx = mysql_query("SELECT * FROM system_update ORDER BY id limit 1");
$rowx = mysql_fetch_assoc($sqlx);
?>
	<div class="status">User update: <span><?php echo $rowx['value'];?></span></div>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#timetravel_ajax").load("../tumblr/timetravel_with_tumblr.php");
			var x = 0;
			jQuery(".wpwhosonline-list li").hide();
			jQuery(".wpwhosonline-active").each(function(){
				x++;
				jQuery(this).show();
			});
			jQuery("#online").text(x);
			setInterval(function(){
				return asa();				
			},1000); 
			function asa(){
			var x = '';
				/* jQuery('#orbit.numbers').load('http://social-galaxy.com/wp/tumblr/timer.php div#timer'); */
				jQuery(".wpwhosonline-list .wpwhosonline-active .username").each(function(){
					x = x + jQuery(this).text() + "#";
				});
				jQuery.ajax({
					type: "POST",
					url: "../tumblr/timer.php",
					data: "ok=1&data="+x,
					success: function(data) {
						jQuery('#orbitx').html(data);
					} 
				});				
			}
		});
	</script>
<link rel="stylesheet" href="<?php echo content_url();?>/themes/2012_child/colorbox.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo content_url();?>/themes/2012_child/js/jquery.colorbox.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	});
</script>	
	<?php
/* 	$sqlpoints = mysql_query("SELECT * FROM tumblr_account WHERE tumblr_username = '".$current_user->user_login."'");
	$sqlcheck = mysql_query("SELECT * FROM hack WHERE user = '".$current_user->user_login."' AND status = '".$_GET['use_points']."'");
	$rowpoints = mysql_fetch_array($sqlpoints);
	$rowcheck = mysql_num_rows($sqlcheck);
	$up = $_GET['use_points']; */
if(isset($_POST['txn_id'])) {
?>
<script type="text/javascript">
alert("Thank you for purchasing <?php echo $_POST['option_selection1'];?>.\nPlease wait for the admin to review and confirm your payments.\n\nThank you!");
</script>
<?php
}
	$tsql = mysql_query("SELECT * FROM follow");
	$dsql = mysql_query("SELECT * FROM follow WHERE DATE_FORMAT(cdate,'%W %M %Y') =DATE_FORMAT(now(),'%W %M %Y')");
	$refsql = mysql_query("SELECT * FROM points WHERE DATE_FORMAT(cdate,'%D %M %Y') = DATE_FORMAT(now(),'%D %M %Y') AND `from` = 'refered a friend'");
	$psql = mysql_query("SELECT sum(points) as x FROM points WHERE DATE_FORMAT(cdate,'%D %M %Y') = DATE_FORMAT(now(),'%D %M %Y')");
	$tfollow = mysql_num_rows($tsql);
	$dfollow = mysql_num_rows($dsql);
	$refers = mysql_num_rows($refsql);
	$prow = mysql_fetch_array($psql);
	?>
	<div id="timetravel_ajax"></div>
	<div class="profile-counter">
		<ul>
			<li class="list1">
				<div class="profile-counts">
					<div class="numbers"><?php echo number_format($dfollow, 0, '', ',');?></div>
					<div class="details"><span>Follows Created Today</span><div>
				</div>
			</li>
			<li class="list2">
				<div class="profile-counts">
					<div class="numbers"><?php echo number_format($tfollow, 0, '', ',');?></div>
					<div class="details"><span>Total Follows Created</span></div>
				</div>
			</li>
			<li class="list3">
				<div class="profile-counts">
					<div class="numbers" id="online">0</div>
					<div class="details"><span>Users Online</span></div>
				</div>
			</li>
			<li class="list4">
				<div class="profile-counts">
					<div class="numbers"><?php if($prow['x']<1) {echo '0';} else {echo number_format($prow['x'], 0, '', ',');}?></div>
					<div class="details"><span>Points Created Today</span></div>
				</div>
			</li>
			<li class="list5">
				<div class="profile-counts">
					<div class="numbers"><?php echo number_format($refers['x'], 0, '', ',');?></div>
					<div class="details"><span>Referrals Created Today</span></div>
				</div>
			</li>			
			<li class="list6">
				<div class="profile-counts">
					<div class="numbers" id="orbitx">00:00:00</div>
					<div class="details"><span>point reset timer</span></div>
				</div>
			</li>
		</ul>
	</div>
	<ul class="featured">
		<li class="feature1">featured users</li>
		<li class="feature2">Follow users for 50 points | <a href="<?php bloginfo('home');?>/become-featured/">Become featured</a></li>
	</ul>
	<ul class="pics-top-users">
	<?php
	$current_user = wp_get_current_user();
	$sqlx = mysql_query("SELECT * FROM tumblr_account, wp_users WHERE tumblr_username = display_name AND feature_credit > 0 ORDER BY feature_credit DESC");
	while($rowx = mysql_fetch_array($sqlx)){
	$token = substr(md5($rowx['tumblr_avatar']),0, 10).'h'.substr(md5($rowx['tumblr_username']),0, 9).'2'.substr(md5($rowx['tumblr_avatar']),10, 10);
	?>
		<li><div class="image"><a target='_blank' href="../tumblr/tumblrlink.php?follow=<?php echo $rowx['tumblr_username'];?>&id=<?php echo $current_user->ID;?>&token=<?php echo $token;?>"><img alt="<?php echo $rowx['tumblr_username'];?>" title="<?php echo $rowx['tumblr_username'];?>" src="<?php echo $rowx['tumblr_avatar']; ?>" width="100" /></div><div class="user-points"><?php echo $rowx['tumblr_username'];?><br /><span><?php echo number_format($rowx['points'], 0, '', ','); ?> Points</span></a></div></li>
	<?php } ?>
	</ul>
	<ul class="top-users">
		<li class="feature1">featured content</li>
		<li class="feature2">20 points for likes and 50 points for reblogs | <a href="<?php bloginfo('home');?>/use-points/">Use Points</a></li>
	</ul>
	<ul class="featured">
	<?php
		$sql = mysql_query("SELECT * FROM tumblr_posts,tumblr_account WHERE user = tumblr_username AND time_travel_credit > 0 GROUP BY user ORDER BY tumblr_posts.id");
		while($row = mysql_fetch_array($sql)){				
	?>
		<li><div class="image"><a href="<?php bloginfo('home');?>/tumblr/post_list.php?user=<?php echo $row['tumblr_username'];?>" class="iframe"><img alt="<?php echo $row['tumblr_username'];?>" title="<?php echo $row['tumblr_username'];?>" src="<?php echo $row['tumblr_avatar']; ?>" width="100" /></div><div class="user-points"><?php echo $row['tumblr_username'];?><br /><span><?php echo number_format($row['points'], 0, '', ','); ?> Points</span></a></div></li>
	<?php } ?>
	</ul>
	<ul class="top-users">
		<li class="feature1">top 7 users</li>
		<li class="feature2">Follow users for 20 points | <a href="<?php bloginfo('home');?>/use-points/">Use Points</a></li>
	</ul>
	<ul class="pics-top-users">
	<?php
	$current_user = wp_get_current_user();
	$sql2 = mysql_query("SELECT * FROM tumblr_account, wp_users WHERE tumblr_username = display_name ORDER BY points DESC LIMIT 7");
	while($row2 = mysql_fetch_array($sql2)){
	$token = substr(md5($row2['tumblr_username']),0, 10).'e'.substr(md5($row2['user_id']),0, 9).'d'.substr(md5($row2['user_id']),10, 10);
	?>
		<li><div class="image"><a target='_blank' href="../tumblr/tumblrlink.php?follow=<?php echo $row2['tumblr_username'];?>&id=<?php echo $current_user->ID;?>&token=<?php echo $token;?>"><img alt="<?php echo $row2['tumblr_username'];?>" title="<?php echo $row2['tumblr_username'];?>" src="<?php echo $row2['tumblr_avatar']; ?>" width="100" /></div><div class="user-points"><?php echo $row2['tumblr_username'];?><br /><span><?php echo number_format($row2['points'], 0, '', ','); ?> Points</span></a></div></li>
	<?php } ?>
	</ul>		
	<ul class="astronauts">
		<li class="feature1">users online</li>
		<li class="feature2">Follow users for 10 points | <a href="<?php bloginfo('home');?>/">Use Points</a></li>
	</ul>
	<?php dynamic_sidebar( 'whos_online' ); ?>
</div>	
<?php } else { ?>
<meta http-equiv="refresh" content="1; URL=<?php bloginfo('siteurl'); ?>">	
<?php }?>
<?php get_footer(); ?>