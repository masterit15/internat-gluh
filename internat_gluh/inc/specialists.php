<?
add_action('init', 'my_custom_specialists');
function my_custom_specialists() {
	register_post_type('specialists', array(
		'labels' => array(
			'name' => 'Специалисты',
			'singular_name' => 'Специалисты',
			'add_new' => 'Добавить Специалиста',
			'add_new_item' => 'Добавить нового Специалиста',
			'edit_item' => 'Редактировать Специалиста',
			'new_item' => 'Новый Специалист',
			'view_item' => 'Посмотреть Специалиста',
			'search_items' => 'Найти Специалиста',
			'not_found' => 'Специалистов не найдено',
			'not_found_in_trash' => 'В корзине Специалистов не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Специалисты',

		),
		'public' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'specialists', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail'),
		'show_in_rest' => true,
		'rest_base' => 'specialists',
		'menu_icon' => 'dashicons-id'
		
	));
	// Добавляем для кастомных типо записей Категории
	register_taxonomy(
		"specialists-cat",
		array("specialists"),
		array(
			"hierarchical" => true,
			"label" => "Категории",
			"singular_label" => "Категория",
			"rewrite" => array('slug' => 'specialists', 'with_front' => false),
		)
	);
}

//Дополнительные поля 
add_action("admin_init", "specialists_init");

function specialists_init() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		add_meta_box("specialists", "График оказания услуг", "specialists_field", 'specialists', "normal", "low");
	}
}

add_action('save_post', 'save_specialists');

function save_specialists() {
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post->ID, "specialists_shedule", $_POST["specialists_shedule"]);
		update_post_meta($post->ID, "specialists_shedule_book", $_POST["specialists_shedule_book"]);
		update_post_meta($post->ID, "specialists_email", $_POST["specialists_email"]);
		update_post_meta($post->ID, "specialists_city", $_POST["specialists_city"]);
	}
}
//Дополнительные поля продукта html
function specialists_field() {
	global $post;
	$custom = get_post_custom($post->ID);
	$shedule    = $custom["specialists_shedule"][0];
	$sheduleBook    = $custom["specialists_shedule_book"][0];
	$email    = $custom["specialists_email"][0];
	$city    = $custom["specialists_city"][0];
	?>
  <div class="application_fields">
  <div class="group">
    <label for="specialists_email">Е-почта специалиста:</label>
    <input type="email" name="specialists_email" id="specialists_email" placeholder="Е-почта специалиста" <?if($email){?>value="<?=$email?>"<?}?>>
  </div>
  <div class="group">
    <label for="specialists_email">Город:</label>
    <input type="text" name="specialists_city" id="specialists_city" placeholder="Город" <?if($city){?>value="<?=$city?>"<?}?>>
  </div>
  </div>
  <?if ($shedule) {?>
    <textarea id="specialists_field" name="specialists_shedule" id="" cols="50" rows="10"><?=$shedule?></textarea>
  <?} else {?>
    <textarea id="specialists_field" name="specialists_shedule" id="" cols="50" rows="10"></textarea>
  <?}?>
  <?if ($sheduleBook) {?>
    <textarea id="application_specialist_shedule" name="specialists_shedule_book" id="" cols="50" rows="10"><?=$sheduleBook?></textarea>
  <?} else {?>
    <textarea id="application_specialist_shedule" name="specialists_shedule_book" id="" cols="50" rows="10"></textarea>
  <?}?>
  <div class="shedule_action">
    <div class="checkall">отметить все</div>
    <div class="removeall">очистить все</div>
  </div>
  <?sheduleTable();
}
function getPostCount($specialist)
{
  $args = array(
    'post_type' => 'application'
  );
  $the_query = new WP_Query( $args );
  $count = 0;
  $appArr = (array) $the_query->posts;
  
  foreach($appArr as $app){
    $custom = get_post_custom($app->ID);
    if($custom['application_specialist'][0] == $specialist){
      $count++;
    }
  }
  echo $count;
}
// Регистрируем колонку 'ID' и 'Миниатюра'. Обязательно.
add_filter( 'manage_specialists_posts_columns', function ( $columns ) {
	$my_columns = [
		'email'=> 'E-почта',
		'app_count'=> 'Количество заявок'
	];

	return array_slice( $columns, 0, 1 ) + $columns + $my_columns ;
} );
// Выводим контент для каждой из зарегистрированных нами колонок. Обязательно.
add_action( 'manage_specialists_posts_custom_column', function ( $column_name ) {
	global $post;
	$custom = get_post_custom($post->ID);
	if ( $column_name === 'app_count' ) {
		echo getPostCount($post->ID);
	}
	if ( $column_name === 'email' ) {
    echo $custom['specialists_email'][0];
	}
} );
// Меняем заголовок столбца
add_filter( 'manage_posts_columns', 'change_title_in_table_services', 10, 2 );
function change_title_in_table_services( $post_columns, $post_type ) {
	if ( 'specialists' === $post_type ) {
		$post_columns['title'] = 'ФИО специалиста';
		// $post_columns['date'] = 'ФИО специалиста';
    
	}
	return $post_columns;
}
function getWeekAndDate(){
  $date = strtotime('monday this week');
  $weekday = ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'];
  $weekArr = [];
  for($i = 0;$i < 7;$i++) {
    $weekArr[$i]['weekday'] = $weekday[$i];
    $weekArr[$i]['weekdate'] = date("d.m", $date);
    $weekArr[$i]['weekdatefull'] = date("d.m.Y", $date);
    $date =  strtotime('+1 day', $date);
  } 
    $i = 1;
    foreach($weekArr as $week){
      echo '<td class="weekday" data-weekdatefull="'.$week['weekdatefull'].'" data-weekday="'.$i.'">'.$week['weekday'].' <span>'.$week['weekdate'].'</span></td>';
    $i++;
  }
}
function getWeekAndDateApp(){
  $date = strtotime('monday this week');
  $weekday = ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'];
  $weekArr = [];
  for($i = 0;$i < 7;$i++) {
    $weekArr[$i]['weekday'] = $weekday[$i];
    $weekArr[$i]['weekdate'] = date("d.m", $date);
    $weekArr[$i]['weekdatefull'] = date("d.m.Y", $date);
    $date =  strtotime('+1 day', $date);
  } 
  return $weekArr;
}

