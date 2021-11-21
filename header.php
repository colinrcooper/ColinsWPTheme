<?php
/**
 * The template for displaying the header.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php koromo_body_schema();?> <?php body_class(); ?>>
	<?php
	/**
	 * koromo_before_header hook.
	 *
	 *
	 * @hooked koromo_do_skip_to_content_link - 2
	 * @hooked koromo_top_bar - 5
	 * @hooked koromo_add_navigation_before_header - 5
	 */
	do_action( 'koromo_before_header' );

	/**
	 * koromo_header hook.
	 *
	 *
	 * @hooked koromo_construct_header - 10
	 */
	do_action( 'koromo_header' );

	/**
	 * koromo_after_header hook.
	 *
	 *
	 * @hooked koromo_featured_page_header - 10
	 */
	do_action( 'koromo_after_header' );
	?>
    <div class="" ></div>
	<div id="page" class="hfeed site grid-container container grid-parent">
		<div id="content" class="site-content">
			<?php
			/**
			 * koromo_inside_container hook.
			 *
			 */
			do_action( 'koromo_inside_container' );
