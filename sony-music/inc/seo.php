<?php
/**
 * Basic SEO meta output.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output basic meta description when no SEO plugin is active.
 */
function sony_music_meta_description() {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) {
		return;
	}

	$description = '';

	if ( is_singular() ) {
		$description = get_the_excerpt();
	} elseif ( is_front_page() ) {
		$description = get_bloginfo( 'description' );
	}

	if ( $description ) {
		printf(
			'<meta name="description" content="%s" />' . "\n",
			esc_attr( wp_strip_all_tags( $description ) )
		);
	}
}
add_action( 'wp_head', 'sony_music_meta_description', 1 );
