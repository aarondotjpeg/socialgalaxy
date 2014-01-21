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
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/timetravel_with_tumblr.php';

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
				$success = $client->Finalize($success);
				$success = $client->CallAPI(
					'http://api.tumblr.com/v2/user/info', 
					'GET', array(), array('FailOnAccessError'=>true), $user);						
				$blog = HtmlSpecialChars($user->response->user->blogs[0]->url);
				$success = $client->Finalize($success);				
				
				$blog = str_replace("http://","",$blog);
				/* $successx = $client->CallAPI(
					'http://api.tumblr.com/v2/user/like', 
					'POST', array('id' => 40699385770, 'reblog_key' => 'XG3t7qmm'), array('FailOnAccessError'=>true), $like);				
				$successx = $client->Finalize($successx); */
				
				$successy = $client->CallAPI(
					'http://api.tumblr.com/v2/blog/'.$blog.'posts/?api_key=xMKbu9QRwkt2lcJaXyBIs9x8giNVSXwdflljGdRGk5PECvEwXh', 
					'GET', array(), array('FailOnAccessError'=>true), $posts);				
				$successy = $client->Finalize($successy);
				
				/* $successz = $client->CallAPI(
					'http://api.tumblr.com/v2/blog/'.$blog.'post/reblog',
					'POST', array('id' => 40699385770, 'reblog_key' => 'XG3t7qmm'), array('FailOnAccessError'=>true), $reblog);				
				$successz = $client->Finalize($successz); */
			}
		}		
	}
	/* echo $client->like(49456420604,'i04OtZJX');	 */
	
	if($client->exit)
		exit;
	?>
	</div>
	<?php
	if($success)
	{
	/* echo $_SESSION['ref']; */
	echo 'http://api.tumblr.com/v2/blog/'.$blog.'posts/?api_key=xMKbu9QRwkt2lcJaXyBIs9x8giNVSXwdflljGdRGk5PECvEwXh';
	echo '<hr />';
	print_r($user);
	echo '<hr />';
	/* print_r($like);
	echo '<hr />';
	print_r($reblog);
	echo '<hr />'; */
	print_r($posts);
	echo '<hr />';
	echo $name = HtmlSpecialChars($user->response->user->name);
	/* echo '<hr />';
	echo $name = HtmlSpecialChars($like->response->user->name); */
	echo '<hr />';
	$count = HtmlSpecialChars($posts->response->blog->posts);
	for($x=0;$x<$count;$x++){
		echo ($x+1).". ".HtmlSpecialChars($posts->response->posts[$x]->id)."- "
		.HtmlSpecialChars($posts->response->posts[$x]->reblog_key)."<br />"
		.HtmlSpecialChars($posts->response->posts[$x]->caption)."<br />"
		.HtmlSpecialChars($posts->response->posts[$x]->photos[0]->alt_sizes[0]->url)."<hr />";
	}
	/* echo HtmlSpecialChars($posts->response->blog->title); */
	/* echo $count = HtmlSpecialChars($like->response->id); */
?>
<br /><a href="<?php bloginfo('home');?>/tumblr/clearsessions.php">It's not me!</a>	
<?php
	} else {
?>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
<?php
	}

?>