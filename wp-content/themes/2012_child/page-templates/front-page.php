<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<?php
$current_user = wp_get_current_user();
if($_GET['log'] == 0 and $current_user->ID > 0) {
?>
<script type="text/javascript">window.location = '<?php echo home_url();?>/profile';</script>
<?php
} elseif(empty($_GET['log']) and $current_user->ID > 0){
?>
<script type="text/javascript">window.location = '<?php echo home_url();?>/?log=<?php echo $x++;?>'</script>
<?php	
}
?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.cycle.lite.js"></script>
<script type="text/javascript">
    jQuery(function() {
		jQuery('.slideshow').cycle({
			fx:      'fade',
			speed:  'fast',
			timeout:  4000,
			interval: true,
			prev:    '#prev',
			next:    '#next'
		});
	});
</script>
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<h1 class="home-title">welcome astronaut</h1>
			<h2 class="home-title2">promote your social life. the simplest way to gain followers, likes and reblogs on tumblr.</h2>
			<div class="slider-background">
				<div id="slider">
					<ul>
						<li><div id="prev"><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/left-button.png"></a></div></li>
						<li>
						    <div class="slideshow"> 
								<a href="become-featured"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/keyhole.png"></a>
								<a href="become-featured"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/man.png"></a>
								<a href="how-it-works"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/saturn.png"></a>
							</div>	
						</li>
						<li><div id="next"><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/right-button.png"></a></div></li>
					</ul>
				</div>
			</div>
			
			<div class="bottom-content">
				<div class="get-started">Get Started</div>
				<?php
				$current_user = wp_get_current_user();
				if ( 0 == $current_user->ID ) {
				?>
				<a href="tumblr/login_with_tumblr.php"><div class="button">Click to Start</div></a>
				<div class="terms">You agree to the <a href="/terms-of-service" title="Terms of Service">Terms of Service</a></div>
				<?php
				} else {
				?>
				<a href="profile/"><div class="button">Go to Profile</div></a>
				<?php
				}
				$tsql = mysql_query("SELECT * FROM follow");
				$dsql = mysql_query("SELECT * FROM follow WHERE DATE_FORMAT(cdate,'%W %M %Y') =DATE_FORMAT(now(),'%W %M %Y')");
				$tfollow = mysql_num_rows($tsql);
				$dfollow = mysql_num_rows($dsql);
				?>
				<script type="text/javascript">
					jQuery(function() {
						var x = 0;
						jQuery(".wpwhosonline-active").each(function(){
							x++;
						});
						jQuery("#online").html(x + '<p>users online</p>');
					});
				</script>
				<div style="display:none;">
				<?php dynamic_sidebar( 'whos_online' ); ?>
				</div>
				<div class="counter">
					<ul class="list1">
						<li class="list1"><?php echo $dfollow;?><p>follows created today</p></li>
						<li class="list2" id="totalpoints"><?php echo $tfollow;?><p>total follows created</p></li>
						<li class="list3" id="online">0</li>
					</ul>
				</div>
			</div>

		</div><!-- #content -->
	</div><!-- #primary -->
</script>
<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>