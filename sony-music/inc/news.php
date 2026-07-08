<?php
/**
 * News page helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

require_once SONY_MUSIC_DIR . '/inc/news-data.php';

/**
 * News page content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_news( $key, $default = '' ) {
	return get_theme_mod( 'sony_news_' . $key, $default );
}

/**
 * Resolve a news image path to a full URL.
 *
 * @param string $image Relative theme path or absolute URL.
 * @return string
 */
function sony_music_news_image_url( $image ) {
	if ( ! $image ) {
		return '';
	}

	if ( 0 === strpos( $image, 'http://' ) || 0 === strpos( $image, 'https://' ) ) {
		return $image;
	}

	$relative = ltrim( $image, '/' );
	if ( file_exists( SONY_MUSIC_DIR . '/' . $relative ) ) {
		return SONY_MUSIC_URI . '/' . $relative;
	}

	return $image;
}

/**
 * Get News page data for the template.
 *
 * @return array<string, mixed>
 */
function sony_music_get_news_data() {
	$defaults = sony_music_news_default_data();
	$posts    = isset( $defaults['posts'] ) && is_array( $defaults['posts'] ) ? $defaults['posts'] : array();

	foreach ( $posts as &$post ) {
		if ( isset( $post['image'] ) ) {
			$post['image'] = sony_music_news_image_url( $post['image'] );
		}
	}
	unset( $post );

	return array(
		'page_title'         => page_news( 'page_title', isset( $defaults['page_title'] ) ? $defaults['page_title'] : 'News' ),
		'filter_label'       => page_news( 'filter_label', isset( $defaults['filter_label'] ) ? $defaults['filter_label'] : 'Filter' ),
		'search_placeholder' => page_news( 'search_placeholder', isset( $defaults['search_placeholder'] ) ? $defaults['search_placeholder'] : 'Search' ),
		'load_more_label'    => page_news( 'load_more_label', isset( $defaults['load_more_label'] ) ? $defaults['load_more_label'] : 'mehr laden' ),
		'per_page'           => isset( $defaults['per_page'] ) ? (int) $defaults['per_page'] : 12,
		'categories'         => isset( $defaults['categories'] ) ? $defaults['categories'] : array(),
		'posts'              => $posts,
	);
}

/**
 * Render News page.
 */
function sony_music_render_news_page() {
	get_template_part( 'template-parts/news/content', null, sony_music_get_news_data() );
}

/**
 * Register News customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_news_customize_register( $wp_customize ) {
	$defaults = sony_music_news_default_data();

	$wp_customize->add_section(
		'sony_music_news',
		array(
			'title'    => __( 'News Page', 'sony-music' ),
			'priority' => 45,
		)
	);

	$fields = array(
		'page_title'         => array( isset( $defaults['page_title'] ) ? $defaults['page_title'] : 'News', 'text' ),
		'filter_label'       => array( isset( $defaults['filter_label'] ) ? $defaults['filter_label'] : 'Filter', 'text' ),
		'search_placeholder' => array( isset( $defaults['search_placeholder'] ) ? $defaults['search_placeholder'] : 'Search', 'text' ),
		'load_more_label'    => array( isset( $defaults['load_more_label'] ) ? $defaults['load_more_label'] : 'mehr laden', 'text' ),
	);

	foreach ( $fields as $key => $config ) {
		$wp_customize->add_setting(
			"sony_news_{$key}",
			array(
				'default'           => $config[0],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_news_{$key}",
			array(
				'label'   => ucwords( str_replace( '_', ' ', $key ) ),
				'section' => 'sony_music_news',
				'type'    => $config[1],
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_news_customize_register', 20 );
