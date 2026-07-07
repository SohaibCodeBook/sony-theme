<?php
/**
 * About page accordion block.
 *
 * @package Sony_Music
 *
 * @var array $args Template arguments.
 */

defined( 'ABSPATH' ) || exit;

$items = isset( $args['items'] ) ? $args['items'] : array();

if ( empty( $items ) ) {
	return;
}
?>

<div class="block-accordion about-accordion">
	<div class="accordion-wrapper">
		<?php foreach ( $items as $item ) : ?>
			<div class="accordion-section">
				<div class="accordion-section__title" role="button" tabindex="0" aria-expanded="false">
					<span><?php echo esc_html( $item['title'] ); ?></span>
					<span class="accordion-section__nav">
						<i aria-hidden="true"></i>
					</span>
				</div>
				<div class="accordion-section__content" hidden>
					<?php if ( ! empty( $item['brand_image'] ) ) : ?>
						<div class="accordion-section__brand">
							<img src="<?php echo esc_url( $item['brand_image'] ); ?>" alt="<?php echo esc_attr( isset( $item['brand_alt'] ) ? $item['brand_alt'] : '' ); ?>" loading="lazy" decoding="async">
						</div>
					<?php endif; ?>
					<?php echo wp_kses_post( $item['content'] ); ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
