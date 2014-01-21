<?php
/**
 * Template Name: Help Page Template
 *
 */
get_header(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->
		<div class="submit-ticket">
			<div class="title">submit a ticket</div>
			<?php echo do_shortcode('[contact-form-7 id="103" title="Contact form 1"]');?>
		</div>
	</div><!-- #primary -->
<?php get_footer(); ?>