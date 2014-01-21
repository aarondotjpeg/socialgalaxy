<?php
require('../wp-blog-header.php');
	$sql = mysql_query("SELECT * FROM tumblr_posts WHERE user = '".$_GET['user']."'");
	while($row = mysql_fetch_array($sql)){
?>
<div align="center">
		<img src="<?php echo $row['img_url'];?>" /><br />
		<?php echo $row['caption'];?>
		<a href="<?php bloginfo('home');?>/tumblr/like_with_tumblr.php?user=<?php echo $row['user'];?>&post_id=<?php echo $row['post_id'];?>&token=<?php echo $row['reblog_key'];?>" title="like this blog"><img src="<?php echo content_url();?>/themes/2012_child/images/tumblr_like.png" /></a>
		<span style="width:50px;">&nbsp;</span>
		<a href="<?php bloginfo('home');?>/tumblr/reblog_with_tumblr.php?user=<?php echo $row['user'];?>&post_id=<?php echo $row['post_id'];?>&token=<?php echo $row['reblog_key'];?>" title="reblog this blog"><img src="<?php echo content_url();?>/themes/2012_child/images/tumblr_reblog.png" /></a><hr />
<?php
	}
?>
</div>