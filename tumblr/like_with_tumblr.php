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
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/like_with_tumblr.php';

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
				
				$successx = $client->CallAPI(
					'http://api.tumblr.com/v2/user/like', 
					'POST', array('id' => $_GET['post_id'], 'reblog_key' => $_GET['token']), array('FailOnAccessError'=>true), $like);				
				$successx = $client->Finalize($successx);		
			}
		}		
	}
	
	if($client->exit)
		exit;
	?>
	</div>
	<?php
	if($success) {	
	$sql = mysql_query("SELECT * FROM time_travel_action WHERE `user` = '".$current_user->user_login."' AND `post_id` = '".$_GET['post_id']."' AND `reblog_key`= '".$_GET['token']."' AND `action`='like'");
	$check = mysql_num_rows($sql);
	if($check == 0) {
		if(HtmlSpecialChars($user->meta->msg)=='OK') {
			mysql_query("UPDATE tumblr_account SET `points` = points + 20 WHERE tumblr_username = '".$current_user->user_login."'");
			mysql_query("INSERT INTO points(`user`, `points`, `from`)VALUES('".$current_user->user_login."',20,'Liking a blog post')");
			mysql_query("INSERT INTO time_travel_action (`user`, `post_id`, `reblog_key`, `action`) VALUES ('".$current_user->user_login."','".$_GET['post_id']."','".$_GET['token']."','like');");
			echo "You get 20 points for Liking the post!";
		}
	} else {
		echo "You have like this post already.";
	}
?>
<script>
	setInterval(function(){window.location = "post_list.php?user=<?php echo $_GET['user'];?>"},2000);
</script>
<?php
	} else {
?>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
<?php
	}

?>