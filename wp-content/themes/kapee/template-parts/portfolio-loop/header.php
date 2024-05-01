<?php
/**
 * Displays the portfolio entry header
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/portfolio
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<header class="entry-header">

	<?php
	/**
	 * Hook: kapee_portfolio_loop_header.
	 *
	 * @hooked kapee_template_portfolio_loop_categories - 10
	 * @hooked kapee_template_portfolio_loop_title - 20
	 */
	do_action( 'kapee_portfolio_loop_header' );
	?>
	
</header><!-- .entry-header -->