<?php
/**
 * Displays the post entry image / gallery / audio / video etc. As per the post format.
 *
 * @package Kapee Woocommerce theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() || is_attachment() || ! kapee_get_option('single-post-thumbnail', 1) ) {
	return;
}
$post_format = get_post_format(); 
switch ( $post_format ) {
	case 'image':
		$output = kapee_get_image_from_post();
		break;

	case 'gallery':
		$output = kapee_get_gallery_from_post();
		break;
		
	case 'video':
		$output = kapee_get_video_from_post();
		break;

	case 'audio':
		$output .= kapee_get_audios_from_post();
		break;
		
	case 'quote':
		$output .= kapee_get_quote_from_post();
		break;
		
	case 'link':
		$output .= kapee_get_link_from_post();
		break;
		
	default:
		if( has_post_thumbnail() ){?>
			<div class="post-thumbnail">
				<?php echo kapee_get_post_thumbnail('full'); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped  ?>
			</div>
		<?php }
		break;
}