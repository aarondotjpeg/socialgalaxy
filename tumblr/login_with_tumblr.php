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
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_tumblr.php';

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
			}
		}		
	}	
	
	if($client->exit)
		exit;
	?>
	</div>
	<?php
	if($success)
	{
	/* echo $_SESSION['ref']; */
	$name = HtmlSpecialChars($user->response->user->name);
	$pic = "http://api.tumblr.com/v2/blog/".$blog."avatar/512";
	/* echo $pic; */
	/* echo "<img src='http://api.tumblr.com/v2/blog/".$blog."avatar/512' width='160' />";
	$count = HtmlSpecialChars($followers->response->total_users);
	echo "<br /><br /><h2>USER: ".$name."</h2><br /><b>Followers: </b><br />";
	for($x=0;$x<$count;$x++){
		echo ($x+1).". ".HtmlSpecialChars($followers->response->users[$x]->name)."<br />";
	} */
	
	$user_id = username_exists( $name );
	/* wp_login(HtmlSpecialChars($user->response->user->name), 'password', '' ); */
	if ( !$user_id and email_exists($name."@tumblr.com") == false ) {
		$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
		$user_id = wp_create_user( $name, 'password', $name."@tumblr.com" );
		$sql = mysql_query("SELECT * FROM tumblr_account WHERE user_id = ".$user_id."");		
		$refsql = mysql_query("SELECT * FROM tumblr_account WHERE tumblr_username = '".$_SESSION['ref']."'");
		if(mysql_num_rows($sql)<1){
			mysql_query("INSERT INTO tumblr_account (user_id, tumblr_username, tumblr_avatar ) VALUES (".$user_id.", '".$name."', '".$pic."')");
			/* mysql_query("INSERT INTO featured_credit(`user`, `points`, `from`)VALUES('".$name."',300,'registration')");			 */
		} else {
			mysql_query("UPDATE tumblr_account SET tumblr_username = '".$name."', tumblr_avatar = '".$pic."' WHERE user_id = ".$user_id."");
		}
		if(!empty($_SESSION['ref']) and mysql_num_rows($refsql)==1){
			mysql_query("UPDATE tumblr_account SET ref = '".$_SESSION['ref']."' WHERE user_id = ".$user_id."");
			mysql_query("UPDATE tumblr_account SET points = (points + 150) WHERE tumblr_username = '".$_SESSION['ref']."'");
			mysql_query("INSERT INTO points(`user`, `points`, `from`)VALUES('".$_SESSION['ref']."',150,'refered a friend')");
			/* mysql_query("INSERT INTO featured_credit(`user`, `points`, `from`)VALUES('".$name."',300,'registration')"); */
		}		
		?>		
		<script>
		window.location = "<?php bloginfo('home');?>/tumblr/login_with_wordpress.php";
		</script>
		<?php
	} else {
		/* echo $user_id." - Error: User already exists!<br />";		 */
		?>
		<script>
		window.location = "<?php bloginfo('home');?>/tumblr/login_with_wordpress.php";
		</script>
		<?php		
		/* echo '<pre>', HtmlSpecialChars(print_r($user, 1)), '</pre>'; */
	}
	} else {
?>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
<?php
	}

?>