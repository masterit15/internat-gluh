<?

/**
 * internat_gluh Theme Customizer
 *
 * @package internat_gluh
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
		'publicly_queryable' => false,
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