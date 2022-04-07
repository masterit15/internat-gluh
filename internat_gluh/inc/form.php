<?
header("Access-Control-Allow-Origin: *");
add_action('wp_ajax_specialistsSelect', 'specialistsSelect'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_specialistsSelect', 'specialistsSelect');
function specialistsSelect(){
  $arg = array(
    'post_type' => 'specialists',
    'post_status' => 'publish',
    'posts_per_page' => -1,
  );
  if($_POST['specialistscat'] != ''){
    $arg['tax_query'][] = array(
          'taxonomy' => 'specialists-cat',   // taxonomy name
          'field' => 'id',           // term_id, slug or name
          'terms' => $_POST['specialistscat'],                  // term id, term slug or term name
      );
  }
  $reviews = new WP_Query($arg);
  if ($reviews->have_posts()) {
    echo '<select id="specialists" name="specialists" title="Список специалистов" data-action="'.site_url ().'/wp-admin/admin-ajax.php?action=specialistShedule">';
      echo '<option value="#">Список специалистов</option>';  
      while ($reviews->have_posts()) {
        global $post;
          $reviews->the_post();
          echo '<option value="'.$post->ID.'">'. $post->post_title .'</option>';
      }
    echo '</select>';
  }
die();
}
add_action('wp_ajax_specialistShedule', 'specialistShedule'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_specialistShedule', 'specialistShedule');
function specialistShedule(){
  if($_POST['specialist'] != '#'){
  $post = get_post($_POST['specialist']);
  $custom = get_post_custom($post->ID);
	$shedule    = $custom["specialists_shedule"][0];
  $sheduleBook    = $custom["specialists_shedule_book"][0];
	$email    = $custom["specialists_email"][0];
  ?>
  <div class="shedule">
  <?if ($shedule) {?>
    <textarea id="specialists_field" name="specialists_shedule" id="" cols="50" rows="10"><?=$shedule?></textarea>
  <?} else {?>
    <textarea id="specialists_field" name="specialists_shedule" id="" cols="50" rows="10"></textarea>
  <?}?>
  <?if ($email) {?>
    <input type="hidden" name="specialists_email" id="specialists_email" placeholder="Е-почта специалиста" value="<?=$email?>">
  <?}?>
  <?if ($sheduleBook) {?>
    <textarea id="application_specialist_shedule" name="specialists_shedule_book" id="" cols="50" rows="10"><?=$sheduleBook?></textarea>
  <?} else {?>
    <textarea id="application_specialist_shedule" name="specialists_shedule_book" id="" cols="50" rows="10"></textarea>
  <?}?>
  <?sheduleTable()?>
  </div>
  <?
  }
die();
}

?>