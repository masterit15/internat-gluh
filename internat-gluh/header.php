<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package internat-gluh
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<?
	define("TURI",     get_template_directory_uri().'/');
	//if(!is_front_page()){echo 'white';}
	?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<div class="container">
		<div class="wrapper">
			<div class="specversion"><?php dynamic_sidebar( 'specvarsion-1' ); ?></div>
	<header id="masthead" class="site-header">
	<div class="container" style="background-color: #fff;">
		<div class="site-branding">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?//php bloginfo( 'name' ); ?></a>
		</div><!-- .site-branding -->
	</div>
	</header><!-- #masthead -->

