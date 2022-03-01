<?
add_action('init', 'my_custom_contact_data');
function my_custom_contact_data() {
	register_post_type('contact_data', array(
		'labels' => array(
			'name' => 'Контактные данные',
			'singular_name' => 'Контакты',
			'add_new' => 'Добавить Контакт',
			'add_new_item' => 'Добавить новый Контакт',
			'edit_item' => 'Редактировать Контакт',
			'new_item' => 'Новый Контакт',
			'view_item' => 'Посмотреть Контакт',
			'search_items' => 'Найти Контакт',
			'not_found' => 'Контактов не найдено',
			'not_found_in_trash' => 'В корзине Контактов не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Контактные данные',

		),
		'public' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'contact_data', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title'),
		'show_in_rest' => true,
		'rest_base' => 'contact_data',
		'menu_icon' => 'dashicons-phone'
	));
	// Добавляем для кастомных типо записей Категории
	// register_taxonomy(
	// 	"contact_data-cat",
	// 	array("contact_data"),
	// 	array(
	// 		"hierarchical" => true,
	// 		"label" => "Категории",
	// 		"singular_label" => "Категория",
	// 		"rewrite" => array('slug' => 'contact_data', 'with_front' => false),
	// 	)
	// );
}

//Дополнительные поля продукта
add_action("admin_init", "contact_data_init");
add_action('save_post', 'save_contact_data');
function contact_data_init() {
		add_meta_box("contact_data", "Контактные данные", "contact_data", 'contact_data', "normal", "low");
}
// Функция сохранения полей продукта "Цена" и "Тираж"
function save_contact_data() {
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post->ID, "contact_data_fio", $_POST["fio"]);
		update_post_meta($post->ID, "contact_data_email", $_POST["email"]);
		update_post_meta($post->ID, "contact_data_phone", $_POST["phone"]);
	}
}
//Дополнительные поля продукта html
function contact_data() {
	global $post;
	$custom = get_post_custom($post->ID);
	$link    = $custom["_link"][0];
	?>
	<div class="rates">
		<div class="contact_datas">
			<div class="group">
				<label>ФИО:</label>
					<?if ($custom['contact_data_fio']) {?>
						<input class="contact_datas_fio" name="fio" type="text" value="<?=$custom['contact_data_fio'][0]?>">
					<?} else {?>
						<input class="contact_datas_fio" name="fio" type="text">
					<?}?>
			</div>
			<div class="group">
				<label>Е-почта:</label>
					<?if ($custom['contact_data_email']) {?>
						<input class="contact_datas_email" name="email" type="text" value="<?=$custom['contact_data_email'][0]?>">
					<?} else {?>
						<input class="contact_datas_email" name="email" type="text">
					<?}?>
			</div>
			<div class="group">
				<label>Телефон(ы)(писать через запятую, приме "+78008008080,+79009009090"):</label>
					<?if ($custom['contact_data_phone']) {?>
						<input class="contact_datas_phone" name="phone" type="text" value="<?=$custom['contact_data_phone'][0]?>">
					<?} else {?>
						<input class="contact_datas_phone" name="phone" type="text">
					<?}?>
			</div>
		</div>
	</div>
<?
}