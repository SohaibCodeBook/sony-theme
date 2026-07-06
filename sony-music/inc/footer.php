<?php
/**
 * Site footer helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Footer content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_footer( $key, $default = '' ) {
	return get_theme_mod( 'sony_footer_' . $key, $default );
}

/**
 * Default left footer links from sonymusic.eu.
 *
 * @return array<int, array{label:string,url:string,target?:string}>
 */
function sony_music_default_footer_left_links() {
	return array(
		array(
			'label' => 'Contact',
			'url'   => home_url( '/contact/' ),
		),
		array(
			'label' => 'Imprint',
			'url'   => home_url( '/imprint/' ),
		),
		array(
			'label'  => 'Facebook',
			'url'    => 'https://de-de.facebook.com/sonymusicde/',
			'target' => '_blank',
		),
		array(
			'label'  => 'Instagram',
			'url'    => 'https://www.instagram.com/sonymusicde',
			'target' => '_blank',
		),
		array(
			'label' => 'Demos',
			'url'   => home_url( '/demos/' ),
		),
		array(
			'label' => 'FAQ',
			'url'   => home_url( '/faq/' ),
		),
		array(
			'label' => 'AI Usage Terms',
			'url'   => home_url( '/ai-usage-terms/' ),
		),
	);
}

/**
 * Default right footer links from sonymusic.eu.
 *
 * @return array<int, array{label:string,url:string,target?:string}>
 */
function sony_music_default_footer_right_links() {
	return array(
		array(
			'label' => 'Data protection',
			'url'   => home_url( '/privacy-policy/' ),
		),
		array(
			'label' => 'General conditions of participation',
			'url'   => home_url( '/general-conditions-of-participation/' ),
		),
	);
}

/**
 * Get configured left footer links.
 *
 * @return array<int, array{label:string,url:string,target?:string}>
 */
function sony_music_get_footer_left_links() {
	if ( has_nav_menu( 'footer_left' ) ) {
		return sony_music_footer_links_from_menu( 'footer_left' );
	}

	$defaults = sony_music_default_footer_left_links();
	$links    = array();

	for ( $i = 1; $i <= 7; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'label' => '',
			'url'   => '',
		);

		$label = page_footer( "left_{$i}_label", $default['label'] );
		$url   = page_footer( "left_{$i}_url", $default['url'] );

		if ( ! $label || ! $url ) {
			continue;
		}

		$link = array(
			'label' => $label,
			'url'   => $url,
		);

		if ( ! empty( $default['target'] ) || page_footer( "left_{$i}_target", ! empty( $default['target'] ) ) ) {
			$link['target'] = '_blank';
		}

		$links[] = $link;
	}

	return $links;
}

/**
 * Get configured right footer links.
 *
 * @return array<int, array{label:string,url:string,target?:string}>
 */
function sony_music_get_footer_right_links() {
	if ( has_nav_menu( 'footer_right' ) ) {
		return sony_music_footer_links_from_menu( 'footer_right' );
	}

	$defaults = sony_music_default_footer_right_links();
	$links    = array();

	for ( $i = 1; $i <= 2; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'label' => '',
			'url'   => '',
		);

		$label = page_footer( "right_{$i}_label", $default['label'] );
		$url   = page_footer( "right_{$i}_url", $default['url'] );

		if ( ! $label || ! $url ) {
			continue;
		}

		$links[] = array(
			'label' => $label,
			'url'   => $url,
		);
	}

	return $links;
}

/**
 * Build footer link items from a registered menu location.
 *
 * @param string $location Menu location slug.
 * @return array<int, array{label:string,url:string,target?:string}>
 */
function sony_music_footer_links_from_menu( $location ) {
	$locations = get_nav_menu_locations();

	if ( empty( $locations[ $location ] ) ) {
		return array();
	}

	$items = wp_get_nav_menu_items( $locations[ $location ] );

	if ( ! $items ) {
		return array();
	}

	$links = array();

	foreach ( $items as $item ) {
		if ( 'custom' !== $item->type && 0 !== (int) $item->menu_item_parent ) {
			continue;
		}

		$link = array(
			'label' => $item->title,
			'url'   => $item->url,
		);

		if ( ! empty( $item->target ) ) {
			$link['target'] = $item->target;
		}

		$links[] = $link;
	}

	return $links;
}

/**
 * Render a footer menu list.
 *
 * @param array  $links       Footer links.
 * @param string $menu_id     Menu ul id.
 * @param string $container_class Container class.
 */
function sony_music_render_footer_menu( $links, $menu_id, $container_class ) {
	if ( empty( $links ) ) {
		return;
	}

	echo '<div class="widget widget_nav_menu"><div class="widget-content">';
	printf( '<div class="%s">', esc_attr( $container_class ) );
	printf( '<ul id="%s" class="menu">', esc_attr( $menu_id ) );

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

	echo '</ul></div></div></div>';
}

