<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vladpitomnik
 */

?>
<div class="content_wrap">
  <main class="content">
    <h2 class="page_title title">Карта покрытия сети</h2>
    <div id="y_maps" data-poligons="<?=get_theme_mod('maps')?>"></div>
  </main>
</div>