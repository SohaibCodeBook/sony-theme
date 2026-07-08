<?php
/**
 * News page default content loader.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default News page data from sonymusic.eu/news/.
 *
 * @return array<string, mixed>
 */
function sony_music_news_default_data() {
	static $data = null;

	if ( null !== $data ) {
		return $data;
	}

	$data   = array();
	$path   = SONY_MUSIC_DIR . '/inc/news-data.json';
	$raw    = is_readable( $path ) ? file_get_contents( $path ) : false;
	$parsed = is_string( $raw ) ? json_decode( $raw, true ) : null;

	if ( is_array( $parsed ) ) {
		$data = $parsed;
	}

	return $data;
}
