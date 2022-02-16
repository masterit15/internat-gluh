<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vladpitomnik
 */

?>
<section class="hero">
  <div class="slider owl-carousel owl-theme">
    <div class="slider_item">
      <div class="slider_item_media" style="background-image: url(<?=TURI?>/images/dist/pexels-1.jpg);"></div>
    </div>
    <div class="slider_item">
      <div class="slider_item_media" style="background-image: url(<?=TURI?>/images/dist/pexels-2.jpg);"></div>
    </div>
    <div class="slider_item">
      <div class="slider_item_media" style="background-image: url(<?=TURI?>/images/dist/pexels-3.jpg);"></div>
    </div>
  </div>
</section>
<? get_sidebar(); ?>