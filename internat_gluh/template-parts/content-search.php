<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package internat_gluh
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?
global $post;
?>
	<header class="entry-header">
		<?php 
		if( 'documents' !== get_post_type()){
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
		}
		?>

		<?php if ( 'post' === get_post_type() ){?>
		<div class="entry-meta">
			<?php
			// internat_gluh_posted_on();
			// internat_gluh_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?}?>
	</header><!-- .entry-header -->
	<?php if ( 'post' === get_post_type() ){?>
			<div class="news_item">
				<?if(get_the_post_thumbnail_url($post->ID, 'large')){?>
					<div class="news_item_madia" style="background-image: url(<?=get_the_post_thumbnail_url($post->ID, 'large')?>);"></div>
				<?}else{?>
					<div class="news_item_madia">
					<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
					<title/><g data-name="Layer 2" id="Layer_2">
					<path d="M29,8H26V5a1,1,0,0,0-1-1H3A1,1,0,0,0,2,5V23a1,1,0,0,0,1,1H6v3a1,1,0,0,0,1,1H29a1,1,0,0,0,1-1V9A1,1,0,0,0,29,8ZM4,22V6H24V8H7A1,1,0,0,0,6,9V22Zm8-10a2,2,0,1,1-2,2A2,2,0,0,1,12,12ZM25.89,23.46A1,1,0,0,1,25,24H11a1,1,0,0,1-.89-.55,1,1,0,0,1,.09-1.05l3-4a1,1,0,0,1,1.25-.29l1.35.67,3.49-3.49a1,1,0,0,1,.79-.29,1,1,0,0,1,.73.42l5,7A1,1,0,0,1,25.89,23.46Z"/></g></svg>
					</div>
				<?}?>
				<div class="news_item_content">
					<a class="news_item_title" href="<?=get_permalink()?>"><?the_title()?></a>
					<div class="news_item_desc"><?the_excerpt()?></div>
					<span class="news_item_date"><?=date("d.m.Y в H:m", strtotime($reviews->post->post_date))?></span>
				</div>
			</div>
		<?} elseif( 'documents' === get_post_type()){?>
			<?
          $custom = get_post_custom($post->ID);
          $filesId = explode(',', $custom['documents'][0]);
      ?>
            <div class="folder">
              <div class="folder-summary js_toggle-folder">
                <div class="folder-summary__start">
                  <div class="folder-summary__file-count">
                    <span class="folder-summary__file-count__amount"><?= count($filesId) ?></span>
                    <i class="fa fa-folder"></i>
                    <i class="fa fa-folder-open"></i>
                  </div>
                </div>
                <div class="folder-summary__details">
                  <div class="folder-summary__details__name">
                    <? the_title() ?>
                  </div>
                  <div class="folder-summary__details__share">
                    <? the_date() ?>
                  </div>
                </div>
                <div class="folder-summary__end">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" />
                  </svg>
                </div>
              </div>
              <ul class="folder-content">
                <? foreach ($filesId as $arProperty) {
                  $file = getFileArr($arProperty);
                ?>
                  <li class="folder-item js_folder-item" data-id="<?= $file['id']; ?>">
                    <a class="folder-item-wrap" href="<?= $file['path'] ?>" <? if ($file['type'] != 'pdf') { ?>download<? } ?>>
                      <div class="folder-item__icon"><?= $file['icon']; ?></div>
                      <div class="folder-item__details">
                        <div class="folder-item__details__name">
                          <?= $file['desc'] ? $file['desc'] : $file['name']; ?>
                        </div>
                      </div>
                      <div class="folder-item__size"><?= $file['size']; ?></div>
                    </a>
                  </li>
                <? } ?>
                <? if (false and count($filesId) > 1) { ?>
                  <li class="folder-item js_folder-item download_zip" >
                    <div class="folder-item-wrap">
                      <div class="folder-item__icon"><i class="fa fa-file-archive-o" style="color:#f3aa16"></i></div>
                      <div class="folder-item__details">
                        <div class="folder-item__details__name">
                          Скачать все файлы одним архивом
                        </div>
                      </div>
                      <div class="folder-item__size"><i class="fa fa-download"></i></div>
                    </div>
                  </li>
                <? } ?>
              </ul>
            </div>
          <? }else{ ?>
						<?the_excerpt()?>
						<?}?>
</article><!-- #post-<?php the_ID(); ?> -->
