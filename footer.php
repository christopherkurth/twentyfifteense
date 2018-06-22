<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen SE 1.1.0
 */
?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php
				/**
				 * Fires before the Twenty Fifteen footer text for footer customization.
				 *
				 * @since Twenty Fifteen 1.0
				 */
				do_action( 'twentyfifteen_credits' );
			?>

			&copy; <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> 

			<?php if ( has_nav_menu( 'footer' ) ) : ?>

				<nav class="footer-navigation container" aria-label="<?php esc_attr_e( 'Footer Menu', 'twentyfifteen' ); ?>">

					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_class'     => 'footer-menu',
							'depth'          => '1',
						)
					);
					?>

				</nav>
			<?php endif; ?>

		</div><!-- .site-info -->
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
