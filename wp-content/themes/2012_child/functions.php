<?php
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menus(
		array(
			'footer-menu' => __( 'Footer Menu' )
		)
	);
}
add_action( 'widgets_init', 'my_register_sidebars' );
function my_register_sidebars() {
	register_sidebar(
		array(
			'id' => 'footer',
			'name' => __( 'Footer' ),
			'description' => __( 'Footer' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'copyright_footer',
			'name' => __( 'Copyright_Footer' ),
			'description' => __( 'Copyright_Footer' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'left_sidebar',
			'name' => __( 'Left Sidebar' ),
			'description' => __( 'This is a custom made left sidebar, bro.' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'whos_online',
			'name' => __( 'Whos Online' ),
			'description' => __( 'This is a custom made for whos online widget.' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
}
/* add_action('get_header', 'my_filter_head'); */
function my_filter_head() {
	/* remove_action('wp_head', '_admin_bar_bump_cb');	 */
}
remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );  
function remove_admin_bar_style_frontend() {   
  echo '<style type="text/css" media="screen"> 
  html { margin-top: 0px !important; } 
  * html body { margin-top: 0px !important; } 
  </style>';  
}  
add_filter('wp_head','remove_admin_bar_style_frontend', 99); 
/* NEW */
function smarttheme_scripts_styles() {
/*     wp_enqueue_style('srm-styles-css', get_stylesheet_directory_uri().'/dist/menu.styles.all.css');
 
    wp_enqueue_script('jquery');
    wp_enqueue_script('srm-touch-js', get_stylesheet_directory_uri().'/dist/jquery.izilla.touchMenuHover.min.js', array('jquery'));
    wp_enqueue_script('srm-js', get_stylesheet_directory_uri().'/dist/menu.min.js', array('jquery', 'srm-touch-js'));
  */
    // Stop TwentyTwelve navigation from loading //
    wp_dequeue_script('twentytwelve-navigation');
}
// add_action('wp_enqueue_scripts', 'smarttheme_scripts_styles', 20);
function voodoo_custom_header_setup() {
    $header_args = array(
        'width' => 1110,
        'height' => 228
     );
    add_theme_support( 'custom-header', $header_args );
}
add_action( 'after_setup_theme', 'voodoo_custom_header_setup' );
/* wp_enqueue_style( 'twentytwelve-style', get_stylesheet_uri() ); */