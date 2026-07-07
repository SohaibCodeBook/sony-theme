<?php
/**
 * Circle Studios page helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

require_once SONY_MUSIC_DIR . '/inc/circle-studios-data.php';

/**
 * Circle Studios page content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_circle_studios( $key, $default = '' ) {
	return get_theme_mod( 'sony_circle_studios_' . $key, $default );
}

/**
 * Default studio image URL.
 *
 * @return string
 */
function sony_music_default_circle_studios_image() {
	if ( file_exists( SONY_MUSIC_DIR . '/assets/images/circle-studios.jpg' ) ) {
		return SONY_MUSIC_URI . '/assets/images/circle-studios.jpg';
	}

	return 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2021/05/MicrosoftTeams-image-10-1024x683.jpg';
}

/**
 * Get Circle Studios page data.
 *
 * @return array<string, mixed>
 */
function sony_music_get_circle_studios_data() {
	$defaults = sony_music_circle_studios_default_data();

	return array(
		'page_title' => page_circle_studios( 'page_title', isset( $defaults['page_title'] ) ? $defaults['page_title'] : 'Circle Studios' ),
		'headline'   => page_circle_studios( 'headline', isset( $defaults['headline'] ) ? $defaults['headline'] : '' ),
		'body'       => page_circle_studios( 'body', isset( $defaults['body'] ) ? $defaults['body'] : '' ),
		'link_url'   => page_circle_studios( 'link_url', isset( $defaults['link_url'] ) ? $defaults['link_url'] : '' ),
		'link_label' => page_circle_studios( 'link_label', isset( $defaults['link_label'] ) ? $defaults['link_label'] : '' ),
		'image'      => page_circle_studios( 'image', sony_music_default_circle_studios_image() ),
		'image_alt'  => page_circle_studios( 'image_alt', isset( $defaults['image_alt'] ) ? $defaults['image_alt'] : 'Circles Studios Berlin interior' ),
	);
}

/**
 * Render Circle Studios page.
 */
function sony_music_render_circle_studios_page() {
	get_template_part( 'template-parts/circle-studios/content', null, sony_music_get_circle_studios_data() );
}

/**
 * Register Circle Studios customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_circle_studios_customize_register( $wp_customize ) {
	$defaults = sony_music_circle_studios_default_data();

	$wp_customize->add_section(
		'sony_music_circle_studios',
		array(
			'title'    => __( 'Circle Studios Page', 'sony-music' ),
			'priority' => 59,
		)
	);

	$fields = array(
		'page_title' => array( isset( $defaults['page_title'] ) ? $defaults['page_title'] : 'Circle Studios', 'text' ),
		'headline'   => array( isset( $defaults['headline'] ) ? $defaults['headline'] : '', 'text' ),
		'body'       => array( isset( $defaults['body'] ) ? $defaults['body'] : '', 'textarea' ),
		'link_url'   => array( isset( $defaults['link_url'] ) ? $defaults['link_url'] : '', 'url' ),
		'link_label' => array( isset( $defaults['link_label'] ) ? $defaults['link_label'] : '', 'text' ),
		'image'      => array( sony_music_default_circle_studios_image(), 'url' ),
		'image_alt'  => array( isset( $defaults['image_alt'] ) ? $defaults['image_alt'] : '', 'text' ),
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
			"sony_circle_studios_{$key}",
			array(
				'default'           => $config[0],
				'sanitize_callback' => $sanitize,
			)
		);
		$wp_customize->add_control(
			"sony_circle_studios_{$key}",
			array(
				'label'   => ucwords( str_replace( '_', ' ', $key ) ),
				'section' => 'sony_music_circle_studios',
				'type'    => $config[1],
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_circle_studios_customize_register', 20 );
