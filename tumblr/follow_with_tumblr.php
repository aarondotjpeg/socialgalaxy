<?php
/* error_reporting(0); */
/*
 * login_with_tumblr.php
 *
 * @(#) $Id: login_with_tumblr.php,v 1.2 2012/10/05 09:22:40 mlemos Exp $
 *
 */
	require('../wp-blog-header.php');
	$current_user = wp_get_current_user();
	/* require('../wp-includes/user.php'); */
	require('http.php');
	require('oauth_client.php');
	$client = new oauth_client_class;
	$client->debug = 1;
	$client->server = 'Tumblr';
	$client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/follow_with_tumblr.php';

	$client->client_id = 'xMKbu9QRwkt2lcJaXyBIs9x8giNVSXwdflljGdRGk5PECvEwXh'; $application_line = __LINE__;
	$client->client_secret = '4O45Dj1AZtVX8Y4V3tFsXGHphLQSkgFaKuaQUIpjK0obkKAPML';

	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to Tumblr Apps page http://www.tumblr.com/oauth/apps , '.
			'create an application, and in the line '.$application_line.
			' set the client_id to Consumer key and client_secret with Consumer secret. '.
			'The Default callback URL must be '.$client->redirect_uri);

	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->access_token))
			{				
				$success = $client->CallAPI(
				'http://api.tumblr.com/v2/user/info', 
				'GET', array(), array('FailOnAccessError'=>true), $user);				
				$blog = HtmlSpecialChars($user->response->user->blogs[0]->url);
				$success = $client->Finalize($success);
				$blog = str_replace("http://","",$blog);
				$sql = mysql_query("SELECT *,UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(`space_train`) as x FROM tumblr_account WHERE tumblr_username = '".$current_user->user_login."'");
				$row = mysql_fetch_array($sql);
				$sqlz = mysql_query("SELECT * FROM hack WHERE user = '".$current_user->user_login."' AND status = 'st'");
				$rowz = mysql_num_rows($sqlz);
				if(($row['x'] > 1200 AND $_GET['connect']=='ok') OR ($rowz == 1 AND $_GET['connect']=='ok')){
				$sql = mysql_query("SELECT * FROM `whosonline`");
					while($row = mysql_fetch_array($sql)) {
						if($current_user->user_login != $row['user']) {
							$successw = $client->CallAPI(
							'http://api.tumblr.com/v2/user/follow', 
							'POST', array('url'=>$row['user'].".tumblr.com"), array('FailOnAccessError'=>true), $follow);	
							$successw = $client->Finalize($successw);
						}
					}
					if($rowz == 1){
						mysql_query("DELETE FROM hack WHERE user = '".$current_user->user_login."' AND status = 'st'");
					}
					mysql_query("UPDATE tumblr_account SET space_train = now() WHERE tumblr_username = '".$current_user->user_login."'");
				?>
					<script>
						setInterval(function(){window.location = "<?php bloginfo('home');?>/profile/"},2000);
					</script>
				<?php
				} else if($_GET['connect']=='ok') {
				echo "<h3>Please wait for ".round(((1200 - $row['x'])/60))." minutes(s)</h3>";
				?>
					<script>
						setInterval(function(){window.location = "<?php bloginfo('home');?>/profile/"},2000);
					</script>
				<?php
				}
				
			}
		}		
	}
	
	if($client->exit)
		exit;
	?>
	<img src='http://api.tumblr.com/v2/blog/<?php echo $blog;?>avatar/512' width='160' />
	<?php
	if($success) {
		$sqlx = mysql_query("SELECT * FROM `whosonline` WHERE user <> '".$current_user->user_login."'");
		$followx = mysql_num_rows($sqlx);
		?>		
			<h2><a href="<?php bloginfo('home');?>/tumblr/follow_with_tumblr.php?connect=ok">Click to proceed to add (<?php echo $followx;?>) live users</a>
			<br /><a href="<?php bloginfo('home');?>/tumblr/clearsessions.php">Login as another user</a></h2>
		<?php
	} else {		
?>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
<?php
	}

?>