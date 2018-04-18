<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
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
			<a href="impressum/#creativecommons"><img src="<?php echo esc_url( get_theme_file_uri() ); ?>/image/cc-icon-cc.svg" height="32px" width="32px" alt="Creative Commons"><img src="<?php echo esc_url( get_theme_file_uri() ); ?>/image/cc-icon-by.svg" height="32px" width="32px" alt="Namensnennung"><img src="<?php echo esc_url( get_theme_file_uri() ); ?>/image/cc-icon-sa.svg" height="32px" width="32px" alt="Weitergabe unter gleichen Bedingungen"></a><br /><br /><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> | created with &#9825; by <a href="https://eria.studio">eria.studio</a><br /><br /><small><a href="<?php echo esc_url( home_url( '/' ) ); ?>impressum/">Impressum</a> | <a href="<?php echo esc_url( home_url( '/' ) ); ?>datenschutz/">Datenschutzerklärung</a></small>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