/**
 * Footer copyright text.
 *
 * @return string
 */
function sony_music_footer_copyright() {
	$text = page_footer( 'copyright', 'Sony Music Entertainment Europe © ' . gmdate( 'Y' ) );
	return $text ? $text : 'Sony Music Entertainment Europe © ' . gmdate( 'Y' );
}

/**
 * Render site footer.
 */
function sony_music_render_site_footer() {
	$left_links  = sony_music_get_footer_left_links();
	$right_links = sony_music_get_footer_right_links();
	?>
	<footer id="footer">
		<div class="container">
			<div class="footer-nav">
				<div class="footer-nav--left">
					<?php sony_music_render_footer_menu( $left_links, 'menu-footer-menu-left', 'menu-footer-menu-left-container' ); ?>
				</div>
				<div class="footer-nav--middle">
					<a href="#" id="footer-nav-up" aria-label="<?php esc_attr_e( 'Scroll Up', 'sony-music' ); ?>">↑</a>
				</div>
				<div class="footer-nav--right">
					<a href="#" id="footer-nav-up-mobile" aria-label="<?php esc_attr_e( 'Scroll Up', 'sony-music' ); ?>">
						<svg width="20" height="20" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
							<path d="M12 5l7 7-1.4 1.4L13 9.8V20h-2V9.8l-4.6 4.6L5 12z" fill="currentColor"></path>
						</svg>
					</a>
					<?php sony_music_render_footer_menu( $right_links, 'menu-footer-menu-right', 'menu-footer-menu-right-container' ); ?>
				</div>
			</div>
			<div class="copyright notranslate">
				<?php echo esc_html( sony_music_footer_copyright() ); ?>
			</div>
		</div>
	</footer>
	<?php
}

/**
 * Register footer customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_footer_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'sony_music_footer',
		array(
			'title'    => __( 'Site Footer', 'sony-music' ),
			'priority' => 60,
		)
	);

	$wp_customize->add_setting(
		'sony_footer_copyright',
		array(
			'default'           => 'Sony Music Entertainment Europe © ' . gmdate( 'Y' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sony_footer_copyright',
		array(
			'label'   => __( 'Copyright text', 'sony-music' ),
			'section' => 'sony_music_footer',
			'type'    => 'text',
		)
	);

	$left_defaults = sony_music_default_footer_left_links();

	for ( $i = 1; $i <= 7; $i++ ) {
		$default = isset( $left_defaults[ $i - 1 ] ) ? $left_defaults[ $i - 1 ] : array(
			'label' => '',
			'url'   => '',
		);

		$wp_customize->add_setting(
			"sony_footer_left_{$i}_label",
			array(
				'default'           => $default['label'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_footer_left_{$i}_label",
			array(
				'label'   => sprintf( __( 'Left link %d — Label', 'sony-music' ), $i ),
				'section' => 'sony_music_footer',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_footer_left_{$i}_url",
			array(
				'default'           => $default['url'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"sony_footer_left_{$i}_url",
			array(
				'label'   => sprintf( __( 'Left link %d — URL', 'sony-music' ), $i ),
				'section' => 'sony_music_footer',
				'type'    => 'url',
			)
		);

		$wp_customize->add_setting(
			"sony_footer_left_{$i}_target",
			array(
				'default'           => ! empty( $default['target'] ),
				'sanitize_callback' => 'sony_music_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			"sony_footer_left_{$i}_target",
			array(
				'label'   => sprintf( __( 'Left link %d — Open in new tab', 'sony-music' ), $i ),
				'section' => 'sony_music_footer',
				'type'    => 'checkbox',
			)
		);
	}

	$right_defaults = sony_music_default_footer_right_links();

	for ( $i = 1; $i <= 2; $i++ ) {
		$default = isset( $right_defaults[ $i - 1 ] ) ? $right_defaults[ $i - 1 ] : array(
			'label' => '',
			'url'   => '',
		);

		$wp_customize->add_setting(
			"sony_footer_right_{$i}_label",
			array(
				'default'           => $default['label'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"sony_footer_right_{$i}_label",
			array(
				'label'   => sprintf( __( 'Right link %d — Label', 'sony-music' ), $i ),
				'section' => 'sony_music_footer',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"sony_footer_right_{$i}_url",
			array(
				'default'           => $default['url'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			"sony_footer_right_{$i}_url",
			array(
				'label'   => sprintf( __( 'Right link %d — URL', 'sony-music' ), $i ),
				'section' => 'sony_music_footer',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_footer_customize_register', 20 );
