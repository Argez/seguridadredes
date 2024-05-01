<?php
/**
 * Displays the post entry highlight
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/post-loop
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$meta_values = kapee_get_loop_prop( 'specific-post-meta' );

if( ! kapee_get_loop_prop('post-meta') || empty($meta_values) ) return;
?>
	<div class="entry-meta">
	
		<?php do_action('kapee_loop_post_meta_top');?>		
		
		<?php foreach ( $meta_values as $meta_value ) :

			switch ( $meta_value ) {
				case 'post-author': ?>	
					<span class="author-link vcard">
						<?php esc_html_e( 'By', 'kapee' );?>
						<?php if( ! kapee_get_loop_prop( 'post-meta-icon' ) ){
							echo get_avatar( get_the_author_meta( 'ID' ), 32, '', 'author-avatar' ); 
						} ?> 
						<?php echo the_author_posts_link(); ?>
					</span> <?php					
					break;
				case 'post-date': 					
					$format = apply_filters( 'kapee_post_date_format', '' );?>					
					<span class="posted-date">
						<a href="<?php echo esc_url( get_permalink() );?> "><?php echo get_the_date( $format ); ?></a>
					</span>	<?php					
					break;
				case 'post-category': 
					$categories_list = get_the_category_list( esc_html__( ', ', 'kapee' ) );
					if ( $categories_list ) {?>					
						<span class="cat-links"><?php echo wp_kses_post($categories_list);?> </span><?php
					}
					break;
				case 'post-tags':
					$tags_list = get_the_tag_list( '', esc_html__( ', ', 'kapee' ) );
					if ( $tags_list ) {?>					
						<span class="tags-links"><?php echo wp_kses_post($tags_list);?> </span><?php
					}
					break;
				case 'post-comments':				
					if( ! post_password_required() && ( comments_open() || get_comments_number() ) ){?>
						<span class="comments-count">
							<?php 
							$comment_tag = '%s<span class="post-meta-label"> %s</span>';			
							comments_popup_link( 
								sprintf( $comment_tag, '0', esc_html__( 'Comments', 'kapee' ) ),
								sprintf( $comment_tag, '1', esc_html__( 'Comment', 'kapee' ) ),
								sprintf( $comment_tag, '%', esc_html__( 'Comments', 'kapee' ) )
							);?>			
						</span><?php 
					}
					break;
				case 'post-views':
					kapee_post_views();
					break;
				case 'post-rtime':?>
					<span class="post-read-time">
						<?php $reading_time = kapee_get_post_reading_time();?>						
						<span class="post-meta-label">
							<?php echo sprintf( _n( '%s Minute read', '%s Minute read', $reading_time, 'kapee' ), $reading_time );?>
						</span>
					</span>
					<?php 
					break;
				case 'post-share':
					if ( function_exists( 'kapee_social_share' ) ) { ?>
						<div class="post-share">
							<span class="post-meta-label">
								<?php esc_html_e('Share', 'kapee');?>
							</span>							
							<div class="meta-share-links">
								<?php kapee_social_share( array( 'type'=>'share' ) );?>
							</div>							
						</div>
					<?php } 
					break;				
				case 'post-edit':
					edit_post_link( sprintf(esc_html__( 'Edit ', 'kapee' ) ), '<span class="edit-link">', '</span>');
					break;
				default:				
			}
		endforeach; ?>		
		
		<?php do_action('kapee_loop_post_meta_bottom');?>		
		
	</div>