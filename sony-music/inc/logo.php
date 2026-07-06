<?php
/**
 * Logo output helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output Sony Music main logo markup.
 *
 * @param string $class Optional wrapper class.
 */
function sony_music_logo( $class = 'site-logo' ) {
	$custom_logo = site_data( 'main_logo' );
	$home_url    = home_url( '/' );
	$label       = get_bloginfo( 'name' );

	printf( '<div class="%s">', esc_attr( $class ) );
	printf( '<a href="%s" aria-label="%s">', esc_url( $home_url ), esc_attr( $label ) );

	if ( $custom_logo ) {
		printf(
			'<img src="%s" alt="%s" width="204" height="46" />',
			esc_url( $custom_logo ),
			esc_attr( $label )
		);
	} else {
		$svg_path = SONY_MUSIC_DIR . '/assets/images/sony-music-logo.svg';
		if ( file_exists( $svg_path ) ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Trusted theme SVG asset.
			echo file_get_contents( $svg_path );
		}
	}

	echo '</a></div>';
}

/**
 * Output Sony corporate top bar logo.
 */
function sony_music_topbar_logo() {
	$url       = site_data( 'topbar_url' ) ?: 'https://www.sony.com';
	$logo_img  = site_data( 'topbar_logo' );

	printf( '<a href="%s" target="_blank" rel="noopener noreferrer">', esc_url( $url ) );

	if ( $logo_img ) {
		printf(
			'<img src="%s" alt="SONY" width="auto" height="12" />',
			esc_url( $logo_img )
		);
	} else {
		echo '<span class="sony-wordmark-text">SONY</span>';
	}

	echo '</a>';
}
