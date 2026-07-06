<?php
/**
 * Theme activation setup wizard.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Required theme pages: title => path.
 *
 * @return array<string, string>
 */
function sony_music_required_pages() {
	return array(
		'Home'              => 'home',
		'News'              => 'news',
		'Artists'           => 'artists',
		'Company'           => 'company',
		'About'             => 'company/about',
		'Culture'           => 'company/culture',
		'Music Licensing'   => 'music-licensing',
		'Circle Studios'    => 'company/circle-studios',
		'Career'            => 'company/career',
		'FAQ'               => 'faq',
		'Contact'           => 'contact',
		'AI Usage Terms'    => 'ai-usage-terms',
	);
}

/**
 * Create a page (supports nested paths like company/career) and return its ID.
 *
 * @param string $title Page title.
 * @param string $path  Page path relative to site root.
 * @return int
 */
function sony_music_create_page( $title, $path ) {
	$path = trim( $path, '/' );

	if ( '' === $path ) {
		return 0;
	}

	$existing = get_page_by_path( $path );
	if ( $existing ) {
		return (int) $existing->ID;
	}

	$parts     = explode( '/', $path );
	$slug      = sanitize_title( (string) array_pop( $parts ) );
	$parent_id = 0;

	if ( ! empty( $parts ) ) {
		$parent_path = implode( '/', $parts );
		$parent      = get_page_by_path( $parent_path );

		if ( $parent ) {
			$parent_id = (int) $parent->ID;
		} else {
			$parent_title = ucwords( str_replace( array( '-', '_' ), ' ', basename( $parent_path ) ) );
			$parent_id    = sony_music_create_page( $parent_title, $parent_path );
		}
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_parent'  => $parent_id,
			'post_content' => '',
		)
	);

	return is_wp_error( $page_id ) ? 0 : (int) $page_id;
}

/**
 * Create any missing required pages.
 *
 * @return bool True when at least one page was created.
 */
function sony_music_ensure_required_pages() {
	$created = false;

	foreach ( sony_music_required_pages() as $title => $path ) {
		if ( ! get_page_by_path( $path ) ) {
			if ( sony_music_create_page( $title, $path ) ) {
				$created = true;
			}
		}
	}

	if ( $created ) {
		flush_rewrite_rules( false );
	}

	return $created;
}

/**
 * Add a menu item.
 *
 * @param int    $menu_id Menu ID.
 * @param string $title   Item title.
 * @param string $url     Item URL.
 * @param int    $parent  Parent item ID.
 * @return int Menu item ID.
 */
function sony_music_add_menu_item( $menu_id, $title, $url, $parent = 0 ) {
	return (int) wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title'     => $title,
			'menu-item-url'       => $url,
			'menu-item-status'    => 'publish',
			'menu-item-type'      => 'custom',
			'menu-item-parent-id' => $parent,
		)
	);
}

/**
 * Run one-time setup on theme activation.
 */
function sony_music_theme_activation() {
	sony_music_ensure_required_pages();

	$home = get_page_by_path( 'home' );
	if ( $home ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $home->ID );
	}

	if ( get_option( 'sony_music_setup_done' ) ) {
		return;
	}

	$primary_menu_id = wp_create_nav_menu( 'Primary Menu' );
	$footer_menu_id  = wp_create_nav_menu( 'Offcanvas Footer Links' );

	if ( ! is_wp_error( $primary_menu_id ) ) {
		sony_music_add_menu_item( $primary_menu_id, 'Home', home_url( '/' ) );
		sony_music_add_menu_item( $primary_menu_id, 'News', home_url( '/news/' ) );
		sony_music_add_menu_item( $primary_menu_id, 'Artists', home_url( '/artists/' ) );

		$company_id = sony_music_add_menu_item( $primary_menu_id, 'Company', home_url( '/company/' ) );
		sony_music_add_menu_item( $primary_menu_id, 'About', home_url( '/company/about/' ), $company_id );
		sony_music_add_menu_item( $primary_menu_id, 'Culture', home_url( '/company/culture/' ), $company_id );
		sony_music_add_menu_item( $primary_menu_id, 'Music Licensing', home_url( '/music-licensing/' ), $company_id );
		sony_music_add_menu_item( $primary_menu_id, 'Circle Studios', home_url( '/company/circle-studios/' ), $company_id );

		sony_music_add_menu_item( $primary_menu_id, 'Career', home_url( '/company/career/' ) );
	}

	if ( ! is_wp_error( $footer_menu_id ) ) {
		sony_music_add_menu_item( $footer_menu_id, 'Contact', home_url( '/contact/' ) );
		sony_music_add_menu_item( $footer_menu_id, 'Instagram', 'https://www.instagram.com/sonymusicde' );
		sony_music_add_menu_item( $footer_menu_id, 'AI Usage Terms', home_url( '/ai-usage-terms/' ) );
	}

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = is_wp_error( $primary_menu_id ) ? 0 : $primary_menu_id;
	$locations['footer']  = is_wp_error( $footer_menu_id ) ? 0 : $footer_menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	update_option( 'sony_music_setup_done', 1 );
}
add_action( 'after_switch_theme', 'sony_music_theme_activation' );

/**
 * Ensure required pages exist after theme upload (not only first activation).
 */
function sony_music_bootstrap_required_pages() {
	if ( wp_installing() ) {
		return;
	}

	sony_music_ensure_required_pages();
}
add_action( 'init', 'sony_music_bootstrap_required_pages', 20 );
