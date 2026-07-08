<?php
/**
 * Artists page helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

require_once SONY_MUSIC_DIR . '/inc/artists-data.php';

/**
 * Artists page content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_artists( $key, $default = '' ) {
	return get_theme_mod( 'sony_artists_' . $key, $default );
}

/**
 * Get Artists page data for the template.
 *
 * @return array<string, mixed>
 */
function sony_music_get_artists_data() {
	$defaults = sony_music_artists_default_data();

	return array(
		'page_title'         => page_artists( 'page_title', isset( $defaults['page_title'] ) ? $defaults['page_title'] : 'Artists' ),
		'filter_label'       => page_artists( 'filter_label', isset( $defaults['filter_label'] ) ? $defaults['filter_label'] : 'Filter' ),
		'search_placeholder' => page_artists( 'search_placeholder', isset( $defaults['search_placeholder'] ) ? $defaults['search_placeholder'] : 'Search' ),
		'load_more_label'    => page_artists( 'load_more_label', isset( $defaults['load_more_label'] ) ? $defaults['load_more_label'] : 'mehr laden' ),
		'per_page'           => isset( $defaults['per_page'] ) ? (int) $defaults['per_page'] : 30,
		'labels'             => isset( $defaults['labels'] ) ? $defaults['labels'] : array(),
		'artists'            => isset( $defaults['artists'] ) && is_array( $defaults['artists'] ) ? $defaults['artists'] : array(),
	);
}

/**
 * Render Artists page.
 */
function sony_music_render_artists_page() {
	get_template_part( 'template-parts/artists/content', null, sony_music_get_artists_data() );
}

/**
 * Register Artists customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_artists_customize_register( $wp_customize ) {
	$defaults = sony_music_artists_default_data();

	$wp_customize->add_section(
		'sony_music_artists',
		array(
			'title'    => __( 'Artists Page', 'sony-music' ),
			'priority' => 46,
		)
	);

	$fields = array(
		'page_title'         => array( isset( $defaults['page_title'] ) ? $defaults['page_title'] : 'Artists', 'text' ),
		'filter_label'       => array( isset( $defaults['filter_label'] ) ? $defaults['filter_label'] : 'Filter', 'text' ),
		'search_placeholder' => array( isset( $defaults['search_placeholder'] ) ? $defaults['search_placeholder'] : 'Search', 'text' ),
		'load_more_label'    => array( isset( $defaults['load_more_label'] ) ? $defaults['load_more_label'] : 'mehr laden', 'text' ),
	);

	foreach ( $fields as $key => $config ) {
		$wp_customize->add_setting(
			"sony_artists_{$key}",
			array(
				'default'           => $config[0],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_artists_{$key}",
			array(
				'label'   => ucwords( str_replace( '_', ' ', $key ) ),
				'section' => 'sony_music_artists',
				'type'    => $config[1],
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_artists_customize_register', 20 );
