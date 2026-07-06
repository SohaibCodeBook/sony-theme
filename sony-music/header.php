<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main" class="sr-only"><?php esc_html_e( 'Skip to content', 'sony-music' ); ?></a>

<header id="header">
	<?php if ( site_data( 'show_topbar' ) ) : ?>
	<div id="header-topbar">
		<div class="container">
			<?php sony_music_topbar_logo(); ?>
		</div>
	</div>
	<?php endif; ?>

	<div id="header-main">
		<div class="container">
			<div id="header-main-wrapper">
				<?php sony_music_logo(); ?>

				<div class="header-controls">
					<div class="top-search" id="top-search">
						<button type="button" id="search-toggle" aria-label="<?php esc_attr_e( 'Toggle search', 'sony-music' ); ?>" aria-expanded="false">
							<i class="fa-regular fa-magnifying-glass" aria-hidden="true"></i>
						</button>
						<input
							type="text"
							name="s"
							id="ts-search"
							placeholder="<?php echo esc_attr( site_data( 'search_placeholder' ) ?: 'Search' ); ?>"
							aria-label="<?php echo esc_attr( site_data( 'search_placeholder' ) ?: 'Search' ); ?>"
							autocomplete="off"
						>
						<div class="top-search-results" id="top-search-results" aria-live="polite"></div>
					</div>

					<div class="menu-lang" id="menu-lang">
						<?php
						if ( has_nav_menu( 'lang' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'lang',
									'container'      => 'nav',
									'container_class'=> 'menu-lang-menu-container',
									'menu_class'     => 'menu',
									'depth'          => 1,
									'fallback_cb'    => 'sony_music_lang_fallback',
								)
							);
						} else {
							sony_music_lang_fallback();
						}
						?>
					</div>

					<button type="button" class="nav-toggle" id="nav-toggle" aria-label="<?php esc_attr_e( 'Toggle Menu', 'sony-music' ); ?>" aria-expanded="false"></button>
				</div>
			</div>
		</div>
	</div>
</header>

<div id="offcanvas-nav" aria-hidden="true">
	<div class="offcanvas-nav__header">
		<?php sony_music_logo(); ?>
	</div>
	<div class="nav-container">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => 'nav',
					'menu_class'     => 'menu offcanvas-menu',
					'depth'          => 2,
					'fallback_cb'    => false,
				)
			);
		}
		?>
	</div>
</div>
