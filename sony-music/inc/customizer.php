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
 * Register homepage hero customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_home_hero_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'sony_music_home_hero',
		array(
			'title'    => __( 'Homepage Hero News Slider', 'sony-music' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'sony_home_hero_autoplay',
		array(
			'default'           => 4000,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'sony_home_hero_autoplay',
		array(
			'label'       => __( 'Autoplay interval (ms)', 'sony-music' ),
			'description' => __( 'Reference site uses 4000.', 'sony-music' ),
			'section'     => 'sony_music_home_hero',
			'type'        => 'number',
		)
	);

	$wp_customize->add_setting(
		'sony_home_hero_speed',
		array(
			'default'           => 1500,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'sony_home_hero_speed',
		array(
			'label'   => __( 'Transition speed (ms)', 'sony-music' ),
			'section' => 'sony_music_home_hero',
			'type'    => 'number',
		)
	);

	$defaults = sony_music_default_hero_slides();

	for ( $i = 1; $i <= 12; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'title'    => '',
			'url'      => '',
			'category' => 'Company',
			'image'    => '',
		);

		$wp_customize->add_setting(
			"sony_home_hero_slide_{$i}_title",
			array(
				'default'           => $default['title'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_home_hero_slide_{$i}_title",
			array(
				'label'   => sprintf( __( 'Slide %d — Title', 'sony-music' ), $i ),
				'section' => 'sony_music_home_hero',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_home_hero_slide_{$i}_url",
			array(
				'default'           => $default['url'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"sony_home_hero_slide_{$i}_url",
			array(
				'label'   => sprintf( __( 'Slide %d — Link URL', 'sony-music' ), $i ),
				'section' => 'sony_music_home_hero',
				'type'    => 'url',
			)
		);

		$wp_customize->add_setting(
			"sony_home_hero_slide_{$i}_category",
			array(
				'default'           => $default['category'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_home_hero_slide_{$i}_category",
			array(
				'label'   => sprintf( __( 'Slide %d — Category', 'sony-music' ), $i ),
				'section' => 'sony_music_home_hero',
				'type'    => 'select',
				'choices' => array(
					'Company' => 'Company',
					'Artist'  => 'Artist',
					'Other'   => 'Other',
					'Label'   => 'Label',
				),
			)
		);

		$wp_customize->add_setting(
			"sony_home_hero_slide_{$i}_image",
			array(
				'default'           => $default['image'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"sony_home_hero_slide_{$i}_image",
				array(
					'label'   => sprintf( __( 'Slide %d — Background image', 'sony-music' ), $i ),
					'section' => 'sony_music_home_hero',
				)
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_home_hero_customize_register', 20 );

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
