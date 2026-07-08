<?php
/**
 * Sony Music theme functions.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

define( 'SONY_MUSIC_VERSION', '1.7.2' );
define( 'SONY_MUSIC_DIR', get_template_directory() );
define( 'SONY_MUSIC_URI', get_template_directory_uri() );

/**
 * Cache-busting version based on file modification time.
 *
 * @param string $relative_path Path relative to theme root.
 * @return string
 */
function sony_music_asset_version( $relative_path ) {
	$file = SONY_MUSIC_DIR . $relative_path;
	return file_exists( $file ) ? (string) filemtime( $file ) : SONY_MUSIC_VERSION;
}

require_once SONY_MUSIC_DIR . '/inc/customizer.php';
require_once SONY_MUSIC_DIR . '/inc/home-hero.php';
require_once SONY_MUSIC_DIR . '/inc/home-releases.php';
require_once SONY_MUSIC_DIR . '/inc/home-videos.php';
require_once SONY_MUSIC_DIR . '/inc/home-welcome.php';
require_once SONY_MUSIC_DIR . '/inc/career.php';
require_once SONY_MUSIC_DIR . '/inc/faq.php';
require_once SONY_MUSIC_DIR . '/inc/footer.php';
require_once SONY_MUSIC_DIR . '/inc/contact.php';
require_once SONY_MUSIC_DIR . '/inc/about.php';
require_once SONY_MUSIC_DIR . '/inc/music-licensing.php';
require_once SONY_MUSIC_DIR . '/inc/circle-studios.php';
require_once SONY_MUSIC_DIR . '/inc/news.php';
require_once SONY_MUSIC_DIR . '/inc/artists.php';
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
			'primary'     => __( 'Primary Menu (Offcanvas)', 'sony-music' ),
			'footer'      => __( 'Offcanvas Footer Links', 'sony-music' ),
			'footer_left' => __( 'Site Footer — Left Column', 'sony-music' ),
			'footer_right'  => __( 'Site Footer — Right Column', 'sony-music' ),
			'lang'        => __( 'Language Menu', 'sony-music' ),
		)
	);
}
add_action( 'after_setup_theme', 'sony_music_setup' );

/**
 * Enqueue scripts and styles.
 */
