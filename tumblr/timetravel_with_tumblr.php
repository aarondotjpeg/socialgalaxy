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
	$name = HtmlSpecialChars($user->response->user->name);
	$count = HtmlSpecialChars($posts->response->blog->posts);
	for($x=0;$x<$count;$x++){
		$post_id = HtmlSpecialChars($posts->response->posts[$x]->id);
		$reblog_key = HtmlSpecialChars($posts->response->posts[$x]->reblog_key);
		$caption = $posts->response->posts[$x]->caption;
		$image_permalink = $posts->response->posts[$x]->photos[0]->alt_sizes[0]->url;
		$sql = mysql_query("SELECT * FROM tumblr_posts WHERE user = '".$name."' AND  post_id = '".$post_id."' AND reblog_key = '".$reblog_key."'");
		$sql2 = mysql_query("SELECT * FROM tumblr_account WHERE tumblr_username = '".$name."'");
		$check = mysql_num_rows($sql);
		$check2 = mysql_fetch_array($sql2);
		if($check == 0 AND $check2['time_travel_credit']>0){
			mysql_query("INSERT INTO tumblr_posts (`user`, `post_id`, `reblog_key`, `img_url`, `caption`) VALUES ('".$name."','".$post_id."','".$reblog_key."','".$image_permalink."','".$caption."')");
			$w = 1;
		} else if($check == 1){
			$w = 2;
		} else if($check2['time_travel_credit']=0) {
			$w = 3;
		}
	}
	if($w==1){
		mysql_query("UPDATE tumblr_account SET time_travel_credit = (".$check2['time_travel_credit']." - 1) WHERE tumblr_username = '".$name."'");
	} else if($w == 2){
		echo 'Sorry, you are already time traveled!';
	} else if($w == 3){
		echo 'Sorry you have no Time Travel Credits!';
	}
	
	$name = HtmlSpecialChars($user->response->user->name);
	$pic = "http://api.tumblr.com/v2/blog/".$blog."avatar/512";
	/* echo $pic; */
	echo "<img src='http://api.tumblr.com/v2/blog/".$blog."avatar/512' width='160' />";
?>
<br /><h2><a href="<?php bloginfo('home');?>/profile/?time_travel=ok">Click to proceed to Time Travel</a>
<br /><a href="<?php bloginfo('home');?>/tumblr/clearsessions.php">Wait, it's not me!</a></h2>
<?php
	} else {
?>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
<?php
	}

?>