<?php
/**
 * Template part for displaying related posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/single-post
 * @since 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! kapee_get_option('single-post-navigation', 1) ) return;

$next_post = get_next_post();
$prev_post = get_previous_post();
if(!empty($prev_post) || !empty($next_post)){
?>
	<div class="navigation post-navigation">			
		<div class="nav-previous">
			<?php if(!empty($prev_post)) {?>
				<a href="<?php echo esc_url( get_permalink($prev_post->ID) ); ?>" rel="prev">
					<span class="nav-subtitle"><?php esc_html_e('Previous', 'kapee'); ?></span>
					<span class="nav-title h5"><?php echo get_the_title($prev_post->ID); ?></span> 
				</a>
			<?php }?>
		</div>			
		<div class="nav-archive">
			<a href="<?php echo esc_url( get_post_type_archive_link( get_post_type() ) ); ?>"><i class="pls-grid"></i></a>
		</div>
		<div class="nav-next">
			<?php if(!empty($next_post)) {?>
				<a href="<?php echo esc_url( get_permalink($next_post->ID) ); ?>" rel="next">
					<span class="nav-subtitle"><?php esc_html_e('Next', 'kapee'); ?></span>
					<span class="nav-title h5"><?php echo get_the_title($next_post->ID); ?></span>
				</a>
			<?php }?>
		</div>
	</div><!-- .post-navigation -->
<?php }