<?php
/**
 * Music Licensing page helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

require_once SONY_MUSIC_DIR . '/inc/music-licensing-data.php';

/**
 * Music Licensing page content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_music_licensing( $key, $default = '' ) {
	return get_theme_mod( 'sony_music_licensing_' . $key, $default );
}

/**
 * Default banner image URL.
 *
 * @return string
 */
function sony_music_default_licensing_banner() {
	if ( file_exists( SONY_MUSIC_DIR . '/assets/images/music-licensing-banner.png' ) ) {
		return SONY_MUSIC_URI . '/assets/images/music-licensing-banner.png';
	}

	return 'https://cdn-p.smehost.net/sites/238402b7cfb84ff393560e5f42b4e8df/wp-content/uploads/2024/08/Banner_Sync-2-1-1024x238.png';
}

/**
 * Default about image URL.
 *
 * @return string
 */
function sony_music_default_licensing_about_image() {
	if ( file_exists( SONY_MUSIC_DIR . '/assets/images/music-licensing-about.png' ) ) {
		return SONY_MUSIC_URI . '/assets/images/music-licensing-about.png';
	}

	return 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2025/09/Bildschirmfoto-2025-05-14-um-16.26.16-1024x854.png';
}

/**
 * Default licensing guide image URL.
 *
 * @return string
 */
function sony_music_default_licensing_guide_image() {
	if ( file_exists( SONY_MUSIC_DIR . '/assets/images/licensing-guide.png' ) ) {
		return SONY_MUSIC_URI . '/assets/images/licensing-guide.png';
	}

	return 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2024/11/Licensing_Guide-300x100.png';
}

/**
 * Get Music Licensing page data.
 *
 * @return array<string, mixed>
 */
function sony_music_get_music_licensing_data() {
	$defaults     = sony_music_music_licensing_default_data();
	$banner       = page_music_licensing( 'banner_image', sony_music_default_licensing_banner() );
	$about_image  = page_music_licensing( 'about_image', sony_music_default_licensing_about_image() );
	$guide_image  = sony_music_default_licensing_guide_image();
	$sections     = isset( $defaults['sections'] ) ? $defaults['sections'] : array();

	foreach ( $sections as $index => $section ) {
		if ( isset( $section['intro'] ) ) {
			$sections[ $index ]['intro'] = str_replace( '__GUIDE_IMAGE__', esc_url( $guide_image ), $section['intro'] );
		}
	}

	return array(
		'page_title'       => page_music_licensing( 'page_title', isset( $defaults['page_title'] ) ? $defaults['page_title'] : 'Music Licensing' ),
		'banner_image'     => $banner,
		'banner_alt'       => page_music_licensing( 'banner_alt', isset( $defaults['banner_alt'] ) ? $defaults['banner_alt'] : 'Music Licensing' ),
		'intro_heading'    => page_music_licensing( 'intro_heading', isset( $defaults['intro_heading'] ) ? $defaults['intro_heading'] : '' ),
		'intro_items'      => isset( $defaults['intro_items'] ) ? $defaults['intro_items'] : array(),
		'sections'         => $sections,
		'about_heading'    => page_music_licensing( 'about_heading', isset( $defaults['about_heading'] ) ? $defaults['about_heading'] : 'About us' ),
		'about_paragraphs' => isset( $defaults['about_paragraphs'] ) ? $defaults['about_paragraphs'] : array(),
		'about_image'      => $about_image,
		'about_image_alt'  => page_music_licensing( 'about_image_alt', isset( $defaults['about_image_alt'] ) ? $defaults['about_image_alt'] : 'Music Licensing' ),
	);
}

/**
 * Render a licensing form field.
 *
 * @param array<string, mixed> $field  Field config.
 * @param string               $prefix Input name prefix.
 * @param int                  $index  Field index.
 */
