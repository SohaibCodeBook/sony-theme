<?php
/**
 * Career / Jobs page helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Career page content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_career( $key, $default = '' ) {
	return get_theme_mod( 'sony_career_' . $key, $default );
}

/**
 * Default job filter groups from sonymusic.eu.
 *
 * @return array<string, array<int, array{id:string,label:string}>>
 */
function sony_music_default_career_filters() {
	return array(
		'departments' => array(
			array( 'id' => '65', 'label' => 'A&R' ),
			array( 'id' => '87', 'label' => 'Administrative Support' ),
			array( 'id' => '153', 'label' => 'Business & Legal Affairs' ),
			array( 'id' => '123', 'label' => 'Finance' ),
			array( 'id' => '110', 'label' => 'Internship Program' ),
			array( 'id' => '79', 'label' => 'Marketing' ),
		),
		'location'    => array(
			array( 'id' => '176', 'label' => 'Europe' ),
		),
		'type'        => array(
			array( 'id' => '59', 'label' => 'Full-time' ),
			array( 'id' => '113', 'label' => 'Intern' ),
		),
	);
}

/**
 * Default job listings from sonymusic.eu.
 *
 * @return array<int, array{title:string,slug:string,departments:array,type:string}>
 */
function sony_music_default_career_jobs() {
	return array(
		array(
			'title'       => 'Business Controller (m/w/d) – M&A und Ventures',
			'slug'        => 'business-controller-m-w-d-ma-und-ventures',
			'departments' => array( '123' ),
			'type'        => '59',
		),
		array(
			'title'       => 'Digital Marketing Manager (m/w/d) – Family Entertainment',
			'slug'        => 'digital-marketing-manager-m-w-d-family-entertainment',
			'departments' => array( '79' ),
			'type'        => '59',
		),
		array(
			'title'       => 'Praktikant (m/w/d) A&R für die Labels Epic & Nitron',
			'slug'        => 'praktikant-m-w-d-ar-fur-die-labels-epic-nitron',
			'departments' => array( '65', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Senior A&R Manager (m/w/d) – Century Media Records',
			'slug'        => 'senior-ar-manager-m-w-d-century-media-records',
			'departments' => array( '65' ),
			'type'        => '59',
		),
		array(
			'title'       => 'Werkstudent (m/w/d) Video/Content Production & Support Circle Studios',
			'slug'        => 'werkstudent-m-w-d-video-content-production-support-circle-studios',
			'departments' => array( '79' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Marketing & Product Management Sony Classical GSA',
			'slug'        => 'praktikant-m-w-d-marketing-product-management-sony-classical-gsa',
			'departments' => array( '79', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Music Licensing & Rights Management',
			'slug'        => 'praktikant-m-w-d-music-licensing-rights-management',
			'departments' => array( '153', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Media Relations – Radio Relations',
			'slug'        => 'praktikant-m-w-d-media-relations-radio-relations',
			'departments' => array( '79', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Marketing, PR und Content Creation für das Label Century Media',
			'slug'        => 'praktikant-m-w-d-marketing-pr-und-content-creation-fur-das-label-century-media',
			'departments' => array( '79', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Commercial Partnerships / Streaming',
			'slug'        => 'praktikant-m-w-d-commercial-partnerships-streaming',
			'departments' => array( '79', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Media Relations – TV Relations',
			'slug'        => 'praktikant-m-w-d-media-relations-tv-relations',
			'departments' => array( '79', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Catalog + 1991 Artist & Label Services',
			'slug'        => 'praktikant-m-w-d-catalog-1991-artist-label-services',
			'departments' => array( '79', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Data & Strategy',
			'slug'        => 'praktikant-m-w-d-data-strategy',
			'departments' => array( '79', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Engagement Marketing',
			'slug'        => 'praktikant-m-w-d-engagement-marketing',
			'departments' => array( '79', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Director (m/w/d) Corporate M&A – Business & Legal Affairs',
			'slug'        => 'director-m-w-d-corporate-ma-business-legal-affairs',
			'departments' => array( '153' ),
			'type'        => '59',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Retail Team',
			'slug'        => 'praktikant-m-w-d-retail-team',
			'departments' => array( '79', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Praktikant (m/w/d) Promotion/Public Relations + Social Media',
			'slug'        => 'praktikant-m-w-d-promotion-public-relations-social-media',
			'departments' => array( '79', '110' ),
			'type'        => '113',
		),
		array(
			'title'       => 'Rechtsreferendar:in (m/w/d) Legal & Business Affairs',
			'slug'        => 'rechtsreferendarin-m-w-d-legal-business-affairs',
			'departments' => array( '153' ),
			'type'        => '59',
		),
	);
}

/**
 * Get configured job listings.
 *
 * @return array<int, array{title:string,slug:string,departments:array,type:string,url:string}>
 */
function sony_music_get_career_jobs() {
	$defaults = sony_music_default_career_jobs();
	$jobs     = array();

	for ( $i = 1; $i <= 20; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'title'       => '',
			'slug'        => '',
			'departments' => array(),
			'type'        => '',
		);

		$title = page_career( "job_{$i}_title", $default['title'] );

		if ( ! $title ) {
			continue;
		}

		$slug = page_career( "job_{$i}_slug", $default['slug'] );

		$jobs[] = array(
			'title'       => $title,
			'slug'        => $slug,
			'departments' => $default['departments'],
			'type'        => $default['type'],
			'url'         => $slug ? home_url( '/job/' . $slug . '/' ) : '#',
		);
	}

	return $jobs;
}

/**
 * Career FAQ URL.
 *
 * @return string
 */
function sony_music_career_faq_url() {
	$url = page_career( 'faq_url', home_url( '/career-faq/' ) );
	return $url ? $url : home_url( '/career-faq/' );
}

/**
 * Render Career jobs page.
 */
function sony_music_render_career_page() {
	$jobs    = sony_music_get_career_jobs();
	$filters = sony_music_default_career_filters();

	get_template_part(
		'template-parts/career/jobs',
		null,
		array(
			'jobs'    => $jobs,
			'filters' => $filters,
		)
	);
}

/**
 * Register Career customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_career_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'sony_music_career',
		array(
			'title'    => __( 'Career Page', 'sony-music' ),
			'priority' => 50,
		)
	);

	$wp_customize->add_setting(
		'sony_career_page_title',
		array(
			'default'           => 'Jobs',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_career_page_title',
		array(
			'label'   => __( 'Page title', 'sony-music' ),
			'section' => 'sony_music_career',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sony_career_search_placeholder',
		array(
			'default'           => 'Suche',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_career_search_placeholder',
		array(
			'label'   => __( 'Search placeholder', 'sony-music' ),
			'section' => 'sony_music_career',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'sony_career_faq_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'sony_career_faq_url',
		array(
			'label'       => __( 'FAQ button URL', 'sony-music' ),
			'description' => __( 'Career FAQ page (not built yet).', 'sony-music' ),
			'section'     => 'sony_music_career',
			'type'        => 'url',
		)
	);

	$wp_customize->add_setting(
		'sony_career_mission_text',
		array(
			'default'           => "You belong. At Sony Music.\nUnser Ziel ist es, so vielfältig zu sein wie unsere Artists. So bunt wie unsere Audiences. So divers wie alle Musikliebenden.\nWir wollen als kulturschaffendes Musikunternehmen eine Realität gestalten, in der sich alle Talente als sie selbst und diskriminierungsfrei entfalten können.\nAlso komm zu uns. Mit deiner Vielfalt.\nBring your Influence.",
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'sony_career_mission_text',
		array(
			'label'   => __( 'Mission modal text', 'sony-music' ),
			'section' => 'sony_music_career',
			'type'    => 'textarea',
		)
	);

	$defaults = sony_music_default_career_jobs();

	for ( $i = 1; $i <= 20; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'title' => '',
			'slug'  => '',
		);

		$wp_customize->add_setting(
			"sony_career_job_{$i}_title",
			array(
				'default'           => $default['title'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_career_job_{$i}_title",
			array(
				'label'   => sprintf( __( 'Job %d — Title', 'sony-music' ), $i ),
				'section' => 'sony_music_career',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_career_job_{$i}_slug",
			array(
				'default'           => $default['slug'],
				'sanitize_callback' => 'sanitize_title',
			)
		);
		$wp_customize->add_control(
			"sony_career_job_{$i}_slug",
			array(
				'label'       => sprintf( __( 'Job %d — Slug', 'sony-music' ), $i ),
				'description' => __( 'Used for /job/slug/ URLs.', 'sony-music' ),
				'section'     => 'sony_music_career',
				'type'        => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_career_customize_register', 20 );
