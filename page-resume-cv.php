<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header( 'resume-cv' ); ?>

	<div id="primary" <?php koromo_content_class();?>>

		<main id="main" <?php koromo_main_class(); ?>>
			<?php
			/**
			 * koromo_before_main_content hook.
			 *
			 */
			do_action( 'koromo_before_main_content' );

			while ( have_posts() ) : the_post();

				get_template_part( 'content', 'page' );

			endwhile;
			?>


            <?php if ( isset( $_POST["cv_key_val"] ) ):
                $posted_cv_key = strtoupper(preg_replace("/[^a-zA-Z0-9]+/", "", $_POST["cv_key_val"]));
				$posted_email = filter_var($_POST["cv_email_val"], FILTER_VALIDATE_EMAIL);
				if ( $posted_email ){
                	$key_status = check_cv_key_status( $posted_cv_key, $posted_email );
				}
				else {
					$key_status = INVALID_KEY;
					echo "Please use a valid email address. <a href='/resume-cv/'>Retry</a>.";
					exit;
				}
                
                $nonce = $_POST['_wpnonce'];

                if ( ! wp_verify_nonce( $nonce, 'check_cv_key' ) ) {
                    die( __( 'Security check', 'textdomain' ) );
                }
                
                if ( $key_status == VALID_KEY ):
                    show_post('my-cv');
                elseif ( $key_status == EXPIRED_KEY || $key_status == INVALID_KEY):
                    echo "Sorry, that's either an unrecognised email address or an invalid / expired key. <a href='/resume-cv/'>Retry</a>.";
                else:
                    echo "An unknown error has occured. <a href='/resume-cv/'>Retry</a>.";
                endif;

            else: ?>
			<p>Thank you for your interest. To protect my privacy, you need a key to access my resumé. If I’ve given you a key already, please type it into the textbox below and click Go. If you’d like to request a key, please <a href="/contact-me/"><b>contact me</b></a> with some details and I’ll be in touch as soon as I can.</p>
            <form method="post">
				<input type="email" placeholder="Your email address" name="cv_email_val"> 
			    <input type="text" placeholder="Your key" pattern="[a-zA-Z0-9]+" name="cv_key_val">
			    <?php wp_nonce_field( 'check_cv_key' ); ?>
			    <input type="submit" value="SUBMIT">
			</form>

            <?php endif ?>




            <?php
			/**
			 * koromo_after_main_content hook.
			 *
			 */
			do_action( 'koromo_after_main_content' );
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php
	/**
	 * koromo_after_primary_content_area hook.
	 *
	 */
	 do_action( 'koromo_after_primary_content_area' );

	 koromo_construct_sidebars();

get_footer( 'resume-cv' );
