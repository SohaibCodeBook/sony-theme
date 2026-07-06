<?php
/**
 * Career jobs listing template.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $jobs ) || ! isset( $filters ) ) {
	if ( isset( $args ) && is_array( $args ) ) {
		$jobs    = isset( $args['jobs'] ) ? $args['jobs'] : sony_music_get_career_jobs();
		$filters = isset( $args['filters'] ) ? $args['filters'] : sony_music_default_career_filters();
	} else {
		$jobs    = sony_music_get_career_jobs();
		$filters = sony_music_default_career_filters();
	}
}

$page_title          = page_career( 'page_title', 'Jobs' );
$search_placeholder  = page_career( 'search_placeholder', 'Suche' );
$faq_url             = sony_music_career_faq_url();
$mission_text        = page_career( 'mission_text', "You belong. At Sony Music.\nUnser Ziel ist es, so vielfältig zu sein wie unsere Artists. So bunt wie unsere Audiences. So divers wie alle Musikliebenden.\nWir wollen als kulturschaffendes Musikunternehmen eine Realität gestalten, in der sich alle Talente als sie selbst und diskriminierungsfrei entfalten können.\nAlso komm zu uns. Mit deiner Vielfalt.\nBring your Influence." );
$mission_lines       = preg_split( '/\r\n|\r|\n/', $mission_text );
$filter_groups       = array(
	'departments' => array(
		'id'    => '56',
		'label' => __( 'Departments', 'sony-music' ),
		'key'   => 'departments',
	),
	'location'    => array(
		'id'    => '60',
		'label' => __( 'Location', 'sony-music' ),
		'key'   => 'location',
	),
	'type'        => array(
		'id'    => '58',
		'label' => __( 'Type', 'sony-music' ),
		'key'   => 'type',
	),
);
?>

<article class="inner-content">
	<div class="jobs-container">
		<div class="header-section">
			<div class="container">
				<div class="page-title"><?php echo esc_html( $page_title ); ?></div>

				<div class="filter-section" data-base-url="<?php echo esc_url( get_permalink() ); ?>">
					<div class="filter">
						<a href="#" id="career-filter-toggle" aria-expanded="false" aria-controls="career-filter-categories">
							<span><?php esc_html_e( 'Filter', 'sony-music' ); ?></span>
							<i aria-hidden="true"></i>
						</a>
					</div>
					<div class="search">
						<label class="screen-reader-text" for="search-jobs"><?php echo esc_html( $search_placeholder ); ?></label>
						<input id="search-jobs" type="search" name="search" placeholder="<?php echo esc_attr( $search_placeholder ); ?>" aria-label="<?php echo esc_attr( $search_placeholder ); ?>">
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="filter-categories" id="career-filter-categories">
				<?php foreach ( $filter_groups as $group ) : ?>
					<a class="has-child" href="#" data-id="<?php echo esc_attr( $group['id'] ); ?>" data-filter-group="<?php echo esc_attr( $group['key'] ); ?>">
						<span><?php echo esc_html( $group['label'] ); ?></span>
						<i class="filter-category-icon" aria-hidden="true">+</i>
					</a>
				<?php endforeach; ?>

				<?php foreach ( $filter_groups as $group ) : ?>
					<?php if ( empty( $filters[ $group['key'] ] ) ) : ?>
						<?php continue; ?>
					<?php endif; ?>
					<div class="filter-categories__children" id="children-<?php echo esc_attr( $group['id'] ); ?>" data-filter-group="<?php echo esc_attr( $group['key'] ); ?>">
						<?php foreach ( $filters[ $group['key'] ] as $filter_item ) : ?>
							<a href="#" data-id="<?php echo esc_attr( $filter_item['id'] ); ?>" data-filter-group="<?php echo esc_attr( $group['key'] ); ?>">
								<?php echo esc_html( $filter_item['label'] ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="list-section" id="career-job-list">
				<?php foreach ( $jobs as $job ) : ?>
					<?php
					$dept_attr = ! empty( $job['departments'] ) ? implode( ' ', array_map( 'esc_attr', $job['departments'] ) ) : '';
					?>
					<div class="item" data-departments="<?php echo esc_attr( $dept_attr ); ?>" data-type="<?php echo esc_attr( $job['type'] ); ?>" data-location="176">
						<div class="item__title">
							<a href="<?php echo esc_url( $job['url'] ); ?>">
								<span class="arrow" aria-hidden="true">→</span>
								<?php echo esc_html( $job['title'] ); ?>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="container">
			<div class="block-cta">
				<div class="cta-wrapper">
					<div class="cta-item">
						<div class="cta-item__title">
							<a href="<?php echo esc_url( $faq_url ); ?>">
								<span><?php esc_html_e( 'FAQ', 'sony-music' ); ?></span>
								<span class="cta-item__nav" aria-hidden="true">→</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>

<button type="button" class="mission-ball" id="mission-ball" aria-haspopup="dialog">
	<?php esc_html_e( 'Bring your Influence', 'sony-music' ); ?>
</button>

<div id="mission-modal" class="mission-modal" role="dialog" aria-modal="true" aria-labelledby="mission-modal-title" hidden>
	<div class="mission-modal__inner">
		<button type="button" class="mission-modal__close" id="mission-modal-close" aria-label="<?php esc_attr_e( 'Close', 'sony-music' ); ?>">&times;</button>
		<div class="message notranslate" id="mission-modal-title">
			<?php foreach ( $mission_lines as $index => $line ) : ?>
				<?php
				$line = trim( $line );
				if ( '' === $line ) {
					continue;
				}
				$is_highlight = ( 0 === $index ) || ( $index === count( $mission_lines ) - 1 );
				?>
				<?php if ( $is_highlight ) : ?>
					<span class="text-white"><?php echo esc_html( $line ); ?></span><br>
				<?php else : ?>
					<?php echo esc_html( $line ); ?><br>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<div class="mission-modal-backdrop" id="mission-modal-backdrop" hidden></div>
