<?php
/**
 * Contact page helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Contact page content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_contact( $key, $default = '' ) {
	return get_theme_mod( 'sony_contact_' . $key, $default );
}

/**
 * Build an internal theme URL safely.
 *
 * @param string $path Path relative to site root.
 * @return string
 */
function sony_music_theme_url( $path ) {
	if ( function_exists( 'home_url' ) ) {
		return home_url( $path );
	}

	return $path;
}

/**
 * Default Berlin office block.
 *
 * @return string
 */
function sony_music_default_contact_office_berlin() {
	return '<p class="contact-address">Sony Music Entertainment <br>Germany GmbH (Berlin)<br>Bülowstr. 80<br>10783 Berlin<br>'
		. '<a href="tel:+4930138880">+49(0)30 13888-0</a><br>'
		. '<a href="mailto:kontakt@sonymusic.com">kontakt@sonymusic.com</a></p>';
}

/**
 * Default Munich office block.
 *
 * @return string
 */
function sony_music_default_contact_office_munich() {
	return '<p class="contact-address">Sony Music Entertainment <br>Germany GmbH (München)<br>Balanstr. 73, Haus 31<br>81541 München<br>'
		. '<a href="tel:+49895402220">+49-(0)89 540 222-0</a><br>'
		. '<a href="mailto:kontakt@sonymusic.com">kontakt@sonymusic.com</a></p>';
}

/**
 * Default contact accordion items from sonymusic.eu/contact/.
 *
 * @return array<int, array{title:string,answer:string}>
 */
function sony_music_default_contact_accordion_items() {
	$licensing = sony_music_theme_url( '/music-licensing/' );

	return array(
		array(
			'title'  => 'Press',
			'answer' => '<p>Get artist information, review records and receive press accreditations through Sony Music\'s Press and Promotion Service:</p>'
				. '<ul>'
				. '<li>Press: <a href="mailto:presse.promo@sonymusic.com">presse.promo@sonymusic.com</a>, <a href="mailto:julia.steiner@sonymusic.com">julia.steiner@sonymusic.com</a></li>'
				. '<li>Radio: <a href="mailto:radio.promo@sonymusic.com">radio.promo@sonymusic.com</a></li>'
				. '<li>TV: <a href="mailto:tv.promo@sonymusic.com">tv.promo@sonymusic.com</a></li>'
				. '<li>Family Entertainment: <a href="mailto:info@play-europa.de">info@play-europa.de</a></li>'
				. '<li>Catalog: <a href="mailto:catalog.promo@sonymusic.com">catalog.promo@sonymusic.com</a></li>'
				. '<li>Classical: <a href="mailto:classical.promo@sonymusic.com">classical.promo@sonymusic.com</a></li>'
				. '<li>Spassgesellschaft!: <a href="mailto:spassgesellschaft@sonymusic.com">spassgesellschaft@sonymusic.com</a></li>'
				. '<li>Filtr: <a href="mailto:filtrgermany@sonymusic.com">filtrgermany@sonymusic.com</a></li>'
				. '<li>Hörspiel Player: <a href="mailto:info@hoerspielplayer.de">info@hoerspielplayer.de</a></li>'
				. '</ul>',
		),
		array(
			'title'  => 'Company',
			'answer' => '<p>For information relating to Sony Music and the music industry in general, please contact the Corporate Communications Department:</p>'
				. '<p>Sony Music Entertainment Germany GmbH<br />Corporate Communications GSA<br />Bülowstr. 80, 10783 Berlin<br />'
				. '<a href="mailto:CorporateCommunicationsGSA@sonymusic.com">CorporateCommunicationsGSA@sonymusic.com</a></p>',
		),
		array(
			'title'  => 'Licensing & Sync',
			'answer' => '<p>You can find all information about music licensing <a href="' . esc_url( $licensing ) . '">here</a>.</p>'
				. '<p>Would you like to remix or sample a Sony Music artist\'s track (i.e. use an original soundtrack)? If the track was released in Germany, Austria or Switzerland, you can submit a sampling request <a href="' . esc_url( $licensing ) . '">here</a>.</p>',
		),
		array(
			'title'  => 'Product Safety',
			'answer' => '<p>Any product safety questions or concerns? Contact us here: <a href="mailto:product.safety@sonymusic.com">product.safety@sonymusic.com</a></p>',
		),
	);
}

/**
 * Get configured contact accordion items.
 *
 * @return array<int, array{title:string,answer:string}>
 */
function sony_music_get_contact_accordion_items() {
	$defaults = sony_music_default_contact_accordion_items();
	$items    = array();

	for ( $i = 1; $i <= 4; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'title'  => '',
			'answer' => '',
		);

		$title  = page_contact( "item_{$i}_title", $default['title'] );
		$answer = page_contact( "item_{$i}_answer", $default['answer'] );

		if ( ! $title ) {
			continue;
		}

		$items[] = array(
			'title'  => $title,
			'answer' => $answer,
		);
	}

	return $items;
}

/**
 * Render Contact page.
 */
function sony_music_render_contact_page() {
	get_template_part(
		'template-parts/contact/content',
		null,
		array(
			'page_title'      => page_contact( 'page_title', 'Contact' ),
			'office_berlin'   => page_contact( 'office_berlin', sony_music_default_contact_office_berlin() ),
			'office_munich'   => page_contact( 'office_munich', sony_music_default_contact_office_munich() ),
			'accordion_items' => sony_music_get_contact_accordion_items(),
		)
	);
}

/**
 * Register Contact customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_contact_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'sony_music_contact',
		array(
			'title'    => __( 'Contact Page', 'sony-music' ),
			'priority' => 56,
		)
	);

	$wp_customize->add_setting(
		'sony_contact_page_title',
		array(
			'default'           => 'Contact',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_contact_page_title',
		array(
			'label'   => __( 'Page title', 'sony-music' ),
			'section' => 'sony_music_contact',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sony_contact_office_berlin',
		array(
			'default'           => sony_music_default_contact_office_berlin(),
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'sony_contact_office_berlin',
		array(
			'label'   => __( 'Berlin office block (HTML allowed)', 'sony-music' ),
			'section' => 'sony_music_contact',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'sony_contact_office_munich',
		array(
			'default'           => sony_music_default_contact_office_munich(),
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'sony_contact_office_munich',
		array(
			'label'   => __( 'Munich office block (HTML allowed)', 'sony-music' ),
			'section' => 'sony_music_contact',
			'type'    => 'textarea',
		)
	);

	$defaults = sony_music_default_contact_accordion_items();

	for ( $i = 1; $i <= 4; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'title'  => '',
			'answer' => '',
		);

		$wp_customize->add_setting(
			"sony_contact_item_{$i}_title",
			array(
				'default'           => $default['title'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_contact_item_{$i}_title",
			array(
				'label'   => sprintf( __( 'Accordion %d — Title', 'sony-music' ), $i ),
				'section' => 'sony_music_contact',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_contact_item_{$i}_answer",
			array(
				'default'           => $default['answer'],
				'sanitize_callback' => 'wp_kses_post',
			)
		);
		$wp_customize->add_control(
			"sony_contact_item_{$i}_answer",
			array(
				'label'   => sprintf( __( 'Accordion %d — Answer (HTML allowed)', 'sony-music' ), $i ),
				'section' => 'sony_music_contact',
				'type'    => 'textarea',
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_contact_customize_register', 20 );