function sony_music_enqueue_assets() {
	wp_enqueue_style(
		'sony-music-style',
		get_stylesheet_uri(),
		array(),
		sony_music_asset_version( '/style.css' )
	);

	wp_enqueue_style(
		'sony-music-hero',
		SONY_MUSIC_URI . '/assets/css/hero.css',
		array( 'sony-music-style' ),
		sony_music_asset_version( '/assets/css/hero.css' )
	);

	wp_enqueue_style(
		'sony-music-releases',
		SONY_MUSIC_URI . '/assets/css/releases.css',
		array( 'sony-music-style' ),
		sony_music_asset_version( '/assets/css/releases.css' )
	);

	wp_enqueue_style(
		'sony-music-welcome',
		SONY_MUSIC_URI . '/assets/css/welcome.css',
		array( 'sony-music-style' ),
		sony_music_asset_version( '/assets/css/welcome.css' )
	);

	wp_enqueue_style(
		'sony-music-footer',
		SONY_MUSIC_URI . '/assets/css/footer.css',
		array( 'sony-music-style' ),
		sony_music_asset_version( '/assets/css/footer.css' )
	);

	wp_enqueue_script(
		'sony-music-main',
		SONY_MUSIC_URI . '/assets/js/main.js',
		array(),
		sony_music_asset_version( '/assets/js/main.js' ),
		true
	);

	if ( is_page( 'about' ) ) {
		wp_enqueue_style(
			'sony-music-about',
			SONY_MUSIC_URI . '/assets/css/about.css',
			array( 'sony-music-style' ),
			sony_music_asset_version( '/assets/css/about.css' )
		);

		wp_enqueue_script(
			'sony-music-about-accordion',
			SONY_MUSIC_URI . '/assets/js/faq.js',
			array(),
			sony_music_asset_version( '/assets/js/faq.js' ),
			true
		);
	}

	if ( is_page( 'music-licensing' ) ) {
		wp_enqueue_style(
			'sony-music-licensing',
			SONY_MUSIC_URI . '/assets/css/music-licensing.css',
			array( 'sony-music-style' ),
			sony_music_asset_version( '/assets/css/music-licensing.css' )
		);

		wp_enqueue_script(
			'sony-music-licensing-accordion',
			SONY_MUSIC_URI . '/assets/js/faq.js',
			array(),
			sony_music_asset_version( '/assets/js/faq.js' ),
			true
		);
	}

	if ( is_page( 'circle-studios' ) ) {
		wp_enqueue_style(
			'sony-music-circle-studios',
			SONY_MUSIC_URI . '/assets/css/circle-studios.css',
			array( 'sony-music-style' ),
			sony_music_asset_version( '/assets/css/circle-studios.css' )
		);
	}

	if ( is_page( 'news' ) ) {
		wp_enqueue_style(
			'sony-music-news',
			SONY_MUSIC_URI . '/assets/css/news.css',
			array( 'sony-music-style' ),
			sony_music_asset_version( '/assets/css/news.css' )
		);

		wp_enqueue_script(
			'sony-music-news',
			SONY_MUSIC_URI . '/assets/js/news.js',
			array(),
			sony_music_asset_version( '/assets/js/news.js' ),
			true
		);
	}

	if ( is_page( 'artists' ) ) {
		wp_enqueue_style(
			'sony-music-artists',
			SONY_MUSIC_URI . '/assets/css/artists.css',
			array( 'sony-music-style' ),
			sony_music_asset_version( '/assets/css/artists.css' )
		);

		wp_enqueue_script(
			'sony-music-artists',
			SONY_MUSIC_URI . '/assets/js/artists.js',
			array(),
			sony_music_asset_version( '/assets/js/artists.js' ),
			true
		);
	}

	if ( is_page( 'contact' ) ) {
		wp_enqueue_style(
			'sony-music-contact',
			SONY_MUSIC_URI . '/assets/css/contact.css',
			array( 'sony-music-style' ),
			sony_music_asset_version( '/assets/css/contact.css' )
		);

		wp_enqueue_script(
			'sony-music-contact-accordion',
			SONY_MUSIC_URI . '/assets/js/faq.js',
			array(),
			sony_music_asset_version( '/assets/js/faq.js' ),
			true
		);
	}

	if ( is_page( 'faq' ) ) {
		wp_enqueue_style(
			'sony-music-faq',
			SONY_MUSIC_URI . '/assets/css/faq.css',
			array( 'sony-music-style' ),
			sony_music_asset_version( '/assets/css/faq.css' )
		);

		wp_enqueue_script(
			'sony-music-faq',
			SONY_MUSIC_URI . '/assets/js/faq.js',
			array(),
			sony_music_asset_version( '/assets/js/faq.js' ),
			true
		);
	}

	if ( is_page( 'career' ) ) {
		wp_enqueue_style(
			'sony-music-career',
			SONY_MUSIC_URI . '/assets/css/career.css',
			array( 'sony-music-style' ),
			sony_music_asset_version( '/assets/css/career.css' )
		);

		wp_enqueue_script(
			'sony-music-career',
			SONY_MUSIC_URI . '/assets/js/career.js',
			array(),
			sony_music_asset_version( '/assets/js/career.js' ),
			true
		);
	}

	if ( is_front_page() ) {
		wp_enqueue_script(
			'sony-music-hero-slider',
			SONY_MUSIC_URI . '/assets/js/hero-slider.js',
			array(),
			sony_music_asset_version( '/assets/js/hero-slider.js' ),
			true
		);

		wp_enqueue_script(
			'sony-music-block-slider',
			SONY_MUSIC_URI . '/assets/js/block-slider.js',
			array(),
			sony_music_asset_version( '/assets/js/block-slider.js' ),
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

/**
 * Ensure hero slider layout even if a host strips part of the main stylesheet.
 */
function sony_music_hero_critical_css() {
	if ( ! is_front_page() ) {
		return;
	}
	?>
	<style id="sony-hero-critical">
		.block-hero .slider { background: #f7f7f7; }
		.block-hero .slider-viewport { overflow: hidden; }
		.block-hero .slider-track { display: flex !important; flex-wrap: nowrap; }
		.block-hero .slide-item { flex: 0 0 50%; max-width: 50%; }
		.block-hero .slider-image { min-height: 400px; background: #ddd; }
		@media (max-width: 767px) {
			.block-hero .slide-item { flex: 0 0 100%; max-width: 100%; }
		}
	</style>
	<?php
}
add_action( 'wp_head', 'sony_music_hero_critical_css', 99 );
