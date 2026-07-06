<?php
/**
 * Sony Music theme functions.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

define( 'SONY_MUSIC_VERSION', '1.0.0' );
define( 'SONY_MUSIC_DIR', get_template_directory() );
define( 'SONY_MUSIC_URI', get_template_directory_uri() );

require_once SONY_MUSIC_DIR . '/inc/customizer.php';
require_once SONY_MUSIC_DIR . '/inc/home-hero.php';
require_once SONY_MUSIC_DIR . '/inc/logo.php';
require_once SONY_MUSIC_DIR . '/inc/lang-fallback.php';
require_once SONY_MUSIC_DIR . '/inc/menu-fallback.php';
require_once SONY_MUSIC_DIR . '/inc/setup-wizard.php';
require_once SONY_MUSIC_DIR . '/inc/seo.php';

/**
 * Theme setup.
 */
function sony_music_setup() {
	load_theme_textdomain( 'sony-music', SONY_MUSIC_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 116,
		'width'       => 516,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu (Offcanvas)', 'sony-music' ),
			'footer'  => __( 'Offcanvas Footer Links', 'sony-music' ),
			'lang'    => __( 'Language Menu', 'sony-music' ),
		)
	);
}
add_action( 'after_setup_theme', 'sony_music_setup' );

/**
 * Enqueue scripts and styles.
 */
function sony_music_enqueue_assets() {
	wp_enqueue_style(
		'bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
		array(),
		'5.3.3'
	);

	wp_enqueue_style(
		'font-awesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
		array(),
		'6.5.2'
	);

	wp_enqueue_style(
		'sony-music-style',
		get_stylesheet_uri(),
		array( 'bootstrap' ),
		SONY_MUSIC_VERSION
	);

	wp_enqueue_script(
		'bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
		array(),
		'5.3.3',
		true
	);

	wp_enqueue_script(
		'sony-music-main',
		SONY_MUSIC_URI . '/assets/js/main.js',
		array(),
		SONY_MUSIC_VERSION,
		true
	);

	if ( is_front_page() ) {
		wp_enqueue_script(
			'sony-music-hero-slider',
			SONY_MUSIC_URI . '/assets/js/hero-slider.js',
			array(),
			SONY_MUSIC_VERSION,
			true
		);
	}

	wp_localize_script(
		'sony-music-main',
		'sonyMusic',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'sony_music_nonce' ),
			'homeUrl' => home_url( '/' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'sony_music_enqueue_assets' );

/**
 * Body classes.
 *
 * @param array $classes Body classes.
 * @return array
 */
function sony_music_body_classes( $classes ) {
	if ( site_data( 'show_topbar' ) ) {
		$classes[] = 'has-topbar';
	}
	return $classes;
}
add_filter( 'body_class', 'sony_music_body_classes' );
