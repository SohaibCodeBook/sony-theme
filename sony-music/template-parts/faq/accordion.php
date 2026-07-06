<?php
/**
 * FAQ accordion block.
 *
 * @package Sony_Music
 *
 * @var array $args Template arguments.
 */

defined( 'ABSPATH' ) || exit;

$page_title = isset( $args['page_title'] ) ? $args['page_title'] : 'FAQ';
$items      = isset( $args['items'] ) ? $args['items'] : array();
?>

<article class="inner-content faq-container">
	<div class="container">
		<div class="page-title"><?php echo esc_html( $page_title ); ?></div>
	</div>

	<div class="faq-accordion-wrap">
		<div class="container">
			<div class="block-accordion faq-accordion">
				<div class="accordion-wrapper">
					<?php foreach ( $items as $item ) : ?>
						<div class="accordion-section">
							<div class="accordion-section__title" role="button" tabindex="0" aria-expanded="false">
								<span><?php echo esc_html( $item['question'] ); ?></span>
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
