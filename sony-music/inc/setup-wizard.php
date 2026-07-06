<?php
/**
 * Theme activation setup wizard.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Create a page and return its ID.
 *
 * @param string $title Page title.
 * @param string $slug  Page slug.
 * @return int
 */
function sony_music_create_page( $title, $slug ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		return (int) $existing->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'  => $title,
			'post_name'   => $slug,
			'post_status' => 'publish',
			'post_type'   => 'page',
			'post_content'=> '',
		)
	);

	return is_wp_error( $page_id ) ? 0 : (int) $page_id;
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
			'menu-item-title'  => $title,
			'menu-item-url'    => $url,
			'menu-item-status' => 'publish',
			'menu-item-type'   => 'custom',
			'menu-item-parent-id' => $parent,
		)
	);
}

/**
 * Run one-time setup on theme activation.
 */
function sony_music_theme_activation() {
	if ( get_option( 'sony_music_setup_done' ) ) {
		return;
	}

	$home_id = sony_music_create_page( 'Home', 'home' );

	if ( $home_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	sony_music_create_page( 'News', 'news' );
	sony_music_create_page( 'Artists', 'artists' );
	sony_music_create_page( 'Company', 'company' );
	sony_music_create_page( 'About', 'company/about' );
	sony_music_create_page( 'Culture', 'company/culture' );
	sony_music_create_page( 'Music Licensing', 'music-licensing' );
	sony_music_create_page( 'Circle Studios', 'company/circle-studios' );
	sony_music_create_page( 'Career', 'company/career' );
	sony_music_create_page( 'Contact', 'contact' );
	sony_music_create_page( 'AI Usage Terms', 'ai-usage-terms' );

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

	$locations           = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = is_wp_error( $primary_menu_id ) ? 0 : $primary_menu_id;
	$locations['footer']  = is_wp_error( $footer_menu_id ) ? 0 : $footer_menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	update_option( 'sony_music_setup_done', 1 );
}
add_action( 'after_switch_theme', 'sony_music_theme_activation' );
