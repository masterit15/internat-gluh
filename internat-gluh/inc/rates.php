<?
/**
 * yugtelecom Theme Customizer
 *
 * @package yugtelecom
 */
// Добавляем кастомный тип записи Тарифы
add_action('init', 'my_custom_rates');
function my_custom_rates() {
	register_post_type('rates', array(
		'labels' => array(
			'name' => 'Тарифы',
			'singular_name' => 'Tариф',
			'add_new' => 'Добавить тариф',
			'add_new_item' => 'Добавить новый тариф',
			'edit_item' => 'Редактировать тариф',
			'new_item' => 'Новаый тариф',
			'view_item' => 'Посмотреть тариф',
			'search_items' => 'Найти тариф',
			'not_found' => 'Тарифов не найдено',
			'not_found_in_trash' => 'В корзине тарифов не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Тарифы',

		),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'rates', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title'),
		'show_in_rest' => true,
		'rest_base' => 'rates',
	));
	// Добавляем для кастомных типо записей Категории
	register_taxonomy(
		"rates-cat",
		array("rates"),
		array(
			"hierarchical" => true,
			"label" => "Категории",
			"singular_label" => "Категория",
			"rewrite" => array('slug' => 'rates', 'with_front' => false),
		)
	);
}

//Дополнительные поля продукта
add_action("admin_init", "rates_field_init");
add_action('save_post', 'save_rates_field');
function rates_field_init() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		add_meta_box("rates_field", "Дополнительные поля", "rates_field", 'rates', "normal", "low");
	}
}
function admin_style() {
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');
if(get_post_type() == 'rates'){
	function admin_js() {
		wp_enqueue_script( 'jquery-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js' );
		wp_enqueue_script( 'admin-script', get_template_directory_uri() . '/admin.js' );
		
	}
	add_action('admin_enqueue_scripts', 'admin_js');

}


// Функция сохранения полей продукта "Цена" и "Тираж"
function save_rates_field() {
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post->ID, "rates_speed", $_POST["speed"]);
		update_post_meta($post->ID, "rates_boost", $_POST["boost"]);
		update_post_meta($post->ID, "rates_price", $_POST["price"]);
		update_post_meta($post->ID, "rates_price_apartment", $_POST["price_apartment"]);
		update_post_meta($post->ID, "rates_price_house", $_POST["price_house"]);
		update_post_meta($post->ID, "rates_popular", $_POST["popular"]);
	}
}
//Дополнительные поля продукта html
function rates_field() {
	global $post;
	$custom = get_post_custom($post->ID);
	$link    = $custom["_link"][0];
	?>
	<div class="rates">
		<div class="rates_fields">
			<div class="group">
				<label>Скорость:</label>
					<?if ($custom['rates_speed']) {?>
						<input class="rates_fields_speed" name="speed" type="text" value="<?=$custom['rates_speed'][0]?>">
					<?} else {?>
						<input class="rates_fields_speed" name="speed" type="text">
					<?}?>
			</div>
			<div class="group">
				<label>Ускорение:</label>
					<?if ($custom['rates_boost']) {?>
						<input class="rates_fields_boost" name="boost" type="text" value="<?=$custom['rates_boost'][0]?>">
					<?} else {?>
						<input class="rates_fields_boost" name="boost" type="text">
					<?}?>
			</div>
			<div class="group">
				<label>Цена (в месяц):</label>
					<?if ($custom['rates_price']) {?>
						<input class="rates_fields_price" name="price" type="number" value="<?=$custom['rates_price'][0]?>">
					<?} else {?>
						<input class="rates_fields_price" name="price" type="number">
					<?}?>
			</div>

			<div class="group">
				<label>Цена (подключения квартиры):</label>
					<?if ($custom['rates_price_apartment']) {?>
						<input class="rates_fields_price_apartment" name="price_apartment" type="number" value="<?=$custom['rates_price_apartment'][0]?>">
					<?} else {?>
						<input class="rates_fields_price_apartment" name="price_apartment" type="number" value="1500">
					<?}?>
			</div>
			<div class="group">
				<label>Цена (подключения дома):</label>
					<?if ($custom['rates_price_house']) {?>
						<input class="rates_fields_price_house" name="price_house" type="number" value="<?=$custom['rates_price_house'][0]?>">
					<?} else {?>
						<input class="rates_fields_price_house" name="price_house" type="number" value="4000">
					<?}?>
			</div>
			<div class="group">
				<label>Популярный тариф?:</label>
				<?if ($custom['rates_popular']) {?>
					<select name="popular">
						<option value="y" <?if($custom['rates_popular'][0] == "y"){?>selected<?}?>>Да</option>
						<option value="n" <?if($custom['rates_popular'][0] == "n"){?>selected<?}?>>Нет</option>
					</select>
				<?} else {?>
					<select name="popular">
						<option value="n" selected>Нет</option>
						<option value="y">Да</option>
					</select>
				<?}?>
			</div>

		</div>
	</div>
<?
}