function sheduleTable($d='monday this week'){
  global $post;
  $ts = strtotime($d);
  $start = (date('w', $ts) == 1) ? $ts : strtotime('last monday', $ts);
  // return date('Y-m-d', $start)."/".date('Y-m-d', strtotime('next sunday', $start));
  $date = strtotime(date('Y-m-d', $start));
  $weekday = ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'];
  $times = [
    '9:00','9:30',
    '10:00','10:30',
    '11:00','11:30',
    '12:00','12:30',
    '13:00','13:30',
    '14:00','14:30',
    '15:00','15:30',
    '16:00','16:30',
    '17:00','17:30',
    '18:00','18:30',
    '19:00','19:30'
  ];
  $weekArr = [];
  for($i = 0;$i < 7;$i++) {
    $weekArr[$i]['weekday'] = $weekday[$i];
    $weekArr[$i]['weekdate'] = date("d.m", $date);
    $weekArr[$i]['weekdatefull'] = date("d.m.Y", $date);
    $date =  strtotime('+1 day', $date);
  } 
  $spc = get_post_type($post->ID) == 'specialists' ? "specialists" : "";
  echo '<table class="specialist_shedule '.$spc.'">
          <tbody>
            <tr>
              <td class="weekday">Время</td>';
              $i = 1;
              foreach($weekArr as $week){
                echo '<td class="weekday" data-weekdatefull="'.$week['weekdatefull'].'" data-weekday="'.$i.'">'.$week['weekday'].' <span>'.$week['weekdate'].'</span></td>';
                $i++;
              };
  echo      '</tr>';
              foreach($times as $t){
                echo '<tr>
                        <td class="time">'.$t.'</td>';
                        $i = 1;
                        foreach($weekArr as $week){
                          echo '<td class="day" data-weekday="'.$i.'" data-time="'.$t.'" data-book="false" data-id="'.$week['weekdatefull'].'-'.$t.'"></td>';
                          $i++;
                        };
                echo  '</tr>';
              }
  echo    '</tbody>
        </table>';
  die;
}
