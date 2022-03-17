<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package internat_gluh
 */

?>
<div class="content" id="post-<?php the_ID(); ?>">
	<?php the_title( '<h2 class="page_title title">', '</h2>' ); ?>
	<?php
the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'internat_gluh' ),
				'after'  => '</div>',
			)
		);
		?>
</div>
