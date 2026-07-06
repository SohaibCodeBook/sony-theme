<?php
/**
 * New Videos block slider template.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $slides ) || empty( $slides ) ) {
	if ( isset( $args ) && is_array( $args ) && ! empty( $args['slides'] ) ) {
		$slides = $args['slides'];
	} else {
		$slides = sony_music_get_videos_slides();
	}
}

if ( empty( $slides ) ) {
	return;
}

$total       = count( $slides );
$title_line1 = page_home( 'videos_title_1', 'New' );
$title_line2 = page_home( 'videos_title_2', 'Videos' );
$speed       = (int) page_home( 'videos_speed', 1500 );
?>

<section class="section-videos">
	<div class="section-videos__inner">
		<div id="block-slider-videos" class="block-slider reverse" data-slider-id="videos" data-speed="<?php echo esc_attr( $speed ); ?>">
			<div class="info-side">
				<div class="title">
					<?php echo esc_html( $title_line1 ); ?><br>
					<?php echo esc_html( $title_line2 ); ?>
				</div>

				<div class="slide-info">
					<div class="slider-text" id="slider-text-videos">
						<div class="slider-viewport">
							<div class="slider-track">
								<?php foreach ( $slides as $slide ) : ?>
									<div class="slide-item">
										<div class="slide">
											<div class="slide-text">
												<p>
													<?php echo esc_html( $slide['artist'] ); ?><br>
													&lsquo;<?php echo esc_html( $slide['title'] ); ?>&rsquo;
												</p>
											</div>
											<div class="slide-btn">
												<a class="btn" href="<?php echo esc_url( $slide['video_url'] ); ?>" data-type="video">
													<?php esc_html_e( 'Play', 'sony-music' ); ?>
												</a>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="slider-controls">
						<div class="slider-page" id="slider-page-videos">
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

						<div class="slider-nav" id="slider-nav-videos">
							<a href="#" class="btn-next" aria-label="<?php esc_attr_e( 'Next video', 'sony-music' ); ?>">→</a>
						</div>
					</div>
				</div>
			</div>

			<div class="image-side">
				<div class="slider-image" id="slider-image-videos">
					<div class="slider-viewport">
						<div class="slider-track">
							<?php foreach ( $slides as $slide ) : ?>
								<div class="slide-item">
									<div class="slide">
										<?php if ( ! empty( $slide['image'] ) ) : ?>
											<img src="<?php echo esc_url( $slide['image'] ); ?>" alt="<?php echo esc_attr( $slide['artist'] . ' — ' . $slide['title'] ); ?>" loading="lazy">
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="slider-video-wrapper-videos" class="slider-video-wrapper" style="display:none;">
			<div class="video-wrapper"></div>
			<button type="button" class="video-close" aria-label="<?php esc_attr_e( 'Close video', 'sony-music' ); ?>">&times;</button>
		</div>
	</div>
</section>
