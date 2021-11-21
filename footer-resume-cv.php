<?php
/**
 * The template for displaying the footer.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

	</div><!-- #content -->
</div><!-- #page -->

<?php
/**
 * koromo_before_footer hook.
 *
 */
do_action( 'koromo_before_footer' );
?>

<div <?php koromo_footer_class(); ?>>
	<?php
	/**
	 * koromo_before_footer_content hook.
	 *
	 */
	do_action( 'koromo_before_footer_content' );

	/**
	 * koromo_footer hook.
	 *
	 *
	 * @hooked koromo_construct_footer_widgets - 5
	 * @hooked koromo_construct_footer - 10
	 */
	//do_action( 'koromo_footer' );

	/**
	 * koromo_after_footer_content hook.
	 *
	 */
	do_action( 'koromo_after_footer_content' );
	?>
</div><!-- .site-footer -->

<?php
/**
 * koromo_after_footer hook.
 *
 */
do_action( 'koromo_after_footer' );

wp_footer();
?>

</body>
</html>
