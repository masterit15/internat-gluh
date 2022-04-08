<?

add_action('init', 'application');
function application() {
	register_post_type('application', array(
		'labels' => array(
			'name' => 'Заявки',
			'singular_name' => 'Заявка',
			'add_new' => 'Добавить заявку',
			'add_new_item' => 'Добавить новоую заявку',
			'edit_item' => 'Редактировать заявку',
			'new_item' => 'Новый питомец',
			'view_item' => 'Посмотреть заявку',
			'search_items' => 'Найти заявку',
			'not_found' => 'Заявок не найдено',
			'not_found_in_trash' => 'В корзине заявок не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Заявки',
		),
		'public' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'application', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title'),
		'show_in_rest' => true,
		'rest_base' => 'application',
		'menu_icon' => 'dashicons-email-alt'
	));
}

//Дополнительные поля 
add_action("admin_init", "application_field_init");
add_action('save_post', 'save_application_field');
function application_field_init() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		add_meta_box("application_field", "Данные об инициаторе", "application_field", 'application', "normal", "low");
	}
}
// Функция сохранения полей продукта "Цена" и "Тираж"
function save_application_field() {
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post_id, "application_name", $_POST['name']);
		update_post_meta($post_id, "application_phone", $_POST['phone']);
		update_post_meta($post_id, "application_email", $_POST['email']);
		update_post_meta($post_id, "application_age", $_POST['age']);
		update_post_meta($post_id, "application_specialist", $_POST['specialist']);
		update_post_meta($post_id, "application_service_type", $_POST['service_type']);
		update_post_meta($post_id, "application_specialist_shedule", $_POST['specialistShedule']);
		
		
	}
}
//Дополнительные поля продукта html
function application_field() {
	global $post;
	$custom = get_post_custom($post->ID);
	$spec = get_post($custom['application_specialist'][0]);
	$specCustom = get_post_custom($spec->ID);
	?>
	<div class="application">
		<div class="application_fields">
			<div class="group">
				<label>ФИО:</label>
				<input disabled class="application_fields_name" name="name" type="text" <?if ($custom['application_name']) {?>value="<?=$custom['application_name'][0]?>"<?}?>>
			</div>
			<div class="group">
				<label>Возраст ребенка:</label>
				<input disabled class="application_fields_name" name="age" type="number" <?if ($custom['application_age']) {?>value="<?=$custom['application_age'][0]?>"<?}?>>
			</div>
			<div class="group">
			<label>Вид оказания услуг:</label>
					<?
					$type = 'Вид оказания услуг';
					switch ($custom['application_service_type'][0]) {
						case 'full-time':
							$type = 'Очная';
							break;
						case 'remote':
							$type = 'Дистанционная';
							break;
					}
					?>
					<input disabled class="application_fields_service_type" name="service_type" type="text" <?if ($custom['application_service_type']) {?>value="<?=$type?>"<?}?>>
			</div>
			<div class="group">
				<label>Телефон:</label>
				<input disabled class="application_fields_phone" name="phone" type="text"  <?if ($custom['application_phone']) {?>value="<?=$custom['application_phone'][0]?>"<?}?>>
			</div>
			<div class="group">
				<label>Е-почта:</label>
				<input disabled class="application_fields_userEmail" name="email" type="text" <?if ($custom['application_email']) {?>value="<?=$custom['application_email'][0]?>"<?}?>>
			</div>
			<div class="group">
				<label>Специалист:</label>
				<input disabled class="application_fields_specialist" name="specialist" type="text" <?if ($custom['application_specialist']) {?>value="<?=$spec->post_title?>"<?}?>>
			</div>
		</div>
    <textarea id="application_specialist_shedule" name="specialistShedule" cols="50" rows="10"><?if ($custom['application_specialist_shedule']) {?><?=$custom['application_specialist_shedule'][0]?><?}?></textarea>
    <textarea id="specialists_field" name="specialists_shedule" id="" cols="50" rows="10"><?if ($specCustom['specialists_shedule'][0]) {?><?=$specCustom['specialists_shedule'][0]?><?}?></textarea>
	<?sheduleTable(explode(' ', $post->post_date)[0]);?>
	</div>
<?
}
// Регистрируем колонку 'ID' и 'Миниатюра'. Обязательно.
add_filter( 'manage_application_posts_columns', function ( $columns ) {
	$my_columns = [
		'name' => 'ФИО',
		'phone'=> 'Телефон',
		'email'=> 'E-почта',
		'specialist'=> 'Специалист'
	];

	return array_slice( $columns, 0, 1 ) + $columns + $my_columns ;
} );
// Выводим контент для каждой из зарегистрированных нами колонок. Обязательно.
add_action( 'manage_application_posts_custom_column', function ( $column_name ) {
	global $post;
	$custom = get_post_custom($post->ID);
	if ( $column_name === 'name' ) {
		echo $custom['application_name'][0];
	}
	if ( $column_name === 'phone' ) {
		echo $custom['application_phone'][0];
	}
	if ( $column_name === 'email' ) {
		echo $custom['application_email'][0];
	}
	if ( $column_name === 'specialist' ) {
		$getSpec = get_post($custom['application_specialist'][0]);
		echo $getSpec->post_title;
	}
	
} );

