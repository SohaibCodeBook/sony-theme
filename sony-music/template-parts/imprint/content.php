<?php
/**
 * Imprint page content.
 *
 * @package Sony_Music
 *
 * @var array $args Template arguments.
 */

defined( 'ABSPATH' ) || exit;

$page_title       = isset( $args['page_title'] ) ? $args['page_title'] : 'Imprint';
$intro            = isset( $args['intro'] ) ? $args['intro'] : '';
$company_meta     = isset( $args['company_meta'] ) ? $args['company_meta'] : '';
$contact_note     = isset( $args['contact_note'] ) ? $args['contact_note'] : '';
$copyright        = isset( $args['copyright'] ) ? $args['copyright'] : '';
$consent          = isset( $args['consent'] ) ? $args['consent'] : '';
$copyright_notice = isset( $args['copyright_notice'] ) ? $args['copyright_notice'] : '';
$sections         = isset( $args['sections'] ) ? $args['sections'] : array();

$allowed = array(
	'a'  => array(
		'href' => true,
	),
	'br' => array(),
);
?>

<article class="inner-content imprint-page">
	<div class="container">
		<div class="page-title"><?php echo esc_html( $page_title ); ?></div>
	</div>

	<div class="block-imprint">
		<div class="container">
			<?php if ( $intro ) : ?>
				<p><?php echo wp_kses( $intro, $allowed ); ?></p>
			<?php endif; ?>

			<?php if ( $company_meta || $contact_note || $copyright || $consent || $copyright_notice ) : ?>
				<p>
					<?php if ( $company_meta ) : ?>
						<?php echo wp_kses( $company_meta, $allowed ); ?><br><br>
					<?php endif; ?>
					<?php if ( $contact_note ) : ?>
						<?php echo esc_html( $contact_note ); ?><br><br>
					<?php endif; ?>
					<?php if ( $copyright ) : ?>
						<?php echo esc_html( $copyright ); ?><br><br>
					<?php endif; ?>
					<?php if ( $consent ) : ?>
						<?php echo esc_html( $consent ); ?><br><br>
					<?php endif; ?>
					<?php if ( $copyright_notice ) : ?>
						<?php echo esc_html( $copyright_notice ); ?>
					<?php endif; ?>
				</p>
			<?php endif; ?>

			<?php foreach ( $sections as $section ) : ?>
				<?php
				$title = isset( $section['title'] ) ? $section['title'] : '';
				$body  = isset( $section['body'] ) ? $section['body'] : '';
				if ( ! $title && ! $body ) {
					continue;
				}
				?>
				<?php if ( $title ) : ?>
					<h4><?php echo esc_html( $title ); ?></h4>
				<?php endif; ?>
				<?php if ( $body ) : ?>
					<h4><?php echo esc_html( $body ); ?></h4>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</article>
