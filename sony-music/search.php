<?php
/**
 * Search results template.
 *
 * @package Sony_Music
 */

get_header();
?>

<main id="main" class="container py-5">
	<h1 class="h2">
		<?php
		printf(
			/* translators: %s: search query */
			esc_html__( 'Search results for: %s', 'sony-music' ),
			esc_html( get_search_query() )
		);
		?>
	</h1>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class( 'mb-4' ); ?>>
				<h2 class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No results found.', 'sony-music' ); ?></p>
	<?php endif; ?>
</main>

<?php
get_footer();
