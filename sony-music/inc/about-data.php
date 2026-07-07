<?php
/**
 * About page default content loader.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default About page data from sonymusic.eu/company/about/.
 *
 * @return array<string, mixed>
 */
function sony_music_about_default_data() {
	static $data = null;

	if ( null !== $data ) {
		return $data;
	}

	$data   = array();
	$path   = SONY_MUSIC_DIR . '/inc/about-data.json';
	$raw    = is_readable( $path ) ? file_get_contents( $path ) : false;
	$parsed = is_string( $raw ) ? json_decode( $raw, true ) : null;

	if ( is_array( $parsed ) ) {
		$data = $parsed;
	}

	return $data;
}
