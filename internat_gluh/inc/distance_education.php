<?

add_action('init', 'distance_education');
function distance_education() {
	register_post_type('distance_education', array(
		'labels' => array(
			'name' => 'Вопросы',
			'singular_name' => 'Вопрос',
			'add_new' => 'Добавить Вопрос',
			'add_new_item' => 'Добавить новоый Вопрос',
			'edit_item' => 'Редактировать Вопрос',
			'new_item' => 'Новый Вопрос',
			'view_item' => 'Посмотреть Вопрос',
			'search_items' => 'Найти Вопрос',
			'not_found' => 'Вопросов не найдено',
			'not_found_in_trash' => 'В корзине Вопросов не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Вопросы',
		),
		'public' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'distance_education', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title'),
		'show_in_rest' => true,
		'rest_base' => 'distance_education',
		'menu_icon' => 'dashicons-email-alt2'
	));
}

//Дополнительные поля 
add_action("admin_init", "distance_education_field_init");
add_action('save_post', 'save_distance_education_field');
function distance_education_field_init() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		add_meta_box("distance_education_field", "Данные об инициаторе", "distance_education_field", 'distance_education', "normal", "low");
	}
}
// Функция сохранения полей продукта "Цена" и "Тираж"
function save_distance_education_field() {
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post_id, "distance_education_name", $_POST['name']);
		update_post_meta($post_id, "distance_education_phone", $_POST['phone']);
		update_post_meta($post_id, "distance_education_email", $_POST['email']);
		update_post_meta($post_id, "distance_education_text", $_POST['text']);
		update_post_meta($post_id, "distance_education_class", $_POST['class']);
		
	}
}
//Дополнительные поля продукта html
function distance_education_field() {
	global $post;
	$custom = get_post_custom($post->ID);
	$spec = get_post($custom['distance_education_specialist'][0]);
	$specCustom = get_post_custom($spec->ID);
	?>
	<div class="distance_education">
		<div class="distance_education_fields">
			<div class="group">
				<label>ФИО:</label>
				<input disabled class="distance_education_fields_name" name="name" type="text" <?if ($custom['distance_education_name']) {?>value="<?=$custom['distance_education_name'][0]?>"<?}?>>
			</div>
			<div class="group">
				<label>Класс ребенка:</label>
				<input disabled class="distance_education_fields_name" name="class" type="text" <?if ($custom['distance_education_class']) {?>value="<?=$custom['distance_education_class'][0]?>"<?}?>>
			</div>
			<div class="group">
				<label>Телефон:</label>
				<input disabled class="distance_education_fields_phone" name="phone" type="text"  <?if ($custom['distance_education_phone']) {?>value="<?=$custom['distance_education_phone'][0]?>"<?}?>>
			</div>
			<div class="group">
				<label>Е-почта:</label>
				<input disabled class="distance_education_fields_email" name="email" type="text" <?if ($custom['distance_education_email']) {?>value="<?=$custom['distance_education_email'][0]?>"<?}?>>
			</div>
		</div>
		<textarea id="distance_education_specialist_text" disabled name="text" cols="70" rows="10"><?if ($custom['distance_education_text']) {?><?=$custom['distance_education_text'][0]?><?}?></textarea>
	</div>
<?
}
// Регистрируем колонку 'ID' и 'Миниатюра'. Обязательно.
add_filter( 'manage_distance_education_posts_columns', function ( $columns ) {
	$my_columns = [
		'name' => 'ФИО',
		'phone'=> 'Телефон',
		'email'=> 'E-почта',
	];

	return array_slice( $columns, 0, 1 ) + $columns + $my_columns ;
} );
// Выводим контент для каждой из зарегистрированных нами колонок. Обязательно.
add_action( 'manage_distance_education_posts_custom_column', function ( $column_name ) {
	global $post;
	$custom = get_post_custom($post->ID);
	if ( $column_name === 'name' ) {
		echo $custom['distance_education_name'][0];
	}
	if ( $column_name === 'phone' ) {
		echo $custom['distance_education_phone'][0];
	}
	if ( $column_name === 'email' ) {
		echo $custom['distance_education_email'][0];
	}
} );

