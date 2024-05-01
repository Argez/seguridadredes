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

if ( empty( get_the_author_meta( 'description' ) ) || ! kapee_get_option('single-post-author-info', 1) ) {
	return;
}
?>

<div class="author-info">			
	<div class="author-avatar">
		<?php				
		$author_bio_avatar_size = apply_filters( 'kapee_author_bio_avatar_size', 75 );
		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
	</div><!-- .author-avatar -->

	<div class="author-description">
		<h4 class="author-title"><?php printf( esc_html__( 'About %s', 'kapee' ), get_the_author() ); ?></h4>

		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
				<?php printf( esc_html__( 'View all posts by %s', 'kapee' ), get_the_author() ); ?>
			</a>
		</p><!-- .author-bio -->

	</div><!-- .author-description -->
</div><!-- .author-info -->
