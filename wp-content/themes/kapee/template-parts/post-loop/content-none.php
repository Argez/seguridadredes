<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/post-loop
 * @since 1.0
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-entry-title"><?php esc_html_e( 'Nothing Found', 'kapee' ); ?></h1>
	</header>
	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php echo wp_kses( sprintf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'kapee' ), esc_url( admin_url( 'post-new.php' ) ) ), kapee_allowed_html('a') ); ?></p>

		<?php else : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'kapee' ); ?></p>
			<?php
				get_search_form();

		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
