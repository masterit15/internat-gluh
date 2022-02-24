<?
add_action('init', 'my_custom_useful_link');
function my_custom_useful_link() {
	register_post_type('useful_link', array(
		'labels' => array(
			'name' => 'Полезные ресурсы',
			'singular_name' => 'Ссылки',
			'add_new' => 'Добавить ссылку',
			'add_new_item' => 'Добавить новую ссылку',
			'edit_item' => 'Редактировать ссылку',
			'new_item' => 'Новая ссылка',
			'view_item' => 'Посмотреть ссылку',
			'search_items' => 'Найти ссылку',
			'not_found' => 'Ссылок не найдено',
			'not_found_in_trash' => 'В корзине ссылок не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Полезные ресурсы',

		),
		'public' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'useful_link', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail'),
		'show_in_rest' => true,
		'rest_base' => 'useful_link',
	));
	// Добавляем для кастомных типо записей Категории
	// register_taxonomy(
	// 	"useful_link-cat",
	// 	array("useful_link"),
	// 	array(
	// 		"hierarchical" => true,
	// 		"label" => "Категории",
	// 		"singular_label" => "Категория",
	// 		"rewrite" => array('slug' => 'useful_link', 'with_front' => false),
	// 	)
	// );
}
?>