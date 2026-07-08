<?php
/**
 * News listing page content.
 *
 * @package Sony_Music
 *
 * @var array $args Template arguments.
 */

defined( 'ABSPATH' ) || exit;

$page_title         = isset( $args['page_title'] ) ? $args['page_title'] : 'News';
$filter_label       = isset( $args['filter_label'] ) ? $args['filter_label'] : 'Filter';
$search_placeholder = isset( $args['search_placeholder'] ) ? $args['search_placeholder'] : 'Search';
$load_more_label    = isset( $args['load_more_label'] ) ? $args['load_more_label'] : 'mehr laden';
$per_page           = isset( $args['per_page'] ) ? (int) $args['per_page'] : 12;
$categories         = isset( $args['categories'] ) ? $args['categories'] : array();
$posts              = isset( $args['posts'] ) ? $args['posts'] : array();
$total              = count( $posts );
?>

<article class="inner-content news-page">
	<div class="news-container" data-per-page="<?php echo esc_attr( (string) $per_page ); ?>">
		<div class="header-section">
			<div class="container">
				<div class="page-title"><?php echo esc_html( $page_title ); ?></div>
				<div class="filter-section">
					<div class="filter">
						<a href="#" id="news-filter-toggle" aria-expanded="false">
							<span><?php echo esc_html( $filter_label ); ?></span>
							<i id="news-filter-icon" aria-hidden="true"></i>
						</a>
					</div>
					<div class="search">
						<input
							id="search-news"
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
			<div class="filter-categories" id="news-filter-categories" hidden>
				<?php foreach ( $categories as $category ) : ?>
					<?php
					$cat_id       = isset( $category['id'] ) ? $category['id'] : '';
					$cat_label    = isset( $category['label'] ) ? $category['label'] : '';
					$has_children = ! empty( $category['has_children'] ) && ! empty( $category['children'] );
					?>
					<a
						href="#"
						class="<?php echo $has_children ? 'has-child' : ''; ?>"
						data-id="<?php echo esc_attr( $cat_id ); ?>"
						data-filter="<?php echo esc_attr( $cat_id ); ?>"
					>
						<span><?php echo esc_html( $cat_label ); ?></span>
						<?php if ( $has_children ) : ?>
							<span class="filter-plus" aria-hidden="true">+</span>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>

				<?php foreach ( $categories as $category ) : ?>
					<?php
					$cat_id       = isset( $category['id'] ) ? $category['id'] : '';
					$has_children = ! empty( $category['has_children'] ) && ! empty( $category['children'] );
					if ( ! $has_children ) {
						continue;
					}
					?>
					<div class="filter-categories__children" data-parent="<?php echo esc_attr( $cat_id ); ?>" hidden>
						<?php foreach ( $category['children'] as $child ) : ?>
							<a
								href="#"
								class="<?php echo 'year' === $cat_id ? 'year' : ''; ?>"
								data-id="<?php echo esc_attr( isset( $child['id'] ) ? $child['id'] : '' ); ?>"
								data-filter="<?php echo esc_attr( isset( $child['id'] ) ? $child['id'] : '' ); ?>"
								data-parent="<?php echo esc_attr( $cat_id ); ?>"
							><?php echo esc_html( isset( $child['label'] ) ? $child['label'] : '' ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="list-section">
				<div class="list-row" id="news-list-row">
					<?php foreach ( $posts as $index => $post ) : ?>
						<?php
						$title    = isset( $post['title'] ) ? $post['title'] : '';
						$category = isset( $post['category'] ) ? $post['category'] : '';
						$year     = isset( $post['year'] ) ? $post['year'] : '';
						$image    = isset( $post['image'] ) ? $post['image'] : '';
						$slug     = isset( $post['slug'] ) ? $post['slug'] : '';
						$cat_key  = strtolower( $category );
						$hidden   = $index >= $per_page;
						?>
						<div
							class="item<?php echo $hidden ? ' is-hidden' : ''; ?>"
							data-category="<?php echo esc_attr( $cat_key ); ?>"
							data-year="<?php echo esc_attr( $year ); ?>"
							data-title="<?php echo esc_attr( strtolower( $title ) ); ?>"
							data-index="<?php echo esc_attr( (string) $index ); ?>"
							<?php echo $hidden ? 'hidden' : ''; ?>
						>
							<a href="#" class="news-item-link" data-slug="<?php echo esc_attr( $slug ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
								<div class="item__thumb">
									<?php if ( $image ) : ?>
										<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="<?php echo $index < 4 ? 'eager' : 'lazy'; ?>" width="1024" height="1024">
									<?php endif; ?>
								</div>
								<div class="item__category">
									<span><?php echo esc_html( $category ); ?></span>
								</div>
								<div class="item__title"><?php echo esc_html( $title ); ?></div>
							</a>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ( $total > $per_page ) : ?>
					<div class="load-next" id="news-load-more">
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
