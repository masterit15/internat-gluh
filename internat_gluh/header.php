<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package internat_gluh
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<?
	define("TURI",     get_template_directory_uri() . '/');
	//if(!is_front_page()){echo 'white';}
	?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site" style="background-image: url(<?= TURI ?>/images/dist/bg_patern.svg);">
		<div class="container">
			<div class="wrapper">
				<div class="top">
					<div class="top_item">
						<? // получаем ссылку на логотип
						$custom_logo__url = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
						if ($custom_logo__url[0] != '') {
						?>
							<a class="logo" href="/">
								<img src="<?= $custom_logo__url[0] ?>" alt="<?php bloginfo('name'); ?>">
								<div class="logo_text">
									<h2 class="logo_title"><?php bloginfo('name'); ?></h2>
									<span class="logo_desc"><?php bloginfo('description'); ?></span>
								</div>
							</a>
						<? } else { ?>
							<a class="logo" href="/">
								<svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512" data-svgdocument="" id="_AMue_hTTOsDwNivtln3oA" class="fl-svgdocument" x="0" y="0" xmlns:xlink="http://www.w3.org/1999/xlink" overflow="hidden" style="overflow: visible;">
									<defs id="__Nbwm2NUxknuYdWTHVTAN" transform="matrix(1.3169420957565308, 0, 0, 1.3169420957565308, -67.34423828125, 154.0553436279297)" data-uid="o_emg88764h_4"></defs>
									<path id="_VpuXMOG6bxEDTHb_QcUMI" d="M779.3,464.9l-63.8,175l-59.3,212.3c-36.3,120.9-96.7,164-207.8,163.8c-95.6-0.1-155-39.5-211.3-128.4l-171.6-290  c-12.6-25.2-5.3-49.8,15.7-61.2c21-11.3,46.7-8.2,64.8,17.2c5.7,8,33.5,44.8,64.2,86.3c0,0,0.1,0.1,0.1,0.1  c13,18.7,30.8,42.2,52.8,71.8l65.9,95.6l55,86.3c5.1,9.2,15.5,13.7,24,8.5c8.2-5,10.8-12.9,5.2-24.1l-36.2-76.1  c-2.1-4.3,3.5-8.1,6.7-4.5l86.8,112.7c7.4,8.3,22.5,13.2,31.4,5.3c8.9-7.9,7.6-21.5,0.5-30.9l-73.2-103.8c-2.7-3.5,2.3-7.8,5.4-4.7  l102.1,107.1c7.4,8.3,22.2,11.9,31.1,4c8.9-7.9,7.6-21.8-0.1-30.7L459,737.8c-2.6-3,1.2-7.3,4.5-5l92.2,70.3c11.3,7.9,25.4,9.2,33,0  c8.5-10.2,1.5-24.6-8-32.3l-132.9-112c-21.2-16.6-13.5-34.9,12.8-34.2c33.5,1,71.1,1.5,77.5,1.7c15.1,0.6,23.9-8.3,25.8-19.7  c1.9-11.4-5.4-21.5-18.8-24.2l-162-20.5c-19.9-1.9-43-4.3-66.5-5.7l9.2-261.8c0.4-25.3,16.5-48.1,43.9-47.3  c24.6,0.7,42.7,21.2,44.1,49.6l3.9,220.8c0.3,8.3,12.2,9.2,13.8,1l49.9-308.5c4.7-23.8,27.7-39.5,51.8-35  c24.2,4.5,39.9,28.7,35.7,51.3l-39.3,280.4c-1.2,9.1,12,11.7,14.4,2.9l66.8-229.2c6.3-23.5,27.9-38.2,52-33.7  c24.2,4.5,38.9,31,34.7,53.5l-67.2,263.1c-1.7,9.6,11.6,14,15.9,5.2l66.2-130c11.2-23.3,29.3-29,47.8-22  C779.1,423.8,787.9,444.9,779.3,464.9z" fill="#ffba4a" transform="matrix(0.3354634247590993, 0, 0, 0.3354634247590993, 114.78476691090208, 56.3604927374044)" data-uid="o_emg88764h_6"></path>
								</svg>
								<div class="logo_text">
									<h2 class="logo_title"><?php bloginfo('name'); ?></h2>
									<span class="logo_desc"><?php bloginfo('description'); ?></span>
								</div>
							</a>
						<? } ?>
					</div>
					<div class="top_item">
						<ul class="social">
							<li>
								<a href="<?= get_theme_mod('soc_vk') ?>" target="_black"><i class="fa fa-vk"></i></a>
							</li>
							<li>
								<a href="<?= get_theme_mod('soc_inst') ?>" target="_black"><i class="fa fa-instagram"></i></a>
							</li>
							<li>
								<a href="<?= get_theme_mod('soc_fac') ?>" target="_black"><i class="fa fa-facebook"></i></a>
							</li>
						</ul>
					</div>
					<div class="top_item">
						<button class="btn add">Написать</button>
						<div class="specversion"><?php dynamic_sidebar('specvarsion-1'); ?></div>
						<div class="mobile_menu_btn">
							<span></span>
							<span></span>
							<span></span>
						</div>
					</div>
				</div>
					<header id="masthead" class="site-header">
						<div class="container" style="background-color: #fff;">
							<div class="site-branding">
								<a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><? //php bloginfo( 'name' ); 
																																						?></a>
							</div><!-- .site-branding -->
						</div>
					</header><!-- #masthead -->