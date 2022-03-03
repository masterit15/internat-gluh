<?php

/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package vladgzeta
 */
?>
<div class="content" id="post-<?php the_ID(); ?>">
	<?php the_title( '<h2 class="page_title title">', '</h2>' ); ?>
<?php // Display blog posts on any page @ http://m0n.co/l
$reviews = new WP_Query(
    array(
        'post_type' => 'gallery',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'tax_query' => array(
            array(
                'taxonomy' => 'gallery-cat',   // taxonomy name
                'field' => 'id',           // term_id, slug or name
                'terms' => 8,                  // term id, term slug or term name
            )
        ),
    )
);
if ($reviews->have_posts()) {
    while ($reviews->have_posts()) {
        $reviews->the_post();
        echo '<div class="gallery_list">';
            the_title('<h3>', '</h3>');
            echo '<div class="gallery_list_wrap">';
                single_gallery($reviews->post, 8);
            echo '</div>';
            echo '<a class="gallery_more" href='.get_permalink().'>Подробнее</a>';
        echo '</div>';
    }
} else {
    echo 'Ничего не найдено';
}
wp_reset_postdata(); ?>
</div>