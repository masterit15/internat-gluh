<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package internat_gluh
 */

?><div class="row">
  <? get_sidebar(); ?>
  <div class="content_wrap" id="post-<?php the_ID(); ?>">
    <main id="main" class="content">
      <?php the_title('<h2 class="page_title title">', '</h2>'); ?>
      <form id="filter" data-url="<?php echo site_url() ?>/wp-admin/admin-ajax.php?action=docfilters">
        <div class="fields_group">
          <input type="text" name="name" id="f_name">
          <label for="f_name">По названию</label>
        </div>
        <div class="fields_group">
        <select name="f_cat" class="f_cat_list">
          <option value="#">По разделу</option>
            <?
            $terms = get_terms([
              'taxonomy' => 'documents-cat',
              'hide_empty' => false,
            ]);
            foreach($terms as $term){
              $cat = (array) $term;
            ?>
              <option value="<?=$cat['term_id']?>"><?=$cat['name']?></option>
            <?}?>
            </select>
        </div>
        <div class="fields_group">
          <input id="f_date" name="date" type="text" class="datepicker-here"/>
          <label for="f_date">По дате от - до</label>
        </div>
      </form>
      <div class="documents_wrap">
      <?
      $current_page = !empty($_GET['paged']) ? $_GET['paged'] : 1;
      $query = new WP_Query(
        array(
          'post_type' => 'documents',
          'post_status' => 'publish',
          'posts_per_page' => 20,
          'paged'          => $current_page,
        )
      );

      if ($query->have_posts()) {
        while ($query->have_posts()) {
          $query->the_post();
          $custom = get_post_custom($post->ID);
          $filesId = explode(',', $custom['documents'][0]);
          if (count($filesId) > 1) {
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
          <? } else {
            $file = getFileArr($filesId[0]);
          ?>
            <div class="doc_item item" title='<?= the_title() ?>' data-id="<?= $file['id']; ?>">
              <a href="<?= $file['path'] ?>" <? if ($file['type'] != 'pdf') { ?>download<? } ?>>
                <span class="doc_icon">
                  <?= $file['icon'] ?>
                </span>
                <div class="doc_detail">
                  <div class="doc_title">
                    <?= $file['name']; ?>
                  </div>
                  <span class="doc_date">
                    <? the_date() ?>
                  </span>
                </div>
                <span class="doc_size"><?= $file['size'] ?></span>
              </a>
            </div>
      <? } // if(count($filesId) > 1)
        }
      }
      ?>
      </div>
      <nav class="pagination">
      <? // я упомянул, что функция ничего не возвращает, если всего только 1 страница постов?
      echo paginate_links(array(
        'base' => site_url() . '%_%',
        'format' => '?paged=%#%',
        'total' => $query->max_num_pages,
        'current' => $current_page,
        'prev_next'    => True,
      'prev_text'    => __('« '),
      'next_text'    => __('»'),
      'mid_size' => 3,
      'end_size' => 2,
      ));

      wp_reset_postdata(); // чтобы ничего не поломать
      ?>
      </nav>
    </main>
  </div>
</div>