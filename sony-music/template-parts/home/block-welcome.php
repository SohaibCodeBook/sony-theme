<?php
/**
 * Welcome section template.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $gallery ) || ! isset( $links ) ) {
	if ( isset( $args ) && is_array( $args ) ) {
		$gallery = isset( $args['gallery'] ) ? $args['gallery'] : sony_music_get_welcome_gallery();
		$links   = isset( $args['links'] ) ? $args['links'] : sony_music_get_welcome_links();
	} else {
		$gallery = sony_music_get_welcome_gallery();
		$links   = sony_music_get_welcome_links();
	}
}

$title = page_home( 'welcome_title', 'Welcome to Sony Music' );
?>

<?php if ( ! empty( $gallery ) ) : ?>
<section class="section-welcome">
	<div class="section-welcome__inner">
		<?php if ( $title ) : ?>
			<p class="section-welcome__title"><?php echo esc_html( $title ); ?></p>
		<?php endif; ?>

		<div class="section-welcome__gallery">
			<?php foreach ( $gallery as $index => $image ) : ?>
				<?php
				$item_class = 'section-welcome__gallery-item';
				if ( 3 === $index ) {
					$item_class .= ' section-welcome__gallery-item--wide';
				}
				?>
				<figure class="<?php echo esc_attr( $item_class ); ?>">
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php if ( ! empty( $links ) ) : ?>
<section class="section-welcome-cta">
	<div class="section-welcome-cta__inner">
		<div class="block-cta">
			<div class="cta-wrapper">
				<?php foreach ( $links as $link ) : ?>
					<div class="cta-item">
						<div class="cta-item__title">
							<a href="<?php echo esc_url( $link['url'] ); ?>">
								<span><?php echo esc_html( $link['label'] ); ?></span>
								<span class="cta-item__nav" aria-hidden="true">→</span>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
