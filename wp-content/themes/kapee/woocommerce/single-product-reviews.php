<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="row woocommerce-Reviews">
	<div id="comments" class="col-12 col-md-7">
		
		<?php if ( 'fancy-rating' == kapee_get_option( 'products-rating-style', 'fancy-rating' ) && kapee_get_option('products-rating-histogram', 1 ) ){ //Kapee
			kapee_fancy_rating_summary();
		}else{ ?>			
			<h4 class="woocommerce-Reviews-title">
				<?php
				$count = $product->get_review_count();
				if ( $count && wc_review_ratings_enabled() ) {
					/* translators: 1: reviews count 2: product name */
					$reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'kapee' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
					echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
				} else {
					esc_html_e( 'Reviews', 'kapee' );
				}?>
			</h4>
		<?php }?>
		
		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text'	=>  esc_html__( 'Previous', 'kapee' ),
							'next_text' => esc_html__( 'Next', 'kapee' ),
							'type'      => 'plain',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'kapee' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper" class="col-12 col-md-5">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'kapee' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'kapee' ), get_the_title() ),
						'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'kapee' ),
						'title_reply_before'   => '<h4 id="reply-title" class="comment-reply-title">',
						'title_reply_after'    => '</h4>',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'kapee' ) . '&nbsp;<span class="required">*</span></label> ' .
										'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></p>',
							'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'kapee' ) . '&nbsp;<span class="required">*</span></label> ' .
										'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></p>',
						),
						'label_submit'  => esc_html__( 'Submit', 'kapee' ),
						'logged_in_as'  => '',
						'comment_field' => '',
					);

					$account_page_url = wc_get_page_permalink( 'myaccount' );
					if ( $account_page_url ) {
						/* translators: %s opening and closing link tags respectively */
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'kapee' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
					}

					if ( wc_review_ratings_enabled() ) {
						$rating_style = kapee_get_option('products-rating-style','fancy-rating'); //Kapee
						$comment_form['comment_field'] = '<div class="comment-form-rating '.esc_attr($rating_style).'"><label for="rating">' . esc_html__( 'Your rating', 'kapee' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'kapee' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'kapee' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'kapee' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'kapee' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'kapee' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'kapee' ) . '</option>
						</select></div>';
					}

					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'kapee' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'kapee' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
