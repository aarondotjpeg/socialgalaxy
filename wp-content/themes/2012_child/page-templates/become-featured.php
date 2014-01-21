<?php
/**
 * Template Name: Become Featured Page Template
 *
 */
get_header(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; // end of the loop. ?>
		</div><!-- #content -->	
			<div class="buy-credits">get credits</div>
			<div class="featured-user">
				<div class="title">Get more Followers</div>					
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<div class="choose">				
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="aarondotjpeg@gmail.com">
				<input type="hidden" name="lc" value="US">
				<input type="hidden" name="item_name" value="Featured Credits">
				<input type="hidden" name="button_subtype" value="services">
				<input type="hidden" name="no_note" value="0">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="tax_rate" value="0.000">
				<input type="hidden" name="shipping" value="0.00">
				<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
				<input type="hidden" name="on0" value="Featured Credits">			
				<input type="hidden" name="on1" value="Username">
				<input type="hidden" name="return" value="<?php bloginfo('home');?>/profile/">
				<!--<input name="payout" value="<?php//bloginfo('home');?>/tumblr/fcpaypal.php" type="hidden">-->
				<input name="notify_url" value="<?php bloginfo('home');?>/tumblr/fcpaypal.php" type="hidden">
				<!--<input name="paymentaction" value="<?php //bloginfo('home');?>/tumblr/fcpaypal.php?user=<?php  //echo $current_user->user_login;?>&pay=1" type="hidden">-->
					<select name="os0">
						<option value="Featured Credit - 1 day">Featured Credit - 1 day $5.00 USD</option>
						<option value="Featured Credits - 3 day">Featured Credits - 3 day $15.00 USD</option>
						<option value="Featured Credits - 7 day">Featured Credits - 7 day $35.00 USD</option>
						<option value="Featured Credits - 30 day">Featured Credits - 30 day $75.00 USD</option>
					</select>
					<input type="hidden" name="os1" value="<?php echo $current_user->user_login;?>" maxlength="200">
				</div><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="option_select0" value="Featured Credit - 1 day">
				<input type="hidden" name="option_amount0" value="5.00">
				<input type="hidden" name="option_select1" value="Featured Credits - 3 day">
				<input type="hidden" name="option_amount1" value="15.00">
				<input type="hidden" name="option_select2" value="Featured Credits - 7 day">
				<input type="hidden" name="option_amount2" value="35.00">
				<input type="hidden" name="option_select3" value="Featured Credits - 30 day">
				<input type="hidden" name="option_amount3" value="75.00">
				<input type="hidden" name="option_index" value="0">
				<div class="buy-now"><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></div>
				<div class="card"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"></div>	
			</div>
			</form>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<div class="time-traveler">
				<div class="title">Get more Likes &amp; Reblogs</div>
				<div class="choose">				
				<input type="hidden" name="return" value="<?php bloginfo('home');?>/profile/">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="aarondotjpeg@gmail.com">
				<input type="hidden" name="lc" value="US">
				<input type="hidden" name="item_name" value="Time Travel Credits">
				<input type="hidden" name="button_subtype" value="services">
				<input type="hidden" name="no_note" value="0">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="tax_rate" value="0.000">
				<input type="hidden" name="shipping" value="0.00">
				<input type="hidden" name="on0" value="Time Travel Credits">
				<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
				<input type="hidden" name="on1" value="Username">
				<!--input name="payout" value="<?php //bloginfo('home');?>/tumblr/ttcpaypal.php" type="hidden"-->
				<input name="notify_url" value="<?php bloginfo('home');?>/tumblr/ttcpaypal.php" type="hidden">
					<select name="os0">
						<option value="Time Travel Credit - 1 day">Content Credit - 1 day $5.00 USD</option>
						<option value="Time Travel Credits - 3 day">Content Credits - 3 day $15.00 USD</option>
						<option value="Time Travel Credits - 7 day">Content Credits - 7 day $35.00 USD</option>
						<option value="Time Travel Credits - 30 day">Content Credits - 30 day $75.00 USD</option>
					</select>
					<input type="hidden" value="<?php echo $current_user->user_login;?>" name="os1" maxlength="200">
				</div>
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="option_select0" value="Time Travel Credit - 1 day">
				<input type="hidden" name="option_amount0" value="5.00">
				<input type="hidden" name="option_select1" value="Time Travel Credits - 3 day">
				<input type="hidden" name="option_amount1" value="15.00">
				<input type="hidden" name="option_select2" value="Time Travel Credits - 7 day">
				<input type="hidden" name="option_amount2" value="35.00">
				<input type="hidden" name="option_select3" value="Time Travel Credits - 30 day">
				<input type="hidden" name="option_amount3" value="75.00">
				<input type="hidden" name="option_index" value="0">
				<div class="buy-now"><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></div>
				<div class="card"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"></div>	
			</div>
			</form>
	</div><!-- #primary -->
<?php get_footer(); ?>