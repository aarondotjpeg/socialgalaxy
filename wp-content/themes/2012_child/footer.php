<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<div class="footer_container">
	<div style="text-align: center; margin: 0 auto; padding: 0;">
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-7058234020142948";
		/* SG Footer */
		google_ad_slot = "7949254481";
		google_ad_width = 728;
		google_ad_height = 90;
		//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
	</div>
	<footer id="colophon" role="contentinfo">
		<div class="footer_widget">
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('footer') ) : else : ?>
			<?php endif; ?>
		</div>
		<div class="the_footer_menu">
			<?php wp_nav_menu( array( 'theme_location' => 'footer-menu' )); ?>
		</div>
		<div class="site-info">
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('copyright_footer') ) : else : ?>
			<?php endif; ?>			
		</div><!-- .site-info -->
		<div class="footer_widget_2">
			
		</div>
	</footer><!-- #colophon -->
</div>
</div>
</div><!-- #page -->

<?php wp_footer(); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46868422-1', 'social-galaxy.com');
  ga('send', 'pageview');

</script>
</body>
</html>