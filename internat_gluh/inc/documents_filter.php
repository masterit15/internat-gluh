<?
add_action('wp_ajax_docfilters', 'docfilters'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_docfilters', 'docfilters');
function docfilters()
{
  $current_page = !empty($_GET['paged']) ? $_GET['paged'] : 1;
  $sort = isset($_POST['sort']) ? $_POST['sort'] : 'date';
		$dateFrom = $_POST['dateFrom'] ? date_format(new DateTime($_POST['dateFrom']), 'Y-m-d') : '';
		$dateTo = $_POST['dateTo'] ? date_format(new DateTime($_POST['dateTo']), 'Y-m-d') : '';
		$ppp = isset($_POST['ppp']) ? $_POST['ppp'] : 20;
    $name = $_POST['name'] != '' ? $_POST['name'] : '';
    $cat = $_POST['cat'] != '' ? $_POST['cat'] : '';
		$args = array(
			'orderby' => $sort, // we will sort posts by date
			'post_status' => 'publish',
      'post_type' => 'documents',
      'posts_per_page' => $ppp,
      'paged'          => $current_page,
		);
    if($name){
      $args['s'] = $name;
    }else{
      unset($args['s']);
    }
    if($cat){
      $args['tax_query'] = array(
          array(
              'taxonomy' => 'documents-cat',   // taxonomy name
              'field' => 'id',           // term_id, slug or name
              'terms' => $cat,                  // term id, term slug or term name
          )
        );
    }else{
      unset($args['tax_query']);
    }
		if($dateFrom && !$dateTo){
			$date = explode('-', $dateFrom);
			$args['date_query'] = array(
				array(
					'year'  => $date[0],
					'month' => $date[1],
					'day'   => $date[2],
				)
			);
		}
		if($dateFrom && $dateTo){
			$args['date_query'] = array(
				'before' => $dateTo,
				'after' => $dateFrom,
				'inclusive' => true,
				// 'compare'   => 'BETWEEN'
			);
		}
  $query = new WP_Query($args);
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
              <li class="folder-item js_folder-item">
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
            <? if (count($filesId) > 1) { ?>
              <li class="folder-item js_folder-item download_zip">
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
        <div class="doc_item item" title='<?= the_title() ?>'>
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
<? } 
    }
  }else{
    echo 'Ничего не найдено';
  }
  // echo json_encode($args);
  die;
}
?>