add_action( 'admin_menu', function() {
	global $menu;
	$posts = get_posts('post_type=distance_education&suppress_filters=0&posts_per_page=-1&post_status=unread');
	$count = count($posts); 
	$menu[31][0] = $count > 0 ? 'Вопросов <span class="awaiting-mod">' . $count. '</span>' : 'Вопросы';
});
function distance_education_true_status_unread(){
	register_post_status( 'unread', array(
		'label'                     => 'Не прочитанные',
		'label_count'               => _n_noop( 'Не прочитанные <span class="count">(%s)</span>', 'Не прочитанные <span class="count">(%s)</span>' ),
		'public'                    => true,
		'show_in_admin_status_list' => true // если установить этот параметр равным false, то следующий параметр можно удалить
	) );
}
add_action( 'init', 'distance_education_true_status_unread' );

add_action('admin_footer-edit.php','distance_education_true_status_unread_select');
function distance_education_true_status_unread_select() {
	echo "<script>
	jQuery(document).ready( function($) {
		$( 'select[name=\"_status\"]' ).append( '<option value=\"unread\">Не прочитано</option>' );
	});
	</script>";
}

function distance_education_true_status_unread_display( $statuses ) {
	global $post;
	if( get_query_var( 'post_status' ) != 'unread' ){ // проверка, что мы не находимся на странице всех постов данного статуса
		if($post->post_status == 'unread'){ // если статус поста - Архив
			return array('Не прочитанные');
		}
	}
	return $statuses;
}
 
add_filter( 'display_post_states', 'distance_education_true_status_unread_display' );


function distance_education_true_status_isread(){
	register_post_status( 'isread', array(
		'label'                     => 'Прочитанные',
		'label_count'               => _n_noop( 'Прочитанные <span class="count">(%s)</span>', 'Прочитанные <span class="count">(%s)</span>' ),
		'public'                    => true,
		'show_in_admin_status_list' => true // если установить этот параметр равным false, то следующий параметр можно удалить
	) );
}
add_action( 'init', 'distance_education_true_status_isread' );


function distance_education_true_status_isread_select() {
	echo "<script>
	jQuery(document).ready( function($) {
		$( 'select[name=\"_status\"]' ).append( '<option value=\"isread\">Прочитано</option>' );
	});
	</script>";
}
add_action('admin_footer-edit.php','distance_education_true_status_isread_select');

function distance_education_true_status_isread_display( $statuses ) {
	global $post;
	if( get_query_var( 'post_status' ) != 'isread' ){ // проверка, что мы не находимся на странице всех постов данного статуса
		if($post->post_status == 'isread'){ // если статус поста - Архив
			return array('Прочитанные');
		}
	}
	return $statuses;
}
 
add_filter( 'display_post_states', 'distance_education_true_status_isread_display' );

if(isset($_GET['post']) && $_GET['action'] == 'edit' && get_post_type($_GET['post']) == 'distance_education' && get_post_status($_GET['post']) == 'unread'){
	wp_update_post(array(
		'ID'    =>  $_GET['post'],
		'post_status'   =>  'isread'
		));
}

