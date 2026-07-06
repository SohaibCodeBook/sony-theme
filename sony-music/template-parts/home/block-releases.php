<?php
/**
 * New Releases block slider template.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $slides ) || empty( $slides ) ) {
	if ( isset( $args ) && is_array( $args ) && ! empty( $args['slides'] ) ) {
		$slides = $args['slides'];
	} else {
		$slides = sony_music_get_releases_slides();
	}
}

if ( empty( $slides ) ) {
	return;
}

$total       = count( $slides );
$title_line1 = page_home( 'releases_title_1', 'New' );
$title_line2 = page_home( 'releases_title_2', 'Releases' );
$speed       = (int) page_home( 'releases_speed', 1500 );
?>

<section class="section-releases">
	<div class="section-releases__inner">
		<div id="block-slider-releases" class="block-slider default" data-speed="<?php echo esc_attr( $speed ); ?>">
			<div class="info-side">
				<div class="title">
					<?php echo esc_html( $title_line1 ); ?><br>
					<?php echo esc_html( $title_line2 ); ?>
				</div>

				<div class="slide-info">
					<div class="slider-text" id="slider-text-releases">
						<div class="slider-viewport">
							<div class="slider-track">
								<?php foreach ( $slides as $slide ) : ?>
									<div class="slide-item">
										<div class="slide">
											<div class="slide-text">
												<p>
													<?php echo esc_html( $slide['artist'] ); ?><br>
													&ldquo;<a href="<?php echo esc_url( $slide['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $slide['release'] ); ?></a>&rdquo;
												</p>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="slider-controls">
						<div class="slider-page" id="slider-page-releases">
							<div class="slider-viewport">
								<div class="slider-track">
									<?php for ( $i = 1; $i <= $total; $i++ ) : ?>
										<div class="slide-item">
											<div class="slide"><?php echo esc_html( $i . '/' . $total ); ?></div>
										</div>
									<?php endfor; ?>
								</div>
							</div>
						</div>

						<div class="slider-nav" id="slider-nav-releases">
							<a href="#" class="btn-next" aria-label="<?php esc_attr_e( 'Next release', 'sony-music' ); ?>">→</a>
						</div>
					</div>
				</div>
			</div>

			<div class="image-side">
				<div class="slider-image" id="slider-image-releases">
					<div class="slider-viewport">
						<div class="slider-track">
							<?php foreach ( $slides as $slide ) : ?>
								<div class="slide-item">
									<div class="slide">
										<?php if ( ! empty( $slide['image'] ) ) : ?>
											<img src="<?php echo esc_url( $slide['image'] ); ?>" alt="<?php echo esc_attr( $slide['artist'] . ' — ' . $slide['release'] ); ?>" loading="lazy">
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
