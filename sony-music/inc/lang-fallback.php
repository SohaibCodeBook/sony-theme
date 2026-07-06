<?php
/**
 * Language menu fallback matching sonymusic.eu defaults.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Fallback language menu.
 */
function sony_music_lang_fallback() {
	$lang_label     = site_data( 'lang_label' ) ?: 'EN';
	$lang_url       = site_data( 'lang_url' ) ?: home_url( '/' );
	$lang_alt_label = site_data( 'lang_alt_label' ) ?: 'DE';
	$lang_alt_url   = site_data( 'lang_alt_url' ) ?: 'https://www.sonymusic.de';
	?>
	<nav class="menu-lang-menu-container">
		<ul id="menu-lang-menu" class="menu">
			<li class="menu-item current-menu-item">
				<a href="<?php echo esc_url( $lang_url ); ?>" aria-current="page"><?php echo esc_html( $lang_label ); ?></a>
			</li>
			<li class="menu-item">
				<a href="<?php echo esc_url( $lang_alt_url ); ?>"><?php echo esc_html( $lang_alt_label ); ?></a>
			</li>
		</ul>
	</nav>
	<?php
}
