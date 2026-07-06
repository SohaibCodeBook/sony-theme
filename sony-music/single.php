<?php
/**
 * Single post template.
 *
 * @package Sony_Music
 */

get_header();
?>

<main id="main" class="container py-5">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article <?php post_class(); ?>>
			<h1 class="h2"><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