add_action( 'admin_menu', function() {
	global $menu;
	$posts = get_posts('post_type=application&suppress_filters=0&posts_per_page=-1&post_status=unread');
	$count = count($posts); 
	$menu[30][0] = $count > 0 ? 'Заявок <span class="awaiting-mod">' . $count. '</span>' : 'Заявки';
});
function true_status_unread(){
	register_post_status( 'unread', array(
		'label'                     => 'Не прочитанные',
		'label_count'               => _n_noop( 'Не прочитанные <span class="count">(%s)</span>', 'Не прочитанные <span class="count">(%s)</span>' ),
		'public'                    => true,
		'show_in_admin_status_list' => true // если установить этот параметр равным false, то следующий параметр можно удалить
	) );
}
add_action( 'init', 'true_status_unread' );

add_action('admin_footer-edit.php','true_status_unread_select');
function true_status_unread_select() {
	echo "<script>
	jQuery(document).ready( function($) {
		$( 'select[name=\"_status\"]' ).append( '<option value=\"unread\">Не прочитано</option>' );
	});
	</script>";
}

function true_status_unread_display( $statuses ) {
	global $post;
	if( get_query_var( 'post_status' ) != 'unread' ){ // проверка, что мы не находимся на странице всех постов данного статуса
		if($post->post_status == 'unread'){ // если статус поста - Архив
			return array('Не прочитанные');
		}
	}
	return $statuses;
}
 
add_filter( 'display_post_states', 'true_status_unread_display' );


function true_status_isread(){
	register_post_status( 'isread', array(
		'label'                     => 'Прочитанные',
		'label_count'               => _n_noop( 'Прочитанные <span class="count">(%s)</span>', 'Прочитанные <span class="count">(%s)</span>' ),
		'public'                    => true,
		'show_in_admin_status_list' => true // если установить этот параметр равным false, то следующий параметр можно удалить
	) );
}
add_action( 'init', 'true_status_isread' );


function true_status_isread_select() {
	echo "<script>
	jQuery(document).ready( function($) {
		$( 'select[name=\"_status\"]' ).append( '<option value=\"isread\">Прочитано</option>' );
	});
	</script>";
}
add_action('admin_footer-edit.php','true_status_isread_select');

function true_status_isread_display( $statuses ) {
	global $post;
	if( get_query_var( 'post_status' ) != 'isread' ){ // проверка, что мы не находимся на странице всех постов данного статуса
		if($post->post_status == 'isread'){ // если статус поста - Архив
			return array('Прочитанные');
		}
	}
	return $statuses;
}
 
add_filter( 'display_post_states', 'true_status_isread_display' );

