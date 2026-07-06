<?php
/**
 * 404 template.
 *
 * @package Sony_Music
 */

get_header();
?>

<main id="main" class="container py-5">
	<h1 class="h2"><?php esc_html_e( 'Page not found', 'sony-music' ); ?></h1>
	<p><?php esc_html_e( 'The page you are looking for does not exist.', 'sony-music' ); ?></p>
	<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'sony-music' ); ?></a></p>
</main>

<?php
get_footer();
