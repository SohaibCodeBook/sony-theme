<?php
/**
 * FAQ page helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * FAQ page content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_faq( $key, $default = '' ) {
	return get_theme_mod( 'sony_faq_' . $key, $default );
}

/**
 * Default FAQ items from sonymusic.eu/faq/.
 *
 * @return array<int, array{question:string,answer:string}>
 */
function sony_music_default_faq_items() {
	$contact = esc_url( home_url( '/contact/' ) );
	$career  = esc_url( home_url( '/company/career/' ) );
	$demos   = esc_url( home_url( '/demos/' ) );

	return array(
		array(
			'question' => 'Where can I find artists pictures?',
			'answer'   => '<h3>Here <a href="http://www.insidesonymusic.com" target="_blank" rel="noreferrer noopener">www.insidesonymusic.de</a></h3>'
				. '<h3>To contact our press department, click <a href="' . $contact . '">here</a> entlang.</h3>',
		),
		array(
			'question' => 'How can I book your artists?',
			'answer'   => '<h3>For Booking requests, reach out to <a href="http://brands.sonymusic.de/kontakt/" target="_blank" rel="noreferrer noopener">Sony Music Partnerships</a></h3>',
		),
		array(
			'question' => 'How can I license music from Sony Music\'s repertoire?',
			'answer'   => '<h3>To advertise with our artists, brands or content, or to license music for commercials or films, please contact <a href="http://brands.sonymusic.de/kontakt/" target="_blank" rel="noreferrer noopener">Sony Music Partnerships</a></h3>',
		),
		array(
			'question' => 'How can I apply at Sony Music?',
			'answer'   => '<h3>All currently advertised jobs, internships and working student positions as well as further information can be found <a href="' . $career . '">here</a>.</h3>',
		),
		array(
			'question' => 'Where can i submit my demo?',
			'answer'   => '<h3>You can submit your files <a href="' . $demos . '">here</a> einreichen</h3>',
		),
	);
}

/**
 * Get configured FAQ items.
 *
 * @return array<int, array{question:string,answer:string}>
 */
function sony_music_get_faq_items() {
	$defaults = sony_music_default_faq_items();
	$items    = array();

	for ( $i = 1; $i <= 5; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'question' => '',
			'answer'   => '',
		);

		$question = page_faq( "item_{$i}_question", $default['question'] );
		$answer   = page_faq( "item_{$i}_answer", $default['answer'] );

		if ( ! $question ) {
			continue;
		}

		$items[] = array(
			'question' => $question,
			'answer'   => $answer,
		);
	}

	return $items;
}

/**
 * Render FAQ page.
 */
function sony_music_render_faq_page() {
	$items = sony_music_get_faq_items();

	get_template_part(
		'template-parts/faq/accordion',
		null,
		array(
			'page_title' => page_faq( 'page_title', 'FAQ' ),
			'items'      => $items,
		)
	);
}

/**
 * Register FAQ customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_faq_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'sony_music_faq',
		array(
			'title'    => __( 'FAQ Page', 'sony-music' ),
			'priority' => 55,
		)
	);

	$wp_customize->add_setting(
		'sony_faq_page_title',
		array(
			'default'           => 'FAQ',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_faq_page_title',
		array(
			'label'   => __( 'Page title', 'sony-music' ),
			'section' => 'sony_music_faq',
			'type'    => 'text',
		)
	);

	$defaults = sony_music_default_faq_items();

	for ( $i = 1; $i <= 5; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'question' => '',
			'answer'   => '',
		);

		$wp_customize->add_setting(
			"sony_faq_item_{$i}_question",
			array(
				'default'           => $default['question'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_faq_item_{$i}_question",
			array(
				'label'   => sprintf( __( 'Item %d — Question', 'sony-music' ), $i ),
				'section' => 'sony_music_faq',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_faq_item_{$i}_answer",
			array(
				'default'           => $default['answer'],
				'sanitize_callback' => 'wp_kses_post',
			)
		);
		$wp_customize->add_control(
			"sony_faq_item_{$i}_answer",
			array(
				'label'   => sprintf( __( 'Item %d — Answer (HTML allowed)', 'sony-music' ), $i ),
				'section' => 'sony_music_faq',
				'type'    => 'textarea',
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_faq_customize_register', 20 );
