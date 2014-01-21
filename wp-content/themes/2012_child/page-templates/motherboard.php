<?php
/**
 * Template Name: motherboard
 *
 */

get_header(); ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#click-post").click(function(){
		jQuery("#post").toggle(1000);
	});
});		
</script>
	<div id="primary" class="site-content">
		<div id="content" role="main">
		<div class="motherboard-links">
		<h1 class="title">featured links</h1>	
			<div class="list">
			<?php
			$sql = mysql_query("SELECT * FROM featured_links ORDER BY postedon DESC");
			if(mysql_num_rows($sql) > 0){
			?>
			<ul>
			<?php				
				while($row = mysql_fetch_array($sql)){
			?>			
				<li><a href="<?php echo $row['url'];?>"><?php echo $row['title'];?></a></li>
			<?php } ?>
			</ul>
			<?php } else { ?>
			<div style="margin: 50px 0 0;"><h1 style="font-size: 24px;">No featured links have been posted yet. <a href="<?php bloginfo('home');?>/use-points/">Use Points</a></h1></div>
			<?php } ?>
			</div>
			<div class="slider-background"></div>
		</div>
		<br />
		<h1>bulletin board</h1><h1 style="font-size: 24px;">Promote your Tumblr blog here. Make a Post!</h1>
		<div class="addmsg">
		<button id="click-post" class="button">MAKE A POST</button>		
		<div id="post" style="display:none;" align="center">
		<form action="" method="POST">
		<h3>Notice: You can make a bulletin post every 5 minutes.</h3><br />
		<input type="text" name="msg" value="" maxlength="100" size="50" placeholder="maximum of 100 characters including spaces" />
		<input type="hidden" value="<?php echo $_GET['tumblr_name'];?>" name="tumblr_name" />
		<input type="submit" value="post to bulletin board" name="sub-post" />
		<br />
		<br />
		<h3>Unable to post due of the limit rules?</h3><br />
		<button id="motherboardskip" onclick="return false" href="#">bulletin board skip</button><br /><br />
		<div>click this button to <a href="<?php bloginfo('home');?>/use-points/">use points</a> to 'bulletin board skip'</a></div><br />
		<div id="result"></div>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#motherboardskip").click(function(){
				jQuery.ajax({
					type: "POST",
					url: "<?php bloginfo('home');?>/ajax/points.php",
					data: "up=ms&user=<?php echo $_GET['tumblr_name'];?>",
					success: function(data) {
						jQuery('#result').hide(100).fadeIn(4000).html(data).fadeOut(8000);
					}
				});
			});
		})
		</script>
		</form>
		</div>
		<div class="pagination">
		<?php
		/* echo date("Y-m-d h:m:s")."<br />"; */
		/* $sql = mysql_query("SELECT * FROM motherboard, tumblr_account WHERE tumblr_name = tumblr_username ORDER BY motherboard.id DESC");		
		$items = mysql_num_rows($sql);
		$mod = $items / 10;
		$page = ceil($mod);
		echo $items.'<br />';
		for ($n=$page; $n<=1; $n--) {
			echo $n;
		} */
		?>
		<!--<a href="?page=<?php echo $w;?>"><?php echo $w;?></a>-->
		</div>
		<ul id="motherboardul">
		<?php
		if(isset($_POST['sub-post'])) {			
			$sqly = mysql_query("select UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(cdate) as minx FROM motherboard WHERE tumblr_name = '".$_POST['tumblr_name']."' ORDER BY cdate DESC LIMIT 1");
			$rowy = mysql_fetch_array($sqly);
			$sqlx = mysql_query("SELECT * FROM tumblr_account WHERE tumblr_username = '".$_POST['tumblr_name']."'");
			$rowx = mysql_fetch_array($sqlx);
			$sqlz = mysql_query("SELECT * FROM hack WHERE user = '".$_POST['tumblr_name']."' AND status = 'ms'");
			$rowz = mysql_num_rows($sqlz);
			/* echo $rowy['minx']; */
			if($rowy['minx']==0){
				$rowy['minx'] = 300;
			}
			if($rowy['minx'] < 300 AND $rowz == 0){
			$time = round(((300 - $rowy['minx'])/60));
			
				if($time > 1){
				?>
				<script>
				alert('Wait for <?php echo $time . " minutes";?> to make another post.');
				</script>
				<?php
				} else {
				?>
				<script>
					alert('Wait for <?php echo round((300 - $rowy['minx'])). " seconds";?> to make another post.');
				</script>
				<?php
				}
			} else if($rowy['minx'] >= 300 OR $rowz == 1) {
				mysql_query("UPDATE tumblr_account SET points = (points + 10) WHERE tumblr_username = '".$_POST['tumblr_name']."'");
				if($rowz == 1){
					mysql_query("DELETE FROM hack WHERE user = '".$_POST['tumblr_name']."' AND status = 'ms'");
				}
				mysql_query("INSERT INTO motherboard (tumblr_name, msg) VALUES ('".$_POST['tumblr_name']."', '".$_POST['msg']."')");
				mysql_query("INSERT INTO points SET `user` = '".$_POST['tumblr_name']."', `points` = 10, `from` = 'Posting bulletin'");				
			}
				/* SELECT ACCOUNT */
			
		}
			$sql = mysql_query("SELECT * FROM motherboard, tumblr_account WHERE tumblr_name = tumblr_username ORDER BY motherboard.id DESC");
			$y = 1;
			while($row = mysql_fetch_array($sql)){
			$x++; if($x == 10) {$y++;$x=0;} 
			$token = substr(md5($current_user->ID),10, 10).'w'.substr(md5($row['tumblr_name']),0, 9).'g'.substr(md5($row['tumblr_name']),5, 10);
			?>
			<li class="items page-item-<?php echo $y;?>"><a href="<?php bloginfo('home');?>/tumblr/tumblrlink.php?follow=<?php echo $row['tumblr_name'];?>&id=<?php echo $current_user->ID;?>&token=<?php echo $token;?>" style="float:left;"><img src="<?php echo $row['tumblr_avatar'];?>" width="100" /><div style="clear:both;"><?php echo $row['tumblr_name'];?></div></a><span class="msg"><?php echo $row['msg'];?></span></li>
			<?php
			}
		?>
		</ul>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>