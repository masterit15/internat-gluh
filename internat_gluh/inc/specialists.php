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
		update_post_meta($post->ID, "specialists_email", $_POST["specialists_email"]);
	}
}
//Дополнительные поля продукта html
function specialists_field() {
	global $post;
	$custom = get_post_custom($post->ID);
	$shedule    = $custom["specialists_shedule"][0];
	$email    = $custom["specialists_email"][0];
	?>
  
  <div class="group">
    <?if ($email) {?>
      <label for="specialists_email">Е-почта специалиста</label>
      <input type="email" name="specialists_email" id="specialists_email" placeholder="Е-почта специалиста" value="<?=$email?>">
    <?} else {?>
      <label for="specialists_email">Е-почта специалиста</label>
      <input type="email" name="specialists_email" id="specialists_email" placeholder="Е-почта специалиста" value="<?=$email?>">
    <?}?>
  </div>
  <?if ($shedule) {?>
    <textarea id="specialists_field" name="specialists_shedule" id="" cols="50" rows="10"><?=$shedule?></textarea>
  <?} else {?>
    <textarea id="specialists_field" name="specialists_shedule" id="" cols="50" rows="10"></textarea>
  <?}?>
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
<?
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