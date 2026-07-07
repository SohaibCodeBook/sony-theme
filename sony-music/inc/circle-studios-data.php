<?php
/**
 * Circle Studios page default content loader.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default Circle Studios page data from sonymusic.eu/company/circle-studios/.
 *
 * @return array<string, mixed>
 */
function sony_music_circle_studios_default_data() {
	static $data = null;

	if ( null !== $data ) {
		return $data;
	}

	$data   = array();
	$path   = SONY_MUSIC_DIR . '/inc/circle-studios-data.json';
	$raw    = is_readable( $path ) ? file_get_contents( $path ) : false;
	$parsed = is_string( $raw ) ? json_decode( $raw, true ) : null;

	if ( is_array( $parsed ) ) {
		$data = $parsed;
	}

	return $data;
}
