<?php
/**
 * Front page template.
 *
 * @package Sony_Music
 */

get_header();
?>

<main id="main">
	<?php sony_music_render_block_hero(); ?>
	<?php sony_music_render_block_releases(); ?>
</main>

<?php
get_footer();
