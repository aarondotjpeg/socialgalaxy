<?php
/* error_reporting(0); */
/*
 * login_with_tumblr.php
 *
 * @(#) $Id: login_with_tumblr.php,v 1.2 2012/10/05 09:22:40 mlemos Exp $
 *
 */
	require('../wp-blog-header.php');
	/* require('../wp-includes/user.php'); */
	require('http.php');
	require('oauth_client.php');
	$client = new oauth_client_class;
	$client->debug = 1;
	$client->server = 'Tumblr';
	$client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/connect_with_tumblr.php';

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
			}
		}		
	}
	
	if($client->exit)
		exit;
	?>
	<img src='http://api.tumblr.com/v2/blog/<?php echo $blog;?>avatar/512' width='160' />
	<?php
	if($success) {		
	$sql = mysql_query("SELECT *,UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(`connected`) as x FROM tumblr_account WHERE tumblr_username = '".$current_user->user_login."'");
	$row = mysql_fetch_array($sql);
	/* echo $row['x']; */
		if($row['x'] > 86400 AND $_GET['connect']=='ok') {
			mysql_query("UPDATE tumblr_account SET `points` = (points + 1000),tumblr_avatar = 'http://api.tumblr.com/v2/blog/".$blog."avatar/512', connected = now() WHERE tumblr_username = '".$current_user->user_login."'");
			mysql_query("INSERT INTO points(`user`, `points`, `from`)VALUES('".$current_user->user_login."',1000,'Connecting tumblr account')");
			echo "<h3>You get 1000 points connecting your tumblr!</h3>";
			?>
			<script>
				setInterval(function(){window.location = "<?php bloginfo('home');?>/profile/"},2000);
			</script>
			<?php
		} else {
			$hr = round((86400 - $row['x'])/60/60);
			if($hr < 0){
				echo "<h3>Please click connect</h3>";
			} else {
				echo "<h3>Please wait for ".$hr." hour(s)</h3>";
			}
			
			?>
			<script>
				setInterval(function(){window.location = "<?php bloginfo('home');?>/profile/"},2000);
			</script>
			<?php
		}
		if($row['x'] > 86400){
		?>		
			<h2><a href="<?php bloginfo('home');?>/tumblr/connect_with_tumblr.php?connect=ok">Click to connect your Tumblr Account</a>		
			<br /><a href="<?php bloginfo('home');?>/tumblr/clearsessions.php">Login as another user</a></h2>
		<?php } ?>
		<?php
	} else {		
?>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
<?php
	}

?>