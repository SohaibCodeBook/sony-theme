<?php
/**
 * Homepage Welcome section helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default Welcome gallery images from sonymusic.eu.
 *
 * @return array<int, string>
 */
function sony_music_default_welcome_gallery() {
	return array(
		'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2021/05/01-Aussen07005_6532-Bearbeitet-683x1024.jpg',
		'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2021/05/10-Konfi-Kumpelnest_DSC2231-1024x683.jpg',
		'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2021/05/03-Cafeteria_DSC7934-683x1024.jpg',
		'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2021/05/12-Tonstudio10455_9807-1024x683.jpg',
		'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2021/05/12-TonstudioIMG_9783_jn-1024x768.jpg',
	);
}

/**
 * Default Welcome CTA links.
 *
 * @return array<int, array{label:string,url:string}>
 */
function sony_music_default_welcome_links() {
	return array(
		array(
			'label' => 'FAQ',
			'url'   => '#',
		),
		array(
			'label' => 'News',
			'url'   => '#',
		),
		array(
			'label' => 'Careers',
			'url'   => '/company/career/',
		),
	);
}

/**
 * Get configured Welcome gallery images.
 *
 * @return array<int, string>
 */
function sony_music_get_welcome_gallery() {
	$defaults = sony_music_default_welcome_gallery();
	$images   = array();

	for ( $i = 1; $i <= 5; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : '';
		$image   = page_home( "welcome_gallery_{$i}", $default );

		if ( $image ) {
			$images[] = $image;
		}
	}

	return $images;
}

/**
 * Get configured Welcome CTA links.
 *
 * @return array<int, array{label:string,url:string}>
 */
function sony_music_get_welcome_links() {
	$defaults = sony_music_default_welcome_links();
	$links    = array();

	for ( $i = 1; $i <= 3; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'label' => '',
			'url'   => '#',
		);

		$label = page_home( "welcome_link_{$i}_label", $default['label'] );

		if ( ! $label ) {
			continue;
		}

		$url = page_home( "welcome_link_{$i}_url", $default['url'] ) ?: '#';
		if ( '#' !== $url && 0 === strpos( $url, '/' ) ) {
			$url = home_url( $url );
		}

		$links[] = array(
			'label' => $label,
			'url'   => $url,
		);
	}

	return $links;
}

/**
 * Render Welcome block.
 */
function sony_music_render_block_welcome() {
	$gallery = sony_music_get_welcome_gallery();
	$links   = sony_music_get_welcome_links();

	if ( empty( $gallery ) && empty( $links ) ) {
		return;
	}

	get_template_part(
		'template-parts/home/block',
		'welcome',
		array(
			'gallery' => $gallery,
			'links'   => $links,
		)
	);
}

/**
 * Register Welcome customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_welcome_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'sony_music_home_welcome',
		array(
			'title'    => __( 'Homepage Welcome Section', 'sony-music' ),
			'priority' => 45,
		)
	);

	$wp_customize->add_setting(
		'sony_home_welcome_title',
		array(
			'default'           => 'Welcome to Sony Music',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_home_welcome_title',
		array(
			'label'   => __( 'Section title', 'sony-music' ),
			'section' => 'sony_music_home_welcome',
			'type'    => 'text',
		)
	);

	$gallery_defaults = sony_music_default_welcome_gallery();

	for ( $i = 1; $i <= 5; $i++ ) {
		$default = isset( $gallery_defaults[ $i - 1 ] ) ? $gallery_defaults[ $i - 1 ] : '';

		$wp_customize->add_setting(
			"sony_home_welcome_gallery_{$i}",
			array(
				'default'           => $default,
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"sony_home_welcome_gallery_{$i}",
				array(
					'label'   => sprintf( __( 'Gallery image %d', 'sony-music' ), $i ),
					'section' => 'sony_music_home_welcome',
				)
			)
		);
	}

	$link_defaults = sony_music_default_welcome_links();

	for ( $i = 1; $i <= 3; $i++ ) {
		$default = isset( $link_defaults[ $i - 1 ] ) ? $link_defaults[ $i - 1 ] : array(
			'label' => '',
			'url'   => '#',
		);

		$wp_customize->add_setting(
			"sony_home_welcome_link_{$i}_label",
			array(
				'default'           => $default['label'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_home_welcome_link_{$i}_label",
			array(
				'label'   => sprintf( __( 'Link %d — Label', 'sony-music' ), $i ),
				'section' => 'sony_music_home_welcome',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_home_welcome_link_{$i}_url",
			array(
				'default'           => $default['url'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"sony_home_welcome_link_{$i}_url",
			array(
				'label'       => sprintf( __( 'Link %d — URL', 'sony-music' ), $i ),
				'description' => __( 'Use # until the page is created.', 'sony-music' ),
				'section'     => 'sony_music_home_welcome',
				'type'        => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_welcome_customize_register', 20 );