add_action('wp_ajax_distance_education', 'distance_educationHandler'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_distance_education', 'distance_educationHandler');
function distance_educationHandler(){
	$res = array('success' => false);
  // Проверка, что есть POST запрос
  if ($_POST) {
    $is_valid = $_POST['captcha'] == '' ? true : false;
    if($is_valid){
      $feed = array(
				'userFio' => $_POST['userFio'],
				'userClass' => $_POST['userClass'],
				'userText' => $_POST['userText'],
				'userEmail' => $_POST['userEmail'],
				'userPhone' => $_POST['userPhone'],
      );
      $postContent =  '<strong>Класс ребенка:</strong> '. $feed['userClass'] .'<br>'.
											'<strong>ФИО:</strong> '. $feed['userFio'] .'<br>'.
                      '<strong>Телефон:</strong> ' . $feed['userPhone'] . '<br>' .
                      '<strong>E-почта:</strong> ' . $feed['userEmail'] . '<br>'.
                      '<strong>Текст:</strong> ' . $feed['userText'] . '<br>';
			$res['test'] = $feed;
      if($feed['userFio'] and $feed['userClass'] and $feed['userEmail'] and $feed['userText']) {
				$args = array(
					'post_type' => 'distance_education'
				);
				$the_query = new WP_Query($args);
				$count = $the_query->found_posts + 1;
        $new_post = array(
        'ID'             => "", // Вы обновляете существующий пост?
        'menu_order'     => "", // Если запись "постоянная страница", установите её порядок в меню.
        'comment_status' => 'closed' | 'open', // 'closed' означает, что комментарии закрыты.
        'ping_status'    => 'closed' | 'open', // 'closed' означает, что пинги и уведомления выключены.
        'pinged'         => "",  //?
        'post_author'    => 1, // ID автора записи
        'post_content'   => $postContent, // Полный текст записи.
        'post_date'      => date('Y-m-d H:i:s'), // Время, когда запись была создана.
        'post_date_gmt'  => date('Y-m-d H:i:s'), // Время, когда запись была создана в GMT.
        'post_excerpt'   => "", // Цитата (пояснительный текст) записи.
        'post_name'      => "", // Альтернативное название записи (slug) будет использовано в УРЛе.
        'post_parent'    => "", // ID родительской записи, если нужно.
        'post_password'  => "", // Пароль для просмотра записи.
        'post_status'    => 'unread', // Статус создаваемой записи. 'draft' | 'publish' | 'pending'| 'future' | 'private'
        'post_title'     => 'Вопрос № ' . $count, // Заголовок (название) записи.
        'post_type'      => 'distance_education',// Тип записи.
        'post_category'  => array(), // Категория к которой относится пост (указываем ярлыки, имена или ID).
        'tags_input'     => array(), // Метки поста (указываем ярлыки, имена или ID).
        // 'tax_input'      => array( 'taxonomy_name' => array() ), // К каким таксам прикрепить запись (указываем ярлыки, имена или ID).
        'to_ping'        => "", //?
        // 'meta_input'     => [ 'meta_key'=>'meta_value' ], // добавит указанные мета поля. По умолчанию: ''. с версии 4.4.
        );
        $post_id = wp_insert_post($new_post);
        $post = get_post($post_id);
				update_post_meta($post_id, "distance_education_name", $feed['userFio']);
				update_post_meta($post_id, "distance_education_phone", $feed['userPhone']);
				update_post_meta($post_id, "distance_education_email", $feed['userEmail']);
				update_post_meta($post_id, "distance_education_class", $feed['userClass']);
				update_post_meta($post_id, "distance_education_text", $feed['userText']);
				if($post->ID){
					$res['success'] = true;
					$res['message'] = '<div class="message success">
																<i class="fa fa-check-circle-o"></i>
																<h3 class="label">Ваш вопрос принят</h3>
																<a href="#!">Закрыть</a>
														</div>';
					$res['chaptcha'] = $is_valid;
					$res['sendEmail'] = distance_education_sendEmail($feed, $post);
					
				}else{
					$res['message'] = '<div class="message success">
																<i class="fa fa-exclamation-triangle"></i>
																<h3 class="label">Возникла ошибка, сообщение не доставлено! Попробуйте отправить еще раз.</h3>
																<a href="#!">Закрыть</a>
														</div>';
					$res['chaptcha'] = $is_valid;
				}
      }else{
				$res['message'] = '<div class="message success">
															<i class="fa fa-exclamation"></i>
															<h3 class="label">Извините, но Вы не заполнили обязательные поля.</h3>
															<a href="#!">Закрыть</a>
													</div>';
			}
    }else{
      $res['message'] = '<div class="message success">
														<i class="fa fa-exclamation"></i>
                            <h3 class="label">Извините, но Вы не прошли каптчу.</h3>
                            <a href="#!">Закрыть</a>
                        </div>';
      $res['chaptcha'] = $is_valid;
    }
  }

  echo json_encode($res);
die();
}

// функция отправки оповещения на Е-почту
function distance_education_sendEmail($feed, $post){
	$postHref = site_url ().'/wp-admin/post.php?post='.$post->ID.'&action=edit';
	$to = 'masterit15@yandex.ru';//'internat123@mon.alania.gov.ru'; //обратите внимание на запятую
	$subject = "Сообщение из формы сайта";
	$headers= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$message = '<strong>Класс ребенка:</strong> '. $feed['userClass'] .'<br>'.
						 '<strong>ФИО:</strong> '. $feed['userFio'] .'<br>'.
						 '<strong>Телефон:</strong> ' . $feed['userPhone'] . '<br>' .
						 '<strong>E-почта:</strong> ' . $feed['userEmail'] . '<br>'.
						 '<strong>Текст:</strong> ' . $feed['userText'] . '<br>'.
						 '<strong>Ссылка заявки:</strong> <a href="'.$postHref.'">'.$post->post_title.'</a><br><hr>';
	$send = mail($to, $subject, $message, $headers);
	return $send;
}