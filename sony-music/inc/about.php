<?php
/**
 * About page helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

require_once SONY_MUSIC_DIR . '/inc/about-data.php';

/**
 * About page content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_about( $key, $default = '' ) {
	return get_theme_mod( 'sony_about_' . $key, $default );
}

/**
 * Get About page data.
 *
 * @return array<string, mixed>
 */
function sony_music_get_about_data() {
	$defaults = sony_music_about_default_data();

	return array(
		'page_title'   => page_about( 'page_title', 'About' ),
		'headline'     => page_about( 'headline', $defaults['headline'] ),
		'intro'        => page_about( 'intro', $defaults['intro'] ),
		'ceo_image'    => page_about( 'ceo_image', $defaults['ceo_image'] ),
		'ceo_alt'      => page_about( 'ceo_alt', $defaults['ceo_alt'] ),
		'ceo_text'     => page_about( 'ceo_text', $defaults['ceo_text'] ),
		'facade_image' => page_about( 'facade_image', $defaults['facade_image'] ),
		'facade_alt'   => page_about( 'facade_alt', $defaults['facade_alt'] ),
		'sections'     => $defaults['sections'],
	);
}

/**
 * Render About page.
 */
function sony_music_render_about_page() {
	get_template_part( 'template-parts/about/content', null, sony_music_get_about_data() );
}

/**
 * Register About customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_about_customize_register( $wp_customize ) {
	$defaults = sony_music_about_default_data();

	$wp_customize->add_section(
		'sony_music_about',
		array(
			'title'    => __( 'About Page', 'sony-music' ),
			'priority' => 57,
		)
	);

	$fields = array(
		'page_title'   => array( 'About', 'text' ),
		'headline'     => array( $defaults['headline'], 'text' ),
		'intro'        => array( $defaults['intro'], 'textarea' ),
		'ceo_image'    => array( $defaults['ceo_image'], 'url' ),
		'ceo_alt'      => array( $defaults['ceo_alt'], 'text' ),
		'ceo_text'     => array( $defaults['ceo_text'], 'textarea' ),
		'facade_image' => array( $defaults['facade_image'], 'url' ),
		'facade_alt'   => array( $defaults['facade_alt'], 'text' ),
	);

	foreach ( $fields as $key => $config ) {
		if ( 'textarea' === $config[1] ) {
			$sanitize = 'wp_kses_post';
		} elseif ( 'url' === $config[1] ) {
			$sanitize = 'esc_url_raw';
		} else {
			$sanitize = 'sanitize_text_field';
		}

		$wp_customize->add_setting(
			"sony_about_{$key}",
			array(
				'default'           => $config[0],
				'sanitize_callback' => $sanitize,
			)
		);
		$wp_customize->add_control(
			"sony_about_{$key}",
			array(
				'label'   => ucwords( str_replace( '_', ' ', $key ) ),
				'section' => 'sony_music_about',
				'type'    => $config[1],
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_about_customize_register', 20 );
