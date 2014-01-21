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
	session_start();
	if(empty($_SESSION['ref'])){
		$_SESSION['ref'] = $_GET['ref'];
	}
	$client = new oauth_client_class;
	$client->debug = 1;
	$client->server = 'Tumblr';
	$client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_wordpress.php';

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
				$successx = $client->CallAPI(	
					'http://api.tumblr.com/v2/blog/'.$blog.'followers', 
					'GET', array(), array('FailOnAccessError'=>true), $followers);
				$successx = $client->Finalize($successx);
				
				$successy = $client->CallAPI(
					'http://api.tumblr.com/v2/blog/'.$blog.'posts/?api_key=xMKbu9QRwkt2lcJaXyBIs9x8giNVSXwdflljGdRGk5PECvEwXh', 
					'GET', array(), array('FailOnAccessError'=>true), $posts);				
				$successy = $client->Finalize($successy);
			}
		}		
	}	
	
	if($client->exit)
		exit;
	if($success) {
		mysql_query("UPDATE wp_users SET user_pass = md5('password') WHERE user_login = '".HtmlSpecialChars($user->response->user->name)."'");
		/* wp_login(HtmlSpecialChars($user->response->user->name), 'password', '' ); */
		/* sleep(3); */
		$creds = array();
		$creds['user_login'] = $user->response->user->name;
		$creds['user_password'] = 'password';
		$creds['remember'] = false;
		$userx = wp_signon( $creds, false );
		/* time-travel start */
		$name = $user->response->user->name;
		$count = HtmlSpecialChars($posts->response->blog->posts);
		$sql2 = mysql_query("SELECT * FROM tumblr_account WHERE tumblr_username = '".$name."' AND time_travel_credit > 0");		
		$check2 = mysql_fetch_array($sql2);
		for($x=0;$x<$count;$x++){
			$post_id = HtmlSpecialChars($posts->response->posts[$x]->id);
			$reblog_key = HtmlSpecialChars($posts->response->posts[$x]->reblog_key);
			$caption = $posts->response->posts[$x]->caption;
			$image_permalink = $posts->response->posts[$x]->photos[0]->alt_sizes[0]->url;
			$sql = mysql_query("SELECT * FROM tumblr_posts WHERE user = '".$name."' AND  post_id = '".$post_id."' AND  reblog_key = '".$reblog_key."'");			
			$check = mysql_num_rows($sql);
				if($check == 0 AND $check2['time_travel_credit']>0){
					mysql_query("INSERT INTO tumblr_posts (`user`, `post_id`, `reblog_key`, `img_url`, `caption`) VALUES ('".$name."','".$post_id."','".$reblog_key."','".$image_permalink."','".$caption."')");
					/* mysql_query("UPDATE tumblr_account SET time_travel_credit = (time_travel_credit - 1) WHERE tumblr_username = '".$name."'");	 */
				}				
				/* echo $check."-".$check2['time_travel_credit']."<br />"; */
		}		
		/* time-travel end */
		if ( is_wp_error($userx) ) {
			echo $userx->get_error_message();
		} else {
		/* echo $user->response->user->name . " success!"; */
			header('location:' .get_bloginfo('home'));
		}
	} else {
?>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
<?php
	}
?>