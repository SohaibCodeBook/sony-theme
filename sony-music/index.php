<?php
/**
 * Main index template.
 *
 * @package Sony_Music
 */

get_header();
?>

<main id="main" class="container py-5">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class( 'mb-5' ); ?>>
				<h1 class="h2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No posts found.', 'sony-music' ); ?></p>
	<?php endif; ?>
</main>

<?php
get_footer();
