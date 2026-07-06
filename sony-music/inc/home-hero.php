<?php
/**
 * Homepage hero news slider helpers.
 *
 * @package Sony_Music
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default hero slide data from sonymusic.eu.
 *
 * @return array<int, array{title:string,url:string,category:string,image:string}>
 */
function sony_music_default_hero_slides() {
	return array(
		array(
			'title'    => 'Sony Music and the Female* Producer Collective host songwriting camp at Circle Studios Berlin',
			'url'      => '#',
			'category' => 'Company',
			'image'    => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/06/FPC_News_Startseite_2000x1500.png',
		),
		array(
			'title'    => 'Sony Music brings together community and pop culture at ROSALÍA\'s Berlin concert',
			'url'      => '#',
			'category' => 'Other',
			'image'    => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/05/Rosalia_Startseite_2000x1500-1.png',
		),
		array(
			'title'    => 'Sony Music Entertainment and Two Sides expand their partnership at group level',
			'url'      => '#',
			'category' => 'Company',
			'image'    => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/05/Sony-Music-x-Two-Sides-Website-Startseite.png',
		),
		array(
			'title'    => 'Sony Music Hosted Female* Producer Prize Writing Camp and Industry Brunch in Berlin',
			'url'      => '#',
			'category' => 'Label',
			'image'    => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/04/SonyMusic_FPC_Camp_c_Geraldine_Hutt_2000x1500-1-scaled.jpg',
		),
		array(
			'title'    => 'Sony Music GSA and Black Future Week Host Special Black History Month Event in Berlin',
			'url'      => '#',
			'category' => 'Other',
			'image'    => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/04/BFW_2000x1500.png',
		),
		array(
			'title'    => 'Judas Priest presents the documentary "The Ballad of Judas Priest"',
			'url'      => '#',
			'category' => 'Company',
			'image'    => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/04/Judas-Priest_2000x1500.jpg',
		),
		array(
			'title'    => 'AVAION presents audiovisual album experience in Berlin',
			'url'      => '#',
			'category' => 'Artist',
			'image'    => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2026/01/AVAION_2000x1500.png',
		),
		array(
			'title'    => 'Sony Music and Female* Producer Collective hosted third songwriting camp at CIRCLE STUDIOS Berlin',
			'url'      => '#',
			'category' => 'Company',
			'image'    => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2025/11/251107-FPC-x-Sony-Music_2000x1500.jpg',
		),
		array(
			'title'    => 'Sony Music Germany and Music Women* Germany announce the winners of the Female* Producer Prize 2025',
			'url'      => '#',
			'category' => 'Company',
			'image'    => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2025/10/Female_Producer_Prize_SonyMusic-2025-byGeraldineHutt_2000x1500.jpg',
		),
		array(
			'title'    => 'German Artist Nina Chuba Launches Her Own Fortnite Island',
			'url'      => '#',
			'category' => 'Artist',
			'image'    => 'https://cdn-p.smehost.net/sites/33e53368dcb44640aa5540e64dca3fe0/wp-content/uploads/2025/09/Vorlage_2000x1500_News_Startseite-3.png',
		),
	);
}

/**
 * Homepage content helper.
 *
 * @param string $key     Setting key without prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function page_home( $key, $default = '' ) {
	$defaults = array(
		'hero_autoplay'      => 4000,
		'hero_speed'         => 1500,
		'hero_slides_to_show'=> 2,
	);

	if ( isset( $defaults[ $key ] ) && '' === $default ) {
		$default = $defaults[ $key ];
	}

	return get_theme_mod( 'sony_home_' . $key, $default );
}

/**
 * Get configured hero slides.
 *
 * @return array<int, array{title:string,url:string,category:string,image:string}>
 */
function sony_music_get_hero_slides() {
	$defaults = sony_music_default_hero_slides();
	$slides   = array();

	for ( $i = 1; $i <= 12; $i++ ) {
		$default = isset( $defaults[ $i - 1 ] ) ? $defaults[ $i - 1 ] : array(
			'title'    => '',
			'url'      => '',
			'category' => 'Company',
			'image'    => '',
		);

		$title = page_home( "hero_slide_{$i}_title", $default['title'] );

		if ( ! $title ) {
			continue;
		}

		$slides[] = array(
			'title'    => $title,
			'url'      => page_home( "hero_slide_{$i}_url", $default['url'] ) ?: '#',
			'category' => page_home( "hero_slide_{$i}_category", $default['category'] ) ?: 'Company',
			'image'    => page_home( "hero_slide_{$i}_image", $default['image'] ),
		);
	}

	return $slides;
}

/**
 * Render homepage hero block.
 */
function sony_music_render_block_hero() {
	$slides = sony_music_get_hero_slides();

	if ( empty( $slides ) ) {
		return;
	}

	get_template_part( 'template-parts/home/block', 'hero', array( 'slides' => $slides ) );
}
