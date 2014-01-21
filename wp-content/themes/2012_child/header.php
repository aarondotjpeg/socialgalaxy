<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<!DOCTYPE html>
<?php /* <!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]--> */ ?>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>"  />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php /* <link rel="stylesheet" type="text/css" href="http://social-galaxy.com/wp-content/themes/twentytwelve/style.css" /> */ ?>
	<?php /* <link rel="stylesheet" type="text/css" href="http://social-galaxy.com/wp-content/themes/2012_child/style.css" /> */ ?>
	<?php /* <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" /> */ ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div class="header_container">
		<header id="masthead" class="site-header" role="banner">
			<?php /* <hgroup>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup> */ ?>
			<div class="inner_header">
				<div class="menu_container">
					<?php $header_image = get_header_image();
					if ( ! empty( $header_image ) ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
					<?php endif; ?>
				</div>
				<div class="nav_container">
					<script type="text/javascript">
						jQuery(document).ready(function(){
							<?php if ( is_user_logged_in() ) { ?> 
							jQuery("#menu-main-menu").append('<li id="loginmenu" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-57"><a href="<?php echo wp_logout_url(get_bloginfo('home')."/tumblr/logoutwp.php");?>")">Logout</a></li>');
							jQuery("#menu-item-8 a").attr("href","<?php bloginfo("home");?>/profile");
							jQuery(".menu_container a").attr("href","<?php bloginfo("home");?>/?log=1");
							<?php } else { ?>						
							jQuery("#menu-main-menu").append('<li id="loginmenu" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-57"><a href="<?php bloginfo('home');?>/tumblr/clearsessions.php">Login</a></li>');	
							<?php } ?>
						});
					</script>
					<nav  class="main-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
					</nav><!-- #site-navigation -->
				</div>
			</div>
		</header><!-- #masthead -->
	</div>
	<div class="wrapper_container">
	<div id="main" class="wrapper">