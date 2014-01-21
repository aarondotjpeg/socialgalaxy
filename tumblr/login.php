<?php
	require('../wp-blog-header.php');
	$creds = array();
	$creds['user_login'] = $_POST['username'];
	$creds['user_password'] = $_POST['password'];
	/* $creds['remember'] = true; */
	$user = wp_signon( $creds, false );
	/* wp_signon( $creds, $secure_cookie ); */
	if ( is_wp_error($user) ) {
		echo $user->get_error_message();
	} else {
		echo "WELCOME!";
	}
?>