function sony_music_render_licensing_field( $field, $prefix, $index ) {
	$type = isset( $field['type'] ) ? $field['type'] : 'text';
	$id   = esc_attr( $prefix . '-' . $index );
	$req  = ! empty( $field['required'] ) ? ' required aria-required="true"' : '';

	if ( 'heading' === $type ) {
		echo '<div class="licensing-form__heading">' . esc_html( isset( $field['text'] ) ? $field['text'] : '' ) . '</div>';
		return;
	}

	if ( 'note' === $type ) {
		echo '<div class="licensing-form__note">' . wp_kses_post( isset( $field['text'] ) ? $field['text'] : '' ) . '</div>';
		return;
	}

	if ( 'row' === $type && ! empty( $field['fields'] ) && is_array( $field['fields'] ) ) {
		echo '<div class="licensing-form__row">';
		foreach ( $field['fields'] as $row_index => $row_field ) {
			echo '<div class="licensing-form__col licensing-form__col--half">';
			sony_music_render_licensing_field( $row_field, $prefix, ( $index * 100 ) + $row_index );
			echo '</div>';
		}
		echo '</div>';
		return;
	}

	if ( 'name' === $type ) {
		echo '<div class="licensing-form__row licensing-form__row--name">';
		echo '<div class="licensing-form__col licensing-form__col--half">';
		printf(
			'<input type="text" id="%1$s-first" name="%2$s[first]" placeholder="%3$s"%4$s>',
			esc_attr( $id ),
			esc_attr( $prefix ),
			esc_attr( isset( $field['first_placeholder'] ) ? $field['first_placeholder'] : 'First name*' ),
			$req
		);
		echo '</div><div class="licensing-form__col licensing-form__col--half">';
		printf(
			'<input type="text" id="%1$s-last" name="%2$s[last]" placeholder="%3$s"%4$s>',
			esc_attr( $id ),
			esc_attr( $prefix ),
			esc_attr( isset( $field['last_placeholder'] ) ? $field['last_placeholder'] : 'Last name*' ),
			$req
		);
		echo '</div></div>';
		return;
	}

	if ( ! empty( $field['label'] ) ) {
		echo '<label class="licensing-form__label" for="' . esc_attr( $id ) . '">' . esc_html( $field['label'] ) . '</label>';
	}

	$placeholder = isset( $field['placeholder'] ) ? $field['placeholder'] : '';

	if ( 'textarea' === $type ) {
		printf(
			'<textarea id="%1$s" name="%2$s[%3$d]" rows="6" placeholder="%4$s"%5$s></textarea>',
			esc_attr( $id ),
			esc_attr( $prefix ),
			(int) $index,
			esc_attr( $placeholder ),
			$req
		);
		return;
	}

	if ( 'select' === $type ) {
		echo '<select id="' . esc_attr( $id ) . '" name="' . esc_attr( $prefix ) . '[' . (int) $index . ']"' . $req . '>';
		echo '<option value="">' . esc_html( $placeholder ? $placeholder : 'Please select' ) . '</option>';
		if ( ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
			foreach ( $field['options'] as $option ) {
				printf( '<option value="%1$s">%2$s</option>', esc_attr( $option ), esc_html( $option ) );
			}
		}
		echo '</select>';
		return;
	}

	$input_type = in_array( $type, array( 'email', 'url', 'tel' ), true ) ? $type : 'text';
	printf(
		'<input type="%1$s" id="%2$s" name="%3$s[%4$d]" placeholder="%5$s"%6$s>',
		esc_attr( $input_type ),
		esc_attr( $id ),
		esc_attr( $prefix ),
		(int) $index,
		esc_attr( $placeholder ),
		$req
	);
}

/**
 * Render a licensing form block.
 *
 * @param array<string, mixed> $form    Form config.
 * @param string               $form_id Unique form id.
 */
function sony_music_render_licensing_form( $form, $form_id ) {
	if ( empty( $form ) || ! is_array( $form ) ) {
		return;
	}

	$fields = isset( $form['fields'] ) ? $form['fields'] : array();
	?>
	<div class="licensing-form-wrap">
		<?php if ( ! empty( $form['required_note'] ) ) : ?>
			<p class="licensing-form__required-note"><span class="licensing-form__asterisk">*</span> indicates required fields</p>
		<?php endif; ?>

		<form class="licensing-form" id="<?php echo esc_attr( $form_id ); ?>" action="#" method="post" novalidate>
			<div class="licensing-form__fields">
				<?php
				foreach ( $fields as $index => $field ) {
					echo '<div class="licensing-form__field">';
					sony_music_render_licensing_field( $field, $form_id, $index );
					echo '</div>';
				}
				?>
			</div>
			<div class="licensing-form__footer">
				<button type="submit" class="licensing-form__submit"><?php echo esc_html( isset( $form['submit_label'] ) ? $form['submit_label'] : 'Send' ); ?></button>
			</div>
		</form>
	</div>
	<?php
}

/**
 * Render Music Licensing page.
 */
function sony_music_render_music_licensing_page() {
	get_template_part( 'template-parts/music-licensing/content', null, sony_music_get_music_licensing_data() );
}

/**
 * Register Music Licensing customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sony_music_music_licensing_customize_register( $wp_customize ) {
	$defaults = sony_music_music_licensing_default_data();

	$wp_customize->add_section(
		'sony_music_licensing',
		array(
			'title'    => __( 'Music Licensing Page', 'sony-music' ),
			'priority' => 58,
		)
	);

	$fields = array(
		'page_title'      => array( isset( $defaults['page_title'] ) ? $defaults['page_title'] : 'Music Licensing', 'text' ),
		'banner_image'    => array( sony_music_default_licensing_banner(), 'url' ),
		'banner_alt'      => array( isset( $defaults['banner_alt'] ) ? $defaults['banner_alt'] : 'Music Licensing', 'text' ),
		'intro_heading'   => array( isset( $defaults['intro_heading'] ) ? $defaults['intro_heading'] : '', 'text' ),
		'about_heading'   => array( isset( $defaults['about_heading'] ) ? $defaults['about_heading'] : 'About us', 'text' ),
		'about_image'     => array( sony_music_default_licensing_about_image(), 'url' ),
		'about_image_alt' => array( isset( $defaults['about_image_alt'] ) ? $defaults['about_image_alt'] : 'Music Licensing', 'text' ),
	);

	foreach ( $fields as $key => $config ) {
		$sanitize = 'url' === $config[1] ? 'esc_url_raw' : 'sanitize_text_field';

		$wp_customize->add_setting(
			"sony_music_licensing_{$key}",
			array(
				'default'           => $config[0],
				'sanitize_callback' => $sanitize,
			)
		);
		$wp_customize->add_control(
			"sony_music_licensing_{$key}",
			array(
				'label'   => ucwords( str_replace( '_', ' ', $key ) ),
				'section' => 'sony_music_licensing',
				'type'    => $config[1],
			)
		);
	}
}
add_action( 'customize_register', 'sony_music_music_licensing_customize_register', 20 );