if(isset($_GET['post']) && $_GET['action'] == 'edit' && get_post_type($_GET['post']) == 'application' && get_post_status($_GET['post']) == 'unread'){
	wp_update_post(array(
		'ID'    =>  $_GET['post'],
		'post_status'   =>  'isread'
		));
}
function uploadBase64Img($img){
		define('UPLOAD_DIR', "./imagesbase64");
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = UPLOAD_DIR . uniqid() . '.png';
    $success = file_put_contents($file, $data);
    return $success ? $file : 'Unable to save the file.';
}
add_action('wp_ajax_application', 'applicationHandler'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_application', 'applicationHandler');
function applicationHandler(){
	$res = array('success' => false);
  // Проверка, что есть POST запрос
  if ($_POST) {
    $is_valid = $_POST['captcha'] == '' ? true : false;
    if($is_valid){
      $feed = array(
				'specialist' => $_POST['specialist'],
				'specialistsCat' => $_POST['specialistsCat'],
				'specialistEmail' => $_POST['specialistEmail'],
				'specialistShedule' => $_POST['specialistShedule'],
				'specialistSheduleImg' => $_POST['specialistSheduleImg'],
				'specialistSheduleCheck' => $_POST['specialistSheduleCheck'],
				'specialistsServiceType' => $_POST['specialistsServiceType'],
				'userFio' => $_POST['userFio'],
				'userAge' => $_POST['userAge'],
				'userText' => $_POST['userText'],
				'userEmail' => $_POST['userEmail'],
				'userPhone' => $_POST['userPhone'],
      );
      $postContent =  '<strong>ФИО:</strong> '. $feed['userFio'] .'<br>'.
                      '<strong>Телефон:</strong> ' . $feed['userPhone'] . '<br>' .
                      '<strong>E-почта:</strong> ' . $feed['userEmail'] . '<br>'.
                      '<strong>Текст:</strong> ' . $feed['userText'] . '<br>';

      if($feed['userFio'] and $feed['userEmail'] and $feed['userPhone']) {
				$args = array(
					'post_type' => 'application'
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
        'post_title'     => 'Заявка № ' . $count, // Заголовок (название) записи.
        'post_type'      => 'application',// Тип записи.
        'post_category'  => array(), // Категория к которой относится пост (указываем ярлыки, имена или ID).
        'tags_input'     => array(), // Метки поста (указываем ярлыки, имена или ID).
        // 'tax_input'      => array( 'taxonomy_name' => array() ), // К каким таксам прикрепить запись (указываем ярлыки, имена или ID).
        'to_ping'        => "", //?
        // 'meta_input'     => [ 'meta_key'=>'meta_value' ], // добавит указанные мета поля. По умолчанию: ''. с версии 4.4.
        );
        $post_id = wp_insert_post($new_post);
        $post = get_post($post_id);
				update_post_meta($post_id, "application_name", $feed['userFio']);
				update_post_meta($post_id, "application_phone", $feed['userPhone']);
				update_post_meta($post_id, "application_email", $feed['userEmail']);
				update_post_meta($post_id, "application_age", $feed['userAge']);
				update_post_meta($post_id, "application_specialist", $feed['specialist']);
				update_post_meta($post_id, "application_specialist_cat", $feed['specialistsCat']);
				update_post_meta($post_id, "application_service_type", $feed['specialistsServiceType']);
				update_post_meta($post_id, "application_specialist_shedule", $feed['specialistShedule']);
				// обновляем график специалиста
				$applicationShedule = get_post_custom($post_id);
				$applicationShedule = json_decode($applicationShedule["application_specialist_shedule"][0], true);
				$i = 0;
				$bookingShedules = [];
				foreach($applicationShedule as $shedules){
					$shedules['book'] = true;
					$bookingShedules[] = $shedules;
					$i++;
				}
				// update_post_meta($feed['specialist'], "specialists_shedule", json_encode($specialistsShedule));
				update_post_meta($feed['specialist'], "specialists_shedule_book", json_encode($bookingShedules));
				$res['test'] = $applicationShedule;
          if($post->ID){
            $res['success'] = true;
            $res['message'] = '<div class="message success">
																	<i class="fa fa-check-circle-o"></i>
                                  <h3 class="label">Ваша заявка принята. Мы свяжемся с Вами в ближайшее время</h3>
                                  <a href="/">Закрыть</a>
                              </div>';
            $res['chaptcha'] = $is_valid;
            // $res['sendEmail'] = sendEmail($feed, $post);
            
          }else{
            $res['message'] = '<div class="message success">
																	<i class="fa fa-exclamation-triangle"></i>
                                  <h3 class="label">Возникла ошибка, сообщение не доставлено! Попробуйте отправить еще раз.</h3>
                                  <a href="/">Закрыть</a>
                              </div>';
            $res['chaptcha'] = $is_valid;
          }
      }
    }else{
      $res['message'] = '<div class="message success">
														<i class="fa fa-exclamation"></i>
                            <h3 class="label">Извините, но Вы не прошли каптчу.</h3>
                            <a href="/">Закрыть</a>
                        </div>';
      $res['chaptcha'] = $is_valid;
    }
  }

  echo json_encode($res);
die();
}

// функция отправки оповещения на Е-почту
function sendEmail($feed, $post){
	$postHref = site_url ().'/wp-admin/post.php?post='.$post->ID.'&action=edit';
	$to = $feed['specialistEmail'] != '' ? $feed['specialistEmail'].',internat123@mon.alania.gov.ru' : 'internat123@mon.alania.gov.ru'; //обратите внимание на запятую
	$subject = "Сообщение из формы сайта";
	$headers= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$message =  '<strong>ФИО:</strong> '. $feed['userFio'] .'<br><hr>'.
							'<strong>Возраст ребенка:</strong> ' . $feed['userAge'] . '<br><hr>' .
							'<strong>Вид оказания услуги:</strong> ' . $feed['specialistsServiceType'] . '<br><hr>' .
							'<strong>Телефон:</strong> ' . $feed['userPhone'] . '<br><hr>' .
							'<strong>E-почта:</strong> ' . $feed['userEmail'] . '<br><hr>'.
							'<strong>Текст:</strong> ' . $feed['userText'] . '<br><hr>'.
							'<strong>Ссылка заявки:</strong> <a href="'.$postHref.'">'.$post->post_title.'</a><br><hr>'.
							'<p>Выбранные дни - часы, отмечены желтым цветом в таблице!</p> <br>'.
							'<img style="width: 100%;" src="'.$feed['specialistSheduleImg'].'"/>';
	$send = mail($to, $subject, $message, $headers);
	return $send;
	// global $phpmailer;
	// 	if ( !is_object( $phpmailer ) || !is_a( $phpmailer, 'PHPMailer' ) ) { // проверяем, существует ли объект $phpmailer и принадлежит ли он классу PHPMailer
	// 		// если нет, то подключаем необходимые файлы с классами и создаём новый объект
	// 		require_once ABSPATH . WPINC . '/class-phpmailer.php';
	// 		require_once ABSPATH . WPINC . '/class-smtp.php';
	// 		$phpmailer = new PHPMailer( true );
	// 	}
  //   $postContent =  '<strong>ФИО:</strong> '. $feed['userFio'] .'<br>'.
	// 									'<strong>Телефон:</strong> ' . $feed['userPhone'] . '<br>' .
	// 									'<strong>E-почта:</strong> ' . $feed['userEmail'] . '<br>'.
	// 									'<strong>Текст:</strong> ' . $feed['userText'] . '<br>'.
	// 									'<img src="'.$feed['specialistSheduleImg'].'"/>';
	// 	$attachments = get_attached_media( '', $post_id); // получаем прикрепленные файлы по ИД сообщения
	// 	$phpmailer->ClearAttachments(); // если в объекте уже содержатся вложения, очищаем их
	// 	$phpmailer->ClearCustomHeaders(); // то же самое касается заголовков письма
	// 	$phpmailer->ClearReplyTos(); 
	// 	$phpmailer->From = 'jubo89@gmail.com'; // от кого, Email
	// 	$phpmailer->FromName = $feed['name']; // от кого, Имя
	// 	$phpmailer->Subject = 'Заявка с сайта от: '.$feed['userFio']; // тема
	// 	$phpmailer->SingleTo = true; // это означает, что если получателей несколько, то отображаться будет всё равно только один (если непонятно, спросите, я вам подробно объясню в комментариях)
	// 	$phpmailer->ContentType = 'text/html'; // тип содержимого письма
	// 	$phpmailer->IsHTML( true );
	// 	$phpmailer->CharSet = 'utf-8'; // кодировка письма
	// 	$phpmailer->ClearAllRecipients(); // очищаем всех получателей
	// 	$phpmailer->AddAddress('masterit15@yandex.ru'); // добавляем новый адрес получателя
	// 	$phpmailer->Body = 	$postContent;
	// 	// foreach ($attachments as $k => $file) { // перебираем массив файлов
	// 	// 	$attachment_url = get_attached_file($file->ID); // получаем полный путь к файлу
	// 	// 	$phpmailer->AddAttachment($attachment_url); // добавляем вложение
	// 	// }
	// 	return $phpmailer->Send(); // отправка письма
}