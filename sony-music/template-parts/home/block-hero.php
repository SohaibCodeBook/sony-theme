<?php
/**
 * Homepage hero news slider template.
 *
 * @package Sony_Music
 *
 * @var array $args Template arguments.
 */

defined( 'ABSPATH' ) || exit;

// WordPress may pass slides via extract() or $args (get_template_part third param).
if ( ! isset( $slides ) || empty( $slides ) ) {
	if ( isset( $args ) && is_array( $args ) && ! empty( $args['slides'] ) ) {
		$slides = $args['slides'];
	} else {
		$slides = sony_music_get_hero_slides();
	}
}

if ( empty( $slides ) ) {
	return;
}
?>

<div class="block-hero">
	<div class="slider-container">
		<div class="slider" id="hero-news-slider" data-autoplay="<?php echo esc_attr( page_home( 'hero_autoplay', 4000 ) ); ?>" data-speed="<?php echo esc_attr( page_home( 'hero_speed', 1500 ) ); ?>">
			<div class="slider-viewport">
				<div class="slider-track">
					<?php foreach ( $slides as $index => $slide ) : ?>
						<div class="slide-item<?php echo 0 === $index ? ' is-current' : ''; ?>" data-index="<?php echo esc_attr( $index ); ?>">
							<div class="slide">
								<a href="<?php echo esc_url( $slide['url'] ); ?>">
									<div class="title"><?php echo esc_html( $slide['title'] ); ?></div>
									<div class="label">
										<i><b>→</b></i>
										<span><?php echo esc_html( $slide['category'] ); ?></span>
									</div>
								</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="arrows-container" aria-hidden="true">
			<div class="arrows">
				<div class="arrow" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Next slide', 'sony-music' ); ?>">
					<i><b>→</b></i>
				</div>
			</div>
		</div>
	</div>

	<div class="slider-image" id="hero-image-slider">
		<?php foreach ( $slides as $index => $slide ) : ?>
			<div
				class="slide<?php echo 0 === $index ? ' is-active' : ''; ?>"
				<?php if ( ! empty( $slide['image'] ) ) : ?>
					style="background-image:url(<?php echo esc_url( $slide['image'] ); ?>);"
				<?php endif; ?>
			></div>
		<?php endforeach; ?>
	</div>
</div>
