<?
add_action('wp_ajax_form', 'form'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_form', 'form');
function form(){
?>
<form action="" class="application">
  <div class="rates_dd">
    <label for="rate">
      Тариф
      <input type="text" name="rates" id="rate">
    </label>
    <ul class="rates_dd_list">
      <?
        $reviews = new WP_Query(
        array(
        'post_type' => 'rates',
        'post_status' => 'publish',
        'posts_per_page' => 5,
        'orderby'          => 'date',
        'order'            => 'ASC',
        'page'=> 1
        ));
        
        if ($reviews->have_posts()) {
          while ($reviews->have_posts()) {$reviews->the_post();
          $custom = get_post_custom($reviews->ID);
          PR(the_ID());
      ?>
        <li class="rates_dd_item" data-rate="<?the_ID()?>"><?the_title()?>, Скорость: <?=$custom['rates_speed'][0]?> Мбит/сек</li>
      <?}}?>
    </ul>
  </div>
  <label for="fio">
    ФИО или название организации
    <input type="text" name="fio" id="fio">
  </label>
  <label for="address">
    Населеный пункт, улица, номер дома, квартира
    <input type="text" name="address" id="address">
  </label>
  <label for="phone">
    Контактный телефон
    <input type="text" name="phone" id="phone">
  </label>
  <button class="send btn">Отправить</button>
</form>
<?
die();
}?>