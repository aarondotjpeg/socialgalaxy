<?php
/**
 * Template Name: Time Travelers Page Template
 *
 */
get_header(); ?>
<link rel="stylesheet" href="<?php echo content_url();?>/themes/2012_child/colorbox.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="<?php echo content_url();?>/themes/2012_child/js/jquery.colorbox.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	});
</script>
	<div id="primary" class="site-content">
		<div id="content" role="main">
		<div class="top-featured-background">
			<div class="top-users">
				<div class="title">time travelers</div>
				<ul class="tops">
					<li>20<span>points</span> likes</li>
					<li>50<span>points</span> reblogs</li>
				</ul>
				<ul class="featured">
				<?php
				$sql = mysql_query("SELECT * FROM tumblr_posts,tumblr_account WHERE user = tumblr_username GROUP BY user ORDER BY tumblr_posts.id");
				while($row = mysql_fetch_array($sql)){				
				?>
					<li><div class="image"><a href="<?php bloginfo('home');?>/tumblr/post_list.php?user=<?php echo $row['tumblr_username'];?>" class="iframe"><img alt="<?php echo $row['tumblr_username'];?>" title="<?php echo $row['tumblr_username'];?>" src="<?php echo $row['tumblr_avatar']; ?>" width="90" /></a></div><div class="user-points"><?php echo $row['points']; ?> Points</div></li>
				<?php } ?>
				</ul>	
			</div>
		</div>			
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>