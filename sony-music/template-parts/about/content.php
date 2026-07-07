<?php
/**
 * About page content.
 *
 * @package Sony_Music
 *
 * @var array $args Template arguments.
 */

defined( 'ABSPATH' ) || exit;

$page_title   = isset( $args['page_title'] ) ? $args['page_title'] : 'About';
$headline     = isset( $args['headline'] ) ? $args['headline'] : '';
$intro        = isset( $args['intro'] ) ? $args['intro'] : '';
$ceo_image    = isset( $args['ceo_image'] ) ? $args['ceo_image'] : '';
$ceo_alt      = isset( $args['ceo_alt'] ) ? $args['ceo_alt'] : '';
$ceo_text     = isset( $args['ceo_text'] ) ? $args['ceo_text'] : '';
$facade_image = isset( $args['facade_image'] ) ? $args['facade_image'] : '';
$facade_alt   = isset( $args['facade_alt'] ) ? $args['facade_alt'] : '';
$sections     = isset( $args['sections'] ) ? $args['sections'] : array();
?>

<article class="inner-content about-container">
	<div class="container">
		<div class="page-title"><?php echo esc_html( $page_title ); ?></div>
	</div>

	<div class="about-content-wrap">
		<div class="container">
			<?php if ( $headline ) : ?>
				<h1 class="about-headline"><?php echo esc_html( $headline ); ?></h1>
			<?php endif; ?>

			<?php if ( $intro ) : ?>
				<div class="about-intro"><?php echo wp_kses_post( $intro ); ?></div>
			<?php endif; ?>

			<div class="about-ceo-grid">
				<?php if ( $ceo_image ) : ?>
					<div class="about-ceo-grid__image">
						<figure class="about-figure">
							<img src="<?php echo esc_url( $ceo_image ); ?>" alt="<?php echo esc_attr( $ceo_alt ); ?>" loading="lazy" decoding="async">
						</figure>
					</div>
				<?php endif; ?>

				<?php if ( $ceo_text ) : ?>
					<div class="about-ceo-grid__text">
						<p><?php echo esc_html( $ceo_text ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<?php foreach ( $sections as $index => $section ) : ?>
				<?php if ( 0 === (int) $index ) : ?>
					<section class="about-section about-section--divisions">
						<?php if ( ! empty( $section['title'] ) ) : ?>
							<h2 class="about-section__title"><?php echo esc_html( $section['title'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $section['items'] ) ) : ?>
							<?php get_template_part( 'template-parts/about/accordion', null, array( 'items' => $section['items'] ) ); ?>
						<?php endif; ?>
					</section>

					<div class="about-spacer" aria-hidden="true"></div>

					<?php if ( $facade_image ) : ?>
						<figure class="about-facade">
							<img src="<?php echo esc_url( $facade_image ); ?>" alt="<?php echo esc_attr( $facade_alt ); ?>" loading="lazy" decoding="async">
						</figure>
					<?php endif; ?>
				<?php else : ?>
					<section class="about-section about-section--labels">
						<?php if ( ! empty( $section['title'] ) ) : ?>
							<h2 class="about-section__title"><?php echo esc_html( $section['title'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $section['items'] ) ) : ?>
							<?php get_template_part( 'template-parts/about/accordion', null, array( 'items' => $section['items'] ) ); ?>
						<?php endif; ?>
					</section>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</article>
