<?php
/**
 * Template part for displaying header style 1
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 	PressLayouts
 * @package kapee/template-parts/header
 * @since 1.0
 * @version 1.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}?>

<?php if ( $header_top ) : ?>
	<div class="header-topbar">
		<div class="container">
			<div class="row">
				<div class="header-col header-col-left col-lg-6 col-xl-6 d-none d-lg-flex d-xl-flex">
					<?php kapee_get_template( 'template-parts/header/elements/language-switcher' );?>
					<?php kapee_get_template( 'template-parts/header/elements/currency-switcher' );?>
				</div>
				<div class="header-col header-col-right col-lg-6 col-xl-6 d-none d-lg-flex d-xl-flex">				
					<?php kapee_get_template( 'template-parts/header/elements/welcome-message' );?>
					<?php kapee_get_template( 'template-parts/header/elements/topbar-menu' );?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<div class="header-main">
	<div class="container">
		<div class="row">
			<div class="header-col header-col-left col-lg-5 col-xl-5 d-none d-lg-flex d-xl-flex">
				<?php kapee_get_template( 'template-parts/header/elements/customer-support' );?>
			</div>
			<div class="header-col header-col-center col-lg-2 col-xl-2 d-none d-lg-flex d-xl-flex justify-content-center">
				<?php kapee_get_template( 'template-parts/header/elements/logo', array( 'header_logo' => 'header' ) );?>
			</div>
			<div class="header-col header-col-right col-lg-5 col-xl-5 d-none d-lg-flex d-xl-flex">
				<?php kapee_get_template( 'template-parts/header/elements/myaccount' );?>
				<?php kapee_get_template( 'template-parts/header/elements/wishlist' );?>
				<?php kapee_get_template( 'template-parts/header/elements/cart' );?>
			</div>
			
			<!-- Mobile-->
			<div class="header-col header-col-left col-6 d-flex d-lg-none d-xl-none">
				<?php kapee_get_template( 'template-parts/header/elements/mobile-navbar' );?>
				<?php kapee_get_template( 'template-parts/header/elements/logo', array( 'header_logo' => 'mobile' ) );?>
			</div>
			<div class="header-col header-col-right col-6 d-flex d-lg-none d-xl-none">
				<?php kapee_get_template( 'template-parts/header/elements/myaccount' );?>
				<?php kapee_get_template( 'template-parts/header/elements/wishlist' );?>
				<?php kapee_get_template( 'template-parts/header/elements/cart' );?>
			</div>
			
		</div>
	</div>
</div>
<div class="header-navigation">
	<div class="container">
		<div class="row">
			<div class="header-col header-col-center col-lg-12 col-xl-12 d-none d-lg-flex d-xl-flex justify-content-center ">
				<?php kapee_get_template( 'template-parts/header/elements/primary-menu' );?>
			</div>
				
			<!-- Mobile-->
			<div class="header-col header-col-center col-12 d-flex d-lg-none d-xl-none">
				<?php kapee_get_template( 'template-parts/header/elements/ajax-search' );?>
			</div>
		</div>
	</div>
</div>
<?php if ( $sticky_header || $sticky_header_table || $sticky_header_mobile ) : ?>
	<div class="header-sticky">
		<div class="container">
			<div class="row">
				<?php if ( $sticky_header ) : ?>
					<div class="header-col header-col-left col-lg-2 col-xl-2 d-none d-lg-flex d-xl-flex">
						<?php kapee_get_template( 'template-parts/header/elements/logo', array( 'header_logo' => 'sticky' ) ); ?>
					</div>
					<div class="header-col header-col-center col-lg-7 col-xl-7 d-none d-lg-flex d-xl-flex">
						<?php kapee_get_template( 'template-parts/header/elements/primary-menu' ); ?>
					</div>
					<div class="header-col header-col-right col-lg-3 col-xl-3 d-none d-lg-flex d-xl-flex">
						<?php kapee_get_template( 'template-parts/header/elements/myaccount' );?>
						<?php kapee_get_template( 'template-parts/header/elements/wishlist' );?>
						<?php kapee_get_template( 'template-parts/header/elements/cart' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( $sticky_header_table || $sticky_header_mobile ) : ?>
					<!-- Mobile -->
					<div class="header-col header-col-left col-2 d-flex d-lg-none d-xl-none">
						<?php kapee_get_template( 'template-parts/header/elements/mobile-navbar' );?>
					</div>
					<div class="header-col header-col-center col-8 d-flex d-lg-none d-xl-none">
						<?php kapee_get_template( 'template-parts/header/elements/ajax-search' );?>
					</div>
					<div class="header-col header-col-right col-2 d-flex d-lg-none d-xl-none">
						<?php kapee_get_template( 'template-parts/header/elements/cart' );?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>