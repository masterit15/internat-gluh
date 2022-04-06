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
  <textarea id="specialists_field_shedule" name="specialists_shedule_book" id="" cols="50" rows="10"></textarea>
  <table class="specialist_shedule">
    <tbody>
      <tr>
        <td></td>
        <?getWeekAndDate()?>
      </tr>
      <tr>
        <td class="time">9:00</td>
        <td class="day" data-weekday="1" data-time="9" data-book="false" data-id="1"></td>
        <td class="day" data-weekday="2" data-time="9" data-book="false" data-id="2"></td>
        <td class="day" data-weekday="3" data-time="9" data-book="false" data-id="3"></td>
        <td class="day" data-weekday="4" data-time="9" data-book="false" data-id="4"></td>
        <td class="day" data-weekday="5" data-time="9" data-book="false" data-id="5"></td>
        <td class="day" data-weekday="6" data-time="9" data-book="false" data-id="6"></td>
        <td class="day" data-weekday="7" data-time="9" data-book="false" data-id="7"></td>
      </tr>
      <tr>
        <td class="time">10:00</td>
        <td class="day" data-weekday="1" data-time="10" data-book="false" data-id="8"></td>
        <td class="day" data-weekday="2" data-time="10" data-book="false" data-id="9"></td>
        <td class="day" data-weekday="3" data-time="10" data-book="false" data-id="10"></td>
        <td class="day" data-weekday="4" data-time="10" data-book="false" data-id="11"></td>
        <td class="day" data-weekday="5" data-time="10" data-book="false" data-id="12"></td>
        <td class="day" data-weekday="6" data-time="10" data-book="false" data-id="13"></td>
        <td class="day" data-weekday="7" data-time="10" data-book="false" data-id="14"></td>
      </tr>
      <tr>
        <td class="time">11:00</td>
        <td class="day" data-weekday="1" data-time="11" data-book="false" data-id="15"></td>
        <td class="day" data-weekday="2" data-time="11" data-book="false" data-id="16"></td>
        <td class="day" data-weekday="3" data-time="11" data-book="false" data-id="17"></td>
        <td class="day" data-weekday="4" data-time="11" data-book="false" data-id="18"></td>
        <td class="day" data-weekday="5" data-time="11" data-book="false" data-id="19"></td>
        <td class="day" data-weekday="6" data-time="11" data-book="false" data-id="20"></td>
        <td class="day" data-weekday="7" data-time="11" data-book="false" data-id="21"></td>
      </tr>
      <tr>
        <td class="time">12:00</td>
        <td class="day" data-weekday="1" data-time="12" data-book="false" data-id="22"></td>
        <td class="day" data-weekday="2" data-time="12" data-book="false" data-id="23"></td>
        <td class="day" data-weekday="3" data-time="12" data-book="false" data-id="24"></td>
        <td class="day" data-weekday="4" data-time="12" data-book="false" data-id="25"></td>
        <td class="day" data-weekday="5" data-time="12" data-book="false" data-id="26"></td>
        <td class="day" data-weekday="6" data-time="12" data-book="false" data-id="27"></td>
        <td class="day" data-weekday="7" data-time="12" data-book="false" data-id="28"></td>
      </tr>
      <tr>
        <td class="time">13:00</td>
        <td class="day" data-weekday="1" data-time="13" data-book="false" data-id="29"></td>
        <td class="day" data-weekday="2" data-time="13" data-book="false" data-id="30"></td>
        <td class="day" data-weekday="3" data-time="13" data-book="false" data-id="31"></td>
        <td class="day" data-weekday="4" data-time="13" data-book="false" data-id="32"></td>
        <td class="day" data-weekday="5" data-time="13" data-book="false" data-id="33"></td>
        <td class="day" data-weekday="6" data-time="13" data-book="false" data-id="34"></td>
        <td class="day" data-weekday="7" data-time="13" data-book="false" data-id="35"></td>
      </tr>
      <tr>
        <td class="time">14:00</td>
        <td class="day" data-weekday="1" data-time="14" data-book="false" data-id="36"></td>
        <td class="day" data-weekday="2" data-time="14" data-book="false" data-id="37"></td>
        <td class="day" data-weekday="3" data-time="14" data-book="false" data-id="38"></td>
        <td class="day" data-weekday="4" data-time="14" data-book="false" data-id="39"></td>
        <td class="day" data-weekday="5" data-time="14" data-book="false" data-id="40"></td>
        <td class="day" data-weekday="6" data-time="14" data-book="false" data-id="41"></td>
        <td class="day" data-weekday="7" data-time="14" data-book="false" data-id="42"></td>
      </tr>
      <tr>
        <td class="time">15:00</td>
        <td class="day" data-weekday="1" data-time="15" data-book="false" data-id="43"></td>
        <td class="day" data-weekday="2" data-time="15" data-book="false" data-id="44"></td>
        <td class="day" data-weekday="3" data-time="15" data-book="false" data-id="45"></td>
        <td class="day" data-weekday="4" data-time="15" data-book="false" data-id="46"></td>
        <td class="day" data-weekday="5" data-time="15" data-book="false" data-id="47"></td>
        <td class="day" data-weekday="6" data-time="15" data-book="false" data-id="48"></td>
        <td class="day" data-weekday="7" data-time="15" data-book="false" data-id="49"></td>
      </tr>
      <tr>
        <td class="time">16:00</td>
        <td class="day" data-weekday="1" data-time="16" data-book="false" data-id="50"></td>
        <td class="day" data-weekday="2" data-time="16" data-book="false" data-id="51"></td>
        <td class="day" data-weekday="3" data-time="16" data-book="false" data-id="52"></td>
        <td class="day" data-weekday="4" data-time="16" data-book="false" data-id="53"></td>
        <td class="day" data-weekday="5" data-time="16" data-book="false" data-id="54"></td>
        <td class="day" data-weekday="6" data-time="16" data-book="false" data-id="55"></td>
        <td class="day" data-weekday="7" data-time="16" data-book="false" data-id="56"></td>
      </tr>
      <tr>
        <td class="time">17:00</td>
        <td class="day" data-weekday="1" data-time="17" data-book="false" data-id="57"></td>
        <td class="day" data-weekday="2" data-time="17" data-book="false" data-id="58"></td>
        <td class="day" data-weekday="3" data-time="17" data-book="false" data-id="59"></td>
        <td class="day" data-weekday="4" data-time="17" data-book="false" data-id="60"></td>
        <td class="day" data-weekday="5" data-time="17" data-book="false" data-id="61"></td>
        <td class="day" data-weekday="6" data-time="17" data-book="false" data-id="62"></td>
        <td class="day" data-weekday="7" data-time="17" data-book="false" data-id="63"></td>
      </tr>
      <tr>
        <td class="time">18:00</td>
        <td class="day" data-weekday="1" data-time="18" data-book="false" data-id="64"></td>
        <td class="day" data-weekday="2" data-time="18" data-book="false" data-id="65"></td>
        <td class="day" data-weekday="3" data-time="18" data-book="false" data-id="66"></td>
        <td class="day" data-weekday="4" data-time="18" data-book="false" data-id="67"></td>
        <td class="day" data-weekday="5" data-time="18" data-book="false" data-id="68"></td>
        <td class="day" data-weekday="6" data-time="18" data-book="false" data-id="69"></td>
        <td class="day" data-weekday="7" data-time="18" data-book="false" data-id="70"></td>
      </tr>
    </tbody>
  </table>
  </div>
  <?
  }
die();
}

?>