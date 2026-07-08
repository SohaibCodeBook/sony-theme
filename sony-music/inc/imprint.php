<?php
/**
 * Imprint page helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

require_once SONY_MUSIC_DIR . '/inc/imprint-data.php';

/**
 * Imprint page content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_imprint( $key, $default = '' ) {
	return get_theme_mod( 'sony_imprint_' . $key, $default );
}

/**
 * Get Imprint page data for the template.
 *
 * @return array<string, mixed>
 */
function sony_music_get_imprint_data() {
	$defaults = sony_music_imprint_default_data();

	return array(
		'page_title'       => page_imprint( 'page_title', isset( $defaults['page_title'] ) ? $defaults['page_title'] : 'Imprint' ),
		'intro'            => page_imprint( 'intro', isset( $defaults['intro'] ) ? $defaults['intro'] : '' ),
		'company_meta'     => page_imprint( 'company_meta', isset( $defaults['company_meta'] ) ? $defaults['company_meta'] : '' ),
		'contact_note'     => page_imprint( 'contact_note', isset( $defaults['contact_note'] ) ? $defaults['contact_note'] : '' ),
		'copyright'        => page_imprint( 'copyright', isset( $defaults['copyright'] ) ? $defaults['copyright'] : '' ),
		'consent'          => page_imprint( 'consent', isset( $defaults['consent'] ) ? $defaults['consent'] : '' ),
		'copyright_notice' => page_imprint( 'copyright_notice', isset( $defaults['copyright_notice'] ) ? $defaults['copyright_notice'] : '' ),
		'sections'         => isset( $defaults['sections'] ) && is_array( $defaults['sections'] ) ? $defaults['sections'] : array(),
	);
}

/**
 * Render Imprint page.
 */
function sony_music_render_imprint_page() {
	get_template_part( 'template-parts/imprint/content', null, sony_music_get_imprint_data() );
}

/**
 * Register Imprint customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_imprint_customize_register( $wp_customize ) {
	$defaults = sony_music_imprint_default_data();

	$wp_customize->add_section(
		'sony_music_imprint',
		array(
			'title'    => __( 'Imprint Page', 'sony-music' ),
			'priority' => 75,
		)
	);

	$fields = array(
		'page_title'       => array( isset( $defaults['page_title'] ) ? $defaults['page_title'] : 'Imprint', 'text' ),
		'intro'            => array( isset( $defaults['intro'] ) ? $defaults['intro'] : '', 'textarea' ),
		'company_meta'     => array( isset( $defaults['company_meta'] ) ? $defaults['company_meta'] : '', 'textarea' ),
		'contact_note'     => array( isset( $defaults['contact_note'] ) ? $defaults['contact_note'] : '', 'textarea' ),
		'copyright'        => array( isset( $defaults['copyright'] ) ? $defaults['copyright'] : '', 'text' ),
		'consent'          => array( isset( $defaults['consent'] ) ? $defaults['consent'] : '', 'textarea' ),
		'copyright_notice' => array( isset( $defaults['copyright_notice'] ) ? $defaults['copyright_notice'] : '', 'textarea' ),
	);

	foreach ( $fields as $key => $config ) {
		$sanitize = 'textarea' === $config[1] ? 'wp_kses_post' : 'sanitize_text_field';

		$wp_customize->add_setting(
			"sony_imprint_{$key}",
			array(
				'default'           => $config[0],
				'sanitize_callback' => $sanitize,
			)
		);
		$wp_customize->add_control(
			"sony_imprint_{$key}",
			array(
				'label'   => ucwords( str_replace( '_', ' ', $key ) ),
				'section' => 'sony_music_imprint',
				'type'    => $config[1],
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_imprint_customize_register', 20 );
