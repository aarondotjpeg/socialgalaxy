<?php
/**
 * Template Name: Use Points Page Template
 *
 */
get_header();
$current_user = wp_get_current_user();
if(!empty($_POST['feature_link']) AND !empty($_POST['feature_url'])){
	$sqlx = mysql_query("SELECT * FROM tumblr_account WHERE tumblr_username = '".$current_user->user_login."'");
	$rowx = mysql_fetch_array($sqlx);
	if($rowx['points']>=4500){
		mysql_query("UPDATE tumblr_account SET points = (points - 4500) WHERE tumblr_username = '".$current_user->user_login."'");
		mysql_query("INSERT INTO featured_links (`user`,`title`,`url`) VALUES ('".$current_user->user_login."','".$_POST['feature_link']."','".$_POST['feature_url']."')");
	?>
	<script type="text/javascript">
		alert('congratulations!\n your featured link is already posted on bulletin board.');
		window.location = "";
	</script>
	<?php } else {
	?>
	<script type="text/javascript">
		alert('not enough points to post featured link.');
	</script>
	<?php
	}
}
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".use_points").click(function(){
		var upside = jQuery(this).attr('up');
		jQuery.ajax({
			type: "POST",
			url: "<?php bloginfo('home');?>/ajax/points.php",
			data: "up=" + upside + "&user=<?php echo $current_user->user_login;?>",
			success: function(data) {
				jQuery('#xoxo').show(100).fadeIn(4000).html(data).fadeOut(6000); 
			}
		});
	 });
});
</script>
<style type="text/css" scoped>
#xoxo {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #479CD1;
    border-radius: 5px 5px 5px 5px;
    box-shadow: 0 0 5px 6px #479CD1;
    color: #111111;
    display: none;
    font-size: 15px;
    font-weight: bold;
    height: 40px;
    line-height: 33px;
    margin: 310px 215px;
    position: absolute;
    text-align: center;
    width: 500px;
}
</style>
<div id="xoxo"></div>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<div id="dialog" style="display:none;" title="Featured Link">
<form action="" method="POST">
<p>Notice: Please put a valid value. Title for featured links should not be more than 20 characters.</p><br />
<table>
<tr><td>Featured Link Url</td><td>Featured Link Title<br /></td></tr>
<tr><td><input type="url" name="feature_url" value="" required placeholder="ex: http://domain.com" /></td><td><input type="text" maxlength="20" name="feature_link" value="" required placeholder="ex: my featured link" /></td></tr>
<tr><td colspan="2"><button class="button" onclick="submit()">POST</button></td></tr>
</table>
</form>
</div>
<script type="text/javascript">
 /* var f = jQuery.noConflict(); */
  jQuery(function() {
  /* $(document).ready(function(){ */
    jQuery( "#dialog" ).dialog({
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
    jQuery("#opener" ).click(function() {
		jQuery( "#dialog" ).dialog( "open" );
    });
  });
</script>
<style type="text/css">
	.ui-dialog {
		width: 600px!important;
	}
	#dialog {
		min-height: 0!important;
	}
</style>
	<div id="primary" class="site-content">
		<div id="content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
		<div class="earn-points">
			<div class="title">how to earn points</div>
			<div class="border">
				<ul>
					<li>
						<div class="points">
							<div class="ring"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/2012_child/images/ring.png"></div>
							<div class="number">10-20-50 <span>points</span></div>
							<div class="detail following">following other users</div>
						</div>
					</li>
					<li>
						<div class="points">
							<div class="ring"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/2012_child/images/ring.png"></div>
							<div class="number ten">10 <span>points</span></div>
							<div class="detail post">post on bulletin board</div>
						</div>
					</li>
					<li>
						<div class="points">
							<div class="ring"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/2012_child/images/ring.png"></div>
							<div class="number">1000 <span>points</span></div>
							<div class="detail connect">connect your tumblr</div>
						</div>
					</li>
					<li class="second">
						<div class="points">
							<div class="ring"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/2012_child/images/ring.png"></div>
							<div class="number">150 <span>points</span></div>
							<div class="detail refer">refer your friends</div>
						</div>
					</li>
					<li class="second">
						<div class="points">
							<div class="ring"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/2012_child/images/ring.png"></div>
							<div class="number">20-50 <span>points</span></div>
							<div class="detail time">like or reblog content</div>
						</div>
					</li>
				</ul>
			</div>
		</div>		
		<div class="your-rewards">
			<div class="title">use your points here</div>
			<div class="border2">
				<ul>
					<li>
						<div class="points">
							<div class="ring"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/2012_child/images/ring2.png"></div>
							<div class="number">100 <span>points</span></div>
							<div class="detail following"><a class="use_points" href="#" up="ms">bulletin board skip</a></div>
						</div>
					</li>
					<li>
					
						<div class="points">
							<div class="ring"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/2012_child/images/ring2.png"></div>
							<div class="number">500 <span>points</span></div>
							<div class="detail post"><a class="use_points" href="#" up="st">add live users skip</a></div>
						</div>
					</li>
					<li>
						<div class="points">
							<div class="ring"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/2012_child/images/ring2.png"></div>
							<div class="number">4,500 <span>points</span></div>
							<div class="detail connect"><a id="opener" href="#dialog">post a featured link</a></div>
						</div>
					</li>
					<li class="second">
						<div class="points">
							<div class="ring"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/2012_child/images/ring2.png"></div>
							<div class="number">9,500 <span>points</span></div>
							<div class="detail time"><a class="use_points" href="#" up="fc">1 free featured credit</a></div>
						</div>
					</li>
					<li class="second"> 
					<div class="points">
							<div class="ring"><img src="<?php bloginfo('siteurl'); ?>/wp-content/themes/2012_child/images/ring2.png"></div>
							<div class="number">9,500 <span>points</span></div>
							<div class="detail refer"><a class="use_points" href="#" up="ttc">1 free content credit</a></div>
						</div>
					</li>
				</ul>			
			</div>
		</div>
	</div><!-- #primary -->
<?php get_footer(); ?>