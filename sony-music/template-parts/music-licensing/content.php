<?php
/**
 * Music Licensing page content.
 *
 * @package Sony_Music
 *
 * @var array $args Template arguments.
 */

defined( 'ABSPATH' ) || exit;

$page_title       = isset( $args['page_title'] ) ? $args['page_title'] : 'Music Licensing';
$banner_image     = isset( $args['banner_image'] ) ? $args['banner_image'] : '';
$banner_alt       = isset( $args['banner_alt'] ) ? $args['banner_alt'] : 'Music Licensing';
$intro_heading    = isset( $args['intro_heading'] ) ? $args['intro_heading'] : '';
$intro_items      = isset( $args['intro_items'] ) ? $args['intro_items'] : array();
$sections         = isset( $args['sections'] ) ? $args['sections'] : array();
$about_heading    = isset( $args['about_heading'] ) ? $args['about_heading'] : 'About us';
$about_paragraphs = isset( $args['about_paragraphs'] ) ? $args['about_paragraphs'] : array();
$about_image      = isset( $args['about_image'] ) ? $args['about_image'] : '';
$about_image_alt  = isset( $args['about_image_alt'] ) ? $args['about_image_alt'] : '';
?>

<article class="inner-content licensing-container">
	<div class="container">
		<div class="page-title"><?php echo esc_html( $page_title ); ?></div>
	</div>

	<?php if ( $banner_image ) : ?>
		<figure class="licensing-banner wp-block-image alignfull size-large">
			<img src="<?php echo esc_url( $banner_image ); ?>" alt="<?php echo esc_attr( $banner_alt ); ?>" loading="eager" decoding="async">
		</figure>
	<?php endif; ?>

	<div class="licensing-body alignwide">
		<div class="licensing-spacer licensing-spacer--20" aria-hidden="true"></div>

		<?php if ( $intro_heading ) : ?>
			<p class="licensing-intro-heading"><?php echo wp_kses_post( $intro_heading ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $intro_items ) ) : ?>
			<ul class="licensing-intro-list wp-block-list">
				<?php foreach ( $intro_items as $item ) : ?>
					<li><?php echo wp_kses_post( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<div class="licensing-spacer licensing-spacer--71" aria-hidden="true"></div>

		<div class="block-accordion licensing-accordion accordion-black accordion-black-bg-white-lines">
			<div class="accordion-wrapper">
				<?php foreach ( $sections as $section_index => $section ) : ?>
					<div class="accordion-section">
						<div class="accordion-section__title" role="button" tabindex="0" aria-expanded="false">
							<span><?php echo esc_html( isset( $section['title'] ) ? $section['title'] : '' ); ?></span>
							<span class="accordion-section__nav">
								<i aria-hidden="true"></i>
							</span>
						</div>
						<div class="accordion-section__content" hidden>
							<?php if ( ! empty( $section['intro'] ) ) : ?>
								<div class="licensing-section-intro">
									<?php echo wp_kses_post( $section['intro'] ); ?>
								</div>
							<?php endif; ?>

							<?php
							if ( ! empty( $section['form'] ) ) {
								sony_music_render_licensing_form(
									$section['form'],
									'licensing-form-' . (int) $section_index
								);
							}
							?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="licensing-spacer licensing-spacer--78" aria-hidden="true"></div>

		<section class="licensing-about">
			<h2 class="licensing-about__title"><strong><?php echo esc_html( $about_heading ); ?></strong></h2>

			<div class="licensing-spacer licensing-spacer--18" aria-hidden="true"></div>

			<?php foreach ( $about_paragraphs as $paragraph ) : ?>
				<p class="licensing-about__text wp-block-paragraph"><?php echo wp_kses_post( $paragraph ); ?></p>
			<?php endforeach; ?>

			<?php if ( $about_image ) : ?>
				<div class="licensing-spacer licensing-spacer--30" aria-hidden="true"></div>
				<figure class="licensing-about__image aligncenter size-large is-resized">
					<img src="<?php echo esc_url( $about_image ); ?>" alt="<?php echo esc_attr( $about_image_alt ); ?>" loading="lazy" decoding="async">
				</figure>
			<?php endif; ?>
		</section>
	</div>
</article>
