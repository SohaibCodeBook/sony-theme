<?php
/**
 * Homepage New Videos slider helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default New Videos slides from sonymusic.eu.
 *
 * @return array<int, array{artist:string,title:string,video_url:string,image:string}>
 */
function sony_music_default_videos_slides() {
	return array(
		array(
			'artist'    => 'Angèle',
			'title'     => 'DIS-LE',
			'video_url' => 'https://www.youtube.com/embed/IvfuwIRUFU0?autoplay=1&mute=1',
			'image'     => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/06/Angele.jpg',
		),
		array(
			'artist'    => 'Electric Callboy x The Offspring',
			'title'     => 'Let The Good Times Roll',
			'video_url' => 'https://www.youtube.com/embed/UUGGRIaVfds?autoplay=1&mute=1',
			'image'     => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/06/Electric-Callboy-x-The-Offspring.jpg',
		),
		array(
			'artist'    => 'Tyla',
			'title'     => 'IS IT LOVE',
			'video_url' => 'https://www.youtube.com/embed/YdrW1SJwiMs?autoplay=1&mute=1',
			'image'     => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2025/10/Tyla-scaled.jpg',
		),
		array(
			'artist'    => 'Harry Styles',
			'title'     => 'Dance No More',
			'video_url' => 'https://www.youtube.com/embed/-rkjE0xc730?autoplay=1&mute=1',
			'image'     => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/03/Harry-Styles-Kopie.jpg',
		),
		array(
			'artist'    => 'Shakira x Burna Boy',
			'title'     => 'Dai Dai',
			'video_url' => 'https://www.youtube.com/embed/fcnDmrtj6Sk?autoplay=1&mute=1',
			'image'     => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/05/Shakira-scaled.jpg',
		),
	);
}

/**
 * Get configured New Videos slides.
 *
 * @return array<int, array{artist:string,title:string,video_url:string,image:string}>
 */
function sony_music_get_videos_slides() {
	$defaults = sony_music_default_videos_slides();
	$slides   = array();

	for ( $i = 1; $i <= 5; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'artist'    => '',
			'title'     => '',
			'video_url' => '',
			'image'     => '',
		);

		$artist = page_home( "videos_slide_{$i}_artist", $default['artist'] );

		if ( ! $artist ) {
			continue;
		}

		$slides[] = array(
			'artist'    => $artist,
			'title'     => page_home( "videos_slide_{$i}_title", $default['title'] ),
			'video_url' => page_home( "videos_slide_{$i}_video_url", $default['video_url'] ) ?: '#',
			'image'     => page_home( "videos_slide_{$i}_image", $default['image'] ),
		);
	}

	return $slides;
}

/**
 * Render New Videos block.
 */
function sony_music_render_block_videos() {
	$slides = sony_music_get_videos_slides();

	if ( empty( $slides ) ) {
		return;
	}

	get_template_part( 'template-parts/home/block', 'videos', array( 'slides' => $slides ) );
}

/**
 * Register New Videos customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_videos_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'sony_music_home_videos',
		array(
			'title'    => __( 'Homepage New Videos Slider', 'sony-music' ),
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'sony_home_videos_title_1',
		array(
			'default'           => 'New',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_home_videos_title_1',
		array(
			'label'   => __( 'Section title line 1', 'sony-music' ),
			'section' => 'sony_music_home_videos',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sony_home_videos_title_2',
		array(
			'default'           => 'Videos',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_home_videos_title_2',
		array(
			'label'   => __( 'Section title line 2', 'sony-music' ),
			'section' => 'sony_music_home_videos',
			'type'    => 'text',
		)
	);

	$defaults = sony_music_default_videos_slides();

	for ( $i = 1; $i <= 5; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'artist'    => '',
			'title'     => '',
			'video_url' => '',
			'image'     => '',
		);

		$wp_customize->add_setting(
			"sony_home_videos_slide_{$i}_artist",
			array(
				'default'           => $default['artist'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_home_videos_slide_{$i}_artist",
			array(
				'label'   => sprintf( __( 'Slide %d — Artist', 'sony-music' ), $i ),
				'section' => 'sony_music_home_videos',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_home_videos_slide_{$i}_title",
			array(
				'default'           => $default['title'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_home_videos_slide_{$i}_title",
			array(
				'label'   => sprintf( __( 'Slide %d — Video title', 'sony-music' ), $i ),
				'section' => 'sony_music_home_videos',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_home_videos_slide_{$i}_video_url",
			array(
				'default'           => $default['video_url'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"sony_home_videos_slide_{$i}_video_url",
			array(
				'label'       => sprintf( __( 'Slide %d — YouTube embed URL', 'sony-music' ), $i ),
				'description' => __( 'Use the YouTube embed URL with ?autoplay=1&mute=1', 'sony-music' ),
				'section'     => 'sony_music_home_videos',
				'type'        => 'url',
			)
		);

		$wp_customize->add_setting(
			"sony_home_videos_slide_{$i}_image",
			array(
				'default'           => $default['image'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"sony_home_videos_slide_{$i}_image",
				array(
					'label'   => sprintf( __( 'Slide %d — Image', 'sony-music' ), $i ),
					'section' => 'sony_music_home_videos',
				)
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_videos_customize_register', 20 );
