<?

/**
 * internat_gluh Theme Customizer
 *
 * @package internat_gluh
 */
// Добавляем кастомный тип записи слайды
add_action('init', 'my_custom_slider');
function my_custom_slider() {
	register_post_type('slider', array(
		'labels' => array(
			'name' => 'Слайды',
			'singular_name' => 'Слайд',
			'add_new' => 'Добавить слайд',
			'add_new_item' => 'Добавить новый слайд',
			'edit_item' => 'Редактировать слайд',
			'new_item' => 'Новаый слайд',
			'view_item' => 'Посмотреть слайд',
			'search_items' => 'Найти слайд',
			'not_found' => 'Слайдов не найдено',
			'not_found_in_trash' => 'В корзине слайдов не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Слайды',

		),
		'public' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'slider', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'thumbnail'),
		'show_in_rest' => true,
		'rest_base' => 'slider',
		'menu_icon' => 'dashicons-slides'
		
	));
	// Добавляем для кастомных типо записей Категории
	register_taxonomy(
		"slider-cat",
		array("slider"),
		array(
			"hierarchical" => true,
			"label" => "Категории",
			"singular_label" => "Категория",
			"rewrite" => array('slug' => 'slider', 'with_front' => false),
		)
	);
}