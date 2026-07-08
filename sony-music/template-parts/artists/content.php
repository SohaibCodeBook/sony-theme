<?php
/**
 * Artists listing page content.
 *
 * @package Sony_Music
 *
 * @var array $args Template arguments.
 */

defined( 'ABSPATH' ) || exit;

$page_title         = isset( $args['page_title'] ) ? $args['page_title'] : 'Artists';
$filter_label       = isset( $args['filter_label'] ) ? $args['filter_label'] : 'Filter';
$search_placeholder = isset( $args['search_placeholder'] ) ? $args['search_placeholder'] : 'Search';
$load_more_label    = isset( $args['load_more_label'] ) ? $args['load_more_label'] : 'mehr laden';
$per_page           = isset( $args['per_page'] ) ? (int) $args['per_page'] : 30;
$labels             = isset( $args['labels'] ) ? $args['labels'] : array();
$artists            = isset( $args['artists'] ) ? $args['artists'] : array();
$total              = count( $artists );
?>

<article class="inner-content artists-page">
	<div class="artists-container" data-per-page="<?php echo esc_attr( (string) $per_page ); ?>">
		<div class="header-section">
			<div class="container">
				<div class="page-title"><?php echo esc_html( $page_title ); ?></div>
				<div class="filter-section">
					<div class="filter">
						<a href="#" id="artists-filter-toggle" aria-expanded="false">
							<span><?php echo esc_html( $filter_label ); ?></span>
							<i id="artists-filter-icon" aria-hidden="true"></i>
						</a>
					</div>
					<div class="search">
						<input
							id="search-artists"
							type="search"
							name="search"
							placeholder="<?php echo esc_attr( $search_placeholder ); ?>"
							aria-label="<?php echo esc_attr( $search_placeholder ); ?>"
						>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="filter-categories" id="artists-filter-categories" hidden>
				<a href="#" class="has-child" data-filter="label" id="artists-label-toggle">
					<span>Label</span>
					<span class="filter-plus" aria-hidden="true">+</span>
				</a>
				<div class="filter-categories__children" data-parent="label" hidden>
					<?php foreach ( $labels as $label ) : ?>
						<a
							href="#"
							data-filter="<?php echo esc_attr( isset( $label['id'] ) ? $label['id'] : '' ); ?>"
							data-parent="label"
						><?php echo esc_html( isset( $label['label'] ) ? $label['label'] : '' ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="list-section">
				<div class="artists-list" id="artists-list">
					<?php foreach ( $artists as $index => $artist ) : ?>
						<?php
						$name   = isset( $artist['name'] ) ? $artist['name'] : '';
						$letter = isset( $artist['letter'] ) ? $artist['letter'] : '';
						$image  = isset( $artist['image'] ) ? $artist['image'] : '';
						$slug   = isset( $artist['slug'] ) ? $artist['slug'] : '';
						$grouped = '' !== $letter;
						$hidden  = $index >= $per_page;
						?>
						<div
							class="item<?php echo $grouped ? ' grouped' : ''; ?><?php echo $hidden ? ' is-hidden' : ''; ?>"
							data-name="<?php echo esc_attr( strtolower( $name ) ); ?>"
							data-index="<?php echo esc_attr( (string) $index ); ?>"
							<?php echo $hidden ? 'hidden' : ''; ?>
						>
							<?php if ( $grouped ) : ?>
								<div class="item__group notranslate"><?php echo esc_html( $letter ); ?></div>
							<?php endif; ?>
							<div class="item__title">
								<a href="#" class="artist-item-link" data-slug="<?php echo esc_attr( $slug ); ?>" aria-label="<?php echo esc_attr( $name ); ?>">
									<i aria-hidden="true">→</i>
									<span class="notranslate"><?php echo esc_html( $name ); ?></span>
								</a>
							</div>
							<?php if ( $image ) : ?>
								<div class="item__thumb">
									<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy" width="640" height="640">
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ( $total > $per_page ) : ?>
					<div class="load-next" id="artists-load-more">
						<a href="#" class="load-next__link" aria-label="<?php echo esc_attr( $load_more_label ); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" viewBox="0 0 65 65" aria-hidden="true">
								<g fill="none" fill-rule="evenodd">
									<path stroke="#1D1D1B" stroke-width="2.5" d="M0 29C.325 17.89 7 7.406 18.049 2.584 32.566-3.75 49.433 1.962 57 15.334" transform="translate(2 2)"/>
									<path fill="#1D1D1B" d="M44 14.292L44.617 11.904 56.388 14.952 58.573 3 61 3.446 58.336 18z" transform="translate(2 2)"/>
									<path stroke="#1D1D1B" stroke-width="2.5" d="M61 33c-.778 10.736-7.366 20.709-18.004 25.392C28.462 64.786 11.573 59.017 4 45.519" transform="translate(2 2)"/>
									<path fill="#1D1D1B" d="M17 46.708L16.383 49.096 4.612 46.048 2.427 58 0 57.554 2.664 43z" transform="translate(2 2)"/>
								</g>
							</svg>
							<span><?php echo esc_html( $load_more_label ); ?></span>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</article>
