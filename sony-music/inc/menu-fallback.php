<?php
/**
 * Navigation menu fallbacks.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Primary offcanvas menu fallback.
 */
function sony_music_primary_menu_fallback() {
	$items = array(
		array(
			'label' => 'Home',
			'url'   => home_url( '/' ),
			'current' => is_front_page(),
		),
		array(
			'label' => 'News',
			'url'   => home_url( '/news/' ),
		),
		array(
			'label' => 'Artists',
			'url'   => home_url( '/artists/' ),
		),
		array(
			'label'    => 'Company',
			'url'      => home_url( '/company/' ),
			'children' => array(
				array( 'label' => 'About', 'url' => home_url( '/company/about/' ) ),
				array( 'label' => 'Culture', 'url' => home_url( '/company/culture/' ) ),
				array( 'label' => 'Music Licensing', 'url' => home_url( '/music-licensing/' ) ),
				array( 'label' => 'Circle Studios', 'url' => home_url( '/company/circle-studios/' ) ),
			),
		),
		array(
			'label' => 'Career',
			'url'   => home_url( '/company/career/' ),
		),
	);

	sony_music_render_menu_list( $items, 'menu-main-menu' );
}

/**
 * Offcanvas inner links fallback — uses site footer left column links.
 */
function sony_music_footer_menu_fallback() {
	$links = sony_music_get_footer_left_links();

	if ( empty( $links ) ) {
		return;
	}

	echo '<nav class="menu-footer-menu-left-container">';
	printf( '<ul id="%s" class="menu">', esc_attr( 'top-inner-menu' ) );

	foreach ( $links as $link ) {
		echo '<li class="menu-item">';
		$target = ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : '';
		printf(
			'<a href="%s"%s>%s</a>',
			esc_url( $link['url'] ),
			$target,
			esc_html( $link['label'] )
		);
		echo '</li>';
	}

	echo '</ul></nav>';
}

/**
 * Render a flat menu list.
 *
 * @param array  $items     Menu items.
 * @param string $menu_id   Menu ul id.
 * @param bool   $submenus  Whether items may have children.
 */
function sony_music_render_menu_list( $items, $menu_id, $submenus = true ) {
	echo '<nav class="menu-fallback-container">';
	printf( '<ul id="%s" class="menu">', esc_attr( $menu_id ) );

	foreach ( $items as $item ) {
		$has_children = $submenus && ! empty( $item['children'] );
		$classes      = array( 'menu-item' );

		if ( $has_children ) {
			$classes[] = 'menu-item-has-children';
		}
		if ( ! empty( $item['current'] ) ) {
			$classes[] = 'current-menu-item';
		}

		printf( '<li class="%s">', esc_attr( implode( ' ', $classes ) ) );

		$target = ! empty( $item['target'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		printf(
			'<a href="%s"%s%s>%s</a>',
			esc_url( $item['url'] ),
			! empty( $item['current'] ) ? ' aria-current="page"' : '',
			$target,
			esc_html( $item['label'] )
		);

		if ( $has_children ) {
			echo '<ul class="sub-menu">';
			foreach ( $item['children'] as $child ) {
				printf(
					'<li class="menu-item"><a href="%s">%s</a></li>',
					esc_url( $child['url'] ),
					esc_html( $child['label'] )
				);
			}
			echo '</ul>';
		}

		echo '</li>';
	}

	echo '</ul></nav>';
}
