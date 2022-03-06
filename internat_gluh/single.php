<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package internat_gluh
 */

get_header();
?>
<div class="row">
  <? get_sidebar(); ?>

  <main id="main" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			?>
			<div class="news_detail">
				<h2 class="news_detail_title"><?the_title()?></h2>
				<span class="news_detail_date"><?the_date()?></span>
				<?if(get_the_post_thumbnail_url($post->ID, 'large')){?>
					<div class="news_detail_media" style="background-image: url(<?=get_the_post_thumbnail_url($post->ID, 'large')?>);"></div>
				<?}?>
				<div class="news_detail_desc"><?the_content()?></div>
			</div>
			<?
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Предыдущая новость:', 'internat_gluh' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Следующая новость:', 'internat_gluh' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			// if ( comments_open() || get_comments_number() ) :
			// 	comments_template();
			// endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->
</div>
<?php
get_footer();
