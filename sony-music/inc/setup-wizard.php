<?php
/**
 * Theme activation setup wizard.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Run one-time setup on theme activation.
 */
function sony_music_theme_activation() {
	if ( get_option( 'sony_music_setup_done' ) ) {
		return;
	}

	$home_id = wp_insert_post(
		array(
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		)
	);

	if ( ! is_wp_error( $home_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	$menu_id = wp_create_nav_menu( 'Primary Menu' );

	if ( ! is_wp_error( $menu_id ) && $home_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => 'Home',
				'menu-item-object' => 'page',
				'menu-item-object-id' => $home_id,
				'menu-item-type'   => 'post_type',
				'menu-item-status' => 'publish',
			)
		);

		$locations            = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	update_option( 'sony_music_setup_done', 1 );
}
add_action( 'after_switch_theme', 'sony_music_theme_activation' );
