<?php
/**
 * Theme Customizer settings and helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_customize_register( $wp_customize ) {
	// Header section.
	$wp_customize->add_section(
		'sony_music_header',
		array(
			'title'    => __( 'Header', 'sony-music' ),
			'priority' => 20,
		)
	);

	$wp_customize->add_setting(
		'sony_show_topbar',
		array(
			'default'           => true,
			'sanitize_callback' => 'sony_music_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'sony_show_topbar',
		array(
			'label'   => __( 'Show Sony corporate top bar', 'sony-music' ),
			'section' => 'sony_music_header',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'sony_topbar_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'sony_topbar_logo',
			array(
				'label'       => __( 'Sony corporate logo (top bar)', 'sony-music' ),
				'description' => __( 'Leave empty to use default SONY wordmark text.', 'sony-music' ),
				'section'     => 'sony_music_header',
			)
		)
	);

	$wp_customize->add_setting(
		'sony_topbar_url',
		array(
			'default'           => 'https://www.sony.com',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'sony_topbar_url',
		array(
			'label'   => __( 'Sony corporate logo link', 'sony-music' ),
			'section' => 'sony_music_header',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'sony_main_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'sony_main_logo',
			array(
				'label'       => __( 'Sony Music logo (main header)', 'sony-music' ),
				'description' => __( 'Leave empty to use bundled SVG logo.', 'sony-music' ),
				'section'     => 'sony_music_header',
			)
		)
	);

	$wp_customize->add_setting(
		'sony_search_placeholder',
		array(
			'default'           => 'Search',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_search_placeholder',
		array(
			'label'   => __( 'Search placeholder text', 'sony-music' ),
			'section' => 'sony_music_header',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sony_lang_label',
		array(
			'default'           => 'EN',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_lang_label',
		array(
			'label'   => __( 'Language label (visible)', 'sony-music' ),
			'section' => 'sony_music_header',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sony_lang_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'sony_lang_url',
		array(
			'label'   => __( 'Language link URL', 'sony-music' ),
			'section' => 'sony_music_header',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'sony_lang_alt_label',
		array(
			'default'           => 'DE',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_lang_alt_label',
		array(
			'label'   => __( 'Alternate language label', 'sony-music' ),
			'section' => 'sony_music_header',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sony_lang_alt_url',
		array(
			'default'           => 'https://www.sonymusic.de',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'sony_lang_alt_url',
		array(
			'label'   => __( 'Alternate language URL', 'sony-music' ),
			'section' => 'sony_music_header',
			'type'    => 'url',
		)
	);

	// Offcanvas footer links section.
	$wp_customize->add_section(
		'sony_music_offcanvas',
		array(
			'title'    => __( 'Offcanvas Menu Footer Links', 'sony-music' ),
			'priority' => 25,
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		$defaults = array(
			1 => array( 'Contact', home_url( '/contact/' ) ),
			2 => array( 'Instagram', 'https://www.instagram.com/sonymusicde' ),
			3 => array( 'AI Usage Terms', home_url( '/ai-usage-terms/' ) ),
		);

		$wp_customize->add_setting(
			"sony_footer_link_{$i}_label",
			array(
				'default'           => $defaults[ $i ][0],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_footer_link_{$i}_label",
			array(
				'label'   => sprintf( __( 'Footer link %d label', 'sony-music' ), $i ),
				'section' => 'sony_music_offcanvas',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_footer_link_{$i}_url",
			array(
				'default'           => $defaults[ $i ][1],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"sony_footer_link_{$i}_url",
			array(
				'label'   => sprintf( __( 'Footer link %d URL', 'sony-music' ), $i ),
				'section' => 'sony_music_offcanvas',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_customize_register' );

/**
 * Sanitize checkbox.
 *
 * @param mixed $value Input value.
 * @return bool
 */
function sony_music_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Global site data helper.
 *
 * @param string $key Setting key without prefix.
 * @return mixed
 */
function site_data( $key ) {
	$map = array(
		'show_topbar'         => 'sony_show_topbar',
		'topbar_logo'         => 'sony_topbar_logo',
		'topbar_url'          => 'sony_topbar_url',
		'main_logo'           => 'sony_main_logo',
		'search_placeholder'  => 'sony_search_placeholder',
		'lang_label'          => 'sony_lang_label',
		'lang_url'            => 'sony_lang_url',
		'lang_alt_label'      => 'sony_lang_alt_label',
		'lang_alt_url'        => 'sony_lang_alt_url',
		'footer_link_1_label' => 'sony_footer_link_1_label',
		'footer_link_1_url'   => 'sony_footer_link_1_url',
		'footer_link_2_label' => 'sony_footer_link_2_label',
		'footer_link_2_url'   => 'sony_footer_link_2_url',
		'footer_link_3_label' => 'sony_footer_link_3_label',
		'footer_link_3_url'   => 'sony_footer_link_3_url',
	);

	if ( ! isset( $map[ $key ] ) ) {
		return '';
	}

	$value = get_theme_mod( $map[ $key ], '' );

	if ( 'show_topbar' === $key ) {
		return (bool) get_theme_mod( $map[ $key ], true );
	}

	return $value;
}
