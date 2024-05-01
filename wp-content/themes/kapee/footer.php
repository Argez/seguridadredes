<?php
/**
 * The template for displaying the footer
 *
 * @author 	PressLayouts
 * @package kapee
 * @since 1.0.0
 */
?>
				</div><!-- .row -->		
			</div><!-- .container -->
			
			<?php do_action( 'kapee_site_content_botton' ); ?>
			
		</div><!-- .site-content -->
		
		<?php
		/**
		 * Hook: kapee_footer.
		 *
		 * @hooked kapee_template_footer- 10
		 */
		do_action( 'kapee_footer' );
		?>
		
	</div><!-- .site-wrapper -->
	
	<?php do_action( 'kapee_body_bottom' ); ?>
	<?php wp_footer(); ?>
	</body>
</html>