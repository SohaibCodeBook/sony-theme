<?php
/**
 * Contact page content.
 *
 * @package Sony_Music
 *
 * @var array $args Template arguments.
 */

defined( 'ABSPATH' ) || exit;

$page_title      = isset( $args['page_title'] ) ? $args['page_title'] : 'Contact';
$office_berlin   = isset( $args['office_berlin'] ) ? $args['office_berlin'] : '';
$office_munich   = isset( $args['office_munich'] ) ? $args['office_munich'] : '';
$accordion_items = isset( $args['accordion_items'] ) ? $args['accordion_items'] : array();
?>

<article class="inner-content contact-container">
	<div class="container">
		<div class="page-title"><?php echo esc_html( $page_title ); ?></div>
	</div>

	<div class="contact-content-wrap">
		<div class="container">
			<div class="contact-offices">
				<?php echo wp_kses_post( $office_berlin ); ?>
				<div class="contact-spacer" aria-hidden="true"></div>
				<?php echo wp_kses_post( $office_munich ); ?>
			</div>

			<div class="block-accordion contact-accordion">
				<div class="accordion-wrapper">
					<?php foreach ( $accordion_items as $item ) : ?>
						<div class="accordion-section">
							<div class="accordion-section__title" role="button" tabindex="0" aria-expanded="false">
								<span><?php echo esc_html( $item['title'] ); ?></span>
								<span class="accordion-section__nav">
									<i aria-hidden="true"></i>
								</span>
							</div>
							<div class="accordion-section__content" hidden>
								<?php echo wp_kses_post( $item['answer'] ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</article>
