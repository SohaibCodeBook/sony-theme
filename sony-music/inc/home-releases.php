<?php
/**
 * Homepage New Releases slider helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default New Releases slides from sonymusic.eu.
 *
 * @return array<int, array{artist:string,release:string,url:string,image:string}>
 */
function sony_music_default_releases_slides() {
	return array(
		array(
			'artist'  => 'Myles Smith',
			'release' => 'My Mess, My Heart, My Life.',
			'url'     => 'https://open.spotify.com/album/08u2urMBBJIz9kMwAl08yI',
			'image'   => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/05/Myles-Smith-scaled.jpg',
		),
		array(
			'artist'  => 'Alok x Jennifer Lopez',
			'release' => 'Everything\'s Fine',
			'url'     => 'https://open.spotify.com/track/1kLGkdqxQLZoQD9MBxyiwY',
			'image'   => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/06/Alok-Jennifer-Lopez-scaled.jpg',
		),
		array(
			'artist'  => 'Zara Larsson',
			'release' => 'Midnight Sun: Girls Trip',
			'url'     => 'https://open.spotify.com/album/4WMcRlbt7NvpKrrqO8ykQf',
			'image'   => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/05/Zara-Larsson.jpg',
		),
		array(
			'artist'  => 'F3miii x The Kid LAROI',
			'release' => 'NOBLE',
			'url'     => 'https://open.spotify.com/track/00meonIF1VYLe1eTcx3w9e',
			'image'   => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/06/F3miii-x-The-Kid-LAROI-‚NOBLE‘.jpg',
		),
		array(
			'artist'  => 'Isabel van Gelder',
			'release' => 'I Don\'t Want To Fall In Love Again',
			'url'     => 'https://open.spotify.com/track/54HHg1hkAWyJkS2QFeyOrY',
			'image'   => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/06/Isabel-van-Gelder.jpg',
		),
	);
}

/**
 * Get configured New Releases slides.
 *
 * @return array<int, array{artist:string,release:string,url:string,image:string}>
 */
function sony_music_get_releases_slides() {
	$defaults = sony_music_default_releases_slides();
	$slides   = array();

	for ( $i = 1; $i <= 5; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'artist'  => '',
			'release' => '',
			'url'     => '',
			'image'   => '',
		);

		$artist = page_home( "releases_slide_{$i}_artist", $default['artist'] );

		if ( ! $artist ) {
			continue;
		}

		$slides[] = array(
			'artist'  => $artist,
			'release' => page_home( "releases_slide_{$i}_release", $default['release'] ),
			'url'     => page_home( "releases_slide_{$i}_url", $default['url'] ) ?: '#',
			'image'   => page_home( "releases_slide_{$i}_image", $default['image'] ),
		);
	}

	return $slides;
}

/**
 * Render New Releases block.
 */
function sony_music_render_block_releases() {
	$slides = sony_music_get_releases_slides();

	if ( empty( $slides ) ) {
		return;
	}

	get_template_part( 'template-parts/home/block', 'releases', array( 'slides' => $slides ) );
}

/**
 * Register New Releases customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_releases_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'sony_music_home_releases',
		array(
			'title'    => __( 'Homepage New Releases Slider', 'sony-music' ),
			'priority' => 35,
		)
	);

	$wp_customize->add_setting(
		'sony_home_releases_title_1',
		array(
			'default'           => 'New',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_home_releases_title_1',
		array(
			'label'   => __( 'Section title line 1', 'sony-music' ),
			'section' => 'sony_music_home_releases',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sony_home_releases_title_2',
		array(
			'default'           => 'Releases',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_home_releases_title_2',
		array(
			'label'   => __( 'Section title line 2', 'sony-music' ),
			'section' => 'sony_music_home_releases',
			'type'    => 'text',
		)
	);

	$defaults = sony_music_default_releases_slides();

	for ( $i = 1; $i <= 5; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'artist'  => '',
			'release' => '',
			'url'     => '',
			'image'   => '',
		);

		$wp_customize->add_setting(
			"sony_home_releases_slide_{$i}_artist",
			array(
				'default'           => $default['artist'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_home_releases_slide_{$i}_artist",
			array(
				'label'   => sprintf( __( 'Slide %d — Artist', 'sony-music' ), $i ),
				'section' => 'sony_music_home_releases',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_home_releases_slide_{$i}_release",
			array(
				'default'           => $default['release'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_home_releases_slide_{$i}_release",
			array(
				'label'   => sprintf( __( 'Slide %d — Release title', 'sony-music' ), $i ),
				'section' => 'sony_music_home_releases',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_home_releases_slide_{$i}_url",
			array(
				'default'           => $default['url'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"sony_home_releases_slide_{$i}_url",
			array(
				'label'   => sprintf( __( 'Slide %d — Link URL', 'sony-music' ), $i ),
				'section' => 'sony_music_home_releases',
				'type'    => 'url',
			)
		);

		$wp_customize->add_setting(
			"sony_home_releases_slide_{$i}_image",
			array(
				'default'           => $default['image'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"sony_home_releases_slide_{$i}_image",
				array(
					'label'   => sprintf( __( 'Slide %d — Image', 'sony-music' ), $i ),
					'section' => 'sony_music_home_releases',
				)
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_releases_customize_register', 20 );
