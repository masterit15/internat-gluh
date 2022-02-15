<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package yugtelecom
 */

?>
<div class="content_wrap" id="post-<?php the_ID(); ?>">

  <video width="674" height="674" class="video" loop="loop" autoplay="" muted="">
    <source src="#" type="video/mp4" />
    <source src="#" type="video/ogv" />
    <source src="<?=TURI?>video/STelecomComposed_final_alpha.webm" type="video/webm" />
  </video>

  <main class="content">
	<?php the_title( '<h2 class="page_title title">', '</h2>' ); ?>
	<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'yugtelecom' ),
				'after'  => '</div>',
			)
		);
		?>
  </main>
</div>
