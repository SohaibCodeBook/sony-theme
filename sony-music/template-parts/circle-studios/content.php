<?php
/**
 * Circle Studios page content.
 *
 * @package Sony_Music
 *
 * @var array $args Template arguments.
 */

defined( 'ABSPATH' ) || exit;

$page_title = isset( $args['page_title'] ) ? $args['page_title'] : 'Circle Studios';
$headline   = isset( $args['headline'] ) ? $args['headline'] : '';
$body       = isset( $args['body'] ) ? $args['body'] : '';
$link_url   = isset( $args['link_url'] ) ? $args['link_url'] : '';
$link_label = isset( $args['link_label'] ) ? $args['link_label'] : '';
$image      = isset( $args['image'] ) ? $args['image'] : '';
$image_alt  = isset( $args['image_alt'] ) ? $args['image_alt'] : '';
?>

<article class="inner-content circle-studios-container">
	<div class="container">
		<div class="page-title"><?php echo esc_html( $page_title ); ?></div>
	</div>

	<div class="circle-studios-content">
		<div class="circle-studios-inner">
			<?php if ( $headline ) : ?>
				<h1 class="circle-studios-headline"><?php echo esc_html( $headline ); ?></h1>
			<?php endif; ?>

			<?php if ( $body ) : ?>
				<h2 class="circle-studios-body"><?php echo esc_html( $body ); ?></h2>
			<?php endif; ?>

			<?php if ( $link_url && $link_label ) : ?>
				<p class="circle-studios-link">
					<a href="<?php echo esc_url( $link_url ); ?>" target="_blank" rel="noreferrer noopener"><?php echo esc_html( $link_label ); ?></a>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( $image ) : ?>
			<figure class="circle-studios-image aligncenter size-large">
				<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy" decoding="async">
			</figure>
		<?php endif; ?>
	</div>
</article>
