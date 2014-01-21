<?php
/**
 * Template Name: Top Users Page Template
 *
 */
get_header(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">
		<?php /* <div class="top-featured-background">
			<div class="top-featured">
				<div class="title">top featured</div>
				<div class="points">25 points to follow   |   <a href="<?php bloginfo('home');?>/use-points/">Use Points</a></div>
				<ul class="featured">
				<?php
				$current_user = wp_get_current_user();
				$sql2 = mysql_query("SELECT * FROM tumblr_account, wp_users WHERE tumblr_username = display_name AND feature_credit > 0 ORDER BY feature_credit DESC");
				while($row2 = mysql_fetch_array($sql2)){
				$token = substr(md5($row2['tumblr_avatar']),0, 10).'h'.substr(md5($row2['tumblr_username']),0, 9).'2'.substr(md5($row2['tumblr_avatar']),10, 10);
				?>
					<li><div class="image"><a target='_blank' href="../tumblr/tumblrlink.php?follow=<?php echo $row2['tumblr_username'];?>&id=<?php echo $current_user->ID;?>&token=<?php echo $token;?>"><img alt="<?php echo $row2['tumblr_username'];?>" title="<?php echo $row2['tumblr_username'];?>" src="<?php echo $row2['tumblr_avatar']; ?>" width="90" /></a></div><div class="user-points"><?php echo $row2['points']; ?> Points</div></li>
				<?php } ?>
				</ul>
				<br style="clear:both;" />
			</div>
		</div> */ ?>
			<div class="top-users">
				<div class="title">top users</div>
				<div class="points">follow users for 10 points   |   <a href="<?php bloginfo('home');?>/use-points/">Use Points</a></div>	
				<ul class="tops">
					<li><a href="?top=50">top 50 users</a></li>
					<li><a href="?top=100">top 100 users</a></li>
					<li><a href="?top=all">all users</a></li>
				</ul>
				<ul class="featured">
				<?php
				if($_GET['top'] == 'all' OR empty($_GET['top'])){
					$top = '';
				} else {
					$top = 'LIMIT '.$_GET['top'];
				}
				$sql = mysql_query("SELECT * FROM tumblr_account, wp_users WHERE tumblr_username = display_name ORDER BY points DESC ".$top."");
				while($row = mysql_fetch_array($sql)){
				$token = substr(md5($row['tumblr_username']),0, 10).'e'.substr(md5($row['user_id']),0, 9).'x'.substr(md5($row['user_id']),10, 10);
				?>
					<li><div class="image"><a target='_blank' href="../tumblr/tumblrlink.php?follow=<?php echo $row['tumblr_username'];?>&id=<?php echo $current_user->ID;?>&token=<?php echo $token;?>"><img alt="<?php echo $row['tumblr_username'];?>" title="<?php echo $row['tumblr_username'];?>" src="<?php echo $row['tumblr_avatar']; ?>" width="100" /></a><br /><?php echo $row['tumblr_username'];?></div><div class="user-points"><?php echo number_format($row['points'], 0, '', ','); ?> Points</div></li>
				<?php } ?>
				</ul>			
			</div>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>