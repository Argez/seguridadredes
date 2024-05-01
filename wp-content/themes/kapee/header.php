<?php
/**
 * The header of theme
 *
 * @author 	PressLayouts
 * @package kapee
 * @since 1.0.0
 */
 
?><!DOCTYPE html>
<?php do_action( 'kapee_before_html' ); ?>
<html <?php language_attributes(); ?>>
<head>
	<?php do_action( 'kapee_head_top' ); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="profile" href="<?php echo kapee_get_protocol();?>//gmpg.org/xfn/11" />	
	<?php do_action( 'kapee_head_bottom' ); ?>
	<?php wp_head(); ?>
</head>
<?php do_action( 'kapee_before_body' ); ?>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php do_action( 'kapee_body_top' ); ?>
	
	<div id="page" class="site-wrapper">
		
		<?php
		/**
		 * Hook: kapee_header.
		 *
		 * @hooked kapee_template_header- 10
		 */
		do_action( 'kapee_header' );
		?>
		
		<?php
		/**
		 * Hook: kapee_page_title.
		 *
		 * @hooked kapee_template_page_title - 10
		 */
		do_action( 'kapee_page_title' );
		?>			
		
		<div id="main-content" class="site-content">
		
			<?php do_action( 'kapee_site_content_top' ); ?>
			
			<div class="container">
				<div class="row <?php kapee_sidebar_reverse(); ?>">