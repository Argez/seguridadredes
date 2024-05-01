<?php
/**
 * Displays the post entry quote.
 *
 * @package Kapee Woocommerce theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$prefix = KAPEE_PREFIX;
$quote_meta=get_post_meta( get_the_ID());

if(! empty( $quote_meta[$prefix.'post_format_quote'] ) ){?>
	<div class="entry-quote">
		<?php echo esc_html($quote_meta[$prefix.'post_format_quote'][0]); ?>
		<span class="quote-author"> 
			<a href="<?php echo esc_url($quote_meta[$prefix.'post_format_quote_author_url'][0]); ?>" target="_blank"><?php echo esc_html($quote_meta[$prefix.'post_format_quote_author'][0]); ?></a>
		</span>
	</div>
<?php }else{
	if( has_post_thumbnail() ){?>
		<div class="post-thumbnail">
		<?php the_post_thumbnail('large');?>
		</div>
	<?php }
}