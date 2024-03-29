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
		'menu_icon' => 'dashicons-welcome-view-site'
		
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

//Дополнительные поля 
add_action("admin_init", "useful_link_init");

function useful_link_init() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		add_meta_box("useful_link", "Ссылка на ресурс", "useful_link_field", 'useful_link', "normal", "low");
	}
}

add_action('save_post', 'save_useful_link');

function save_useful_link() {
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post->ID, "useful_link", $_POST["useful_link"]);
	}
}
//Дополнительные поля продукта html
function useful_link_field() {
	global $post;
	$custom = get_post_custom($post->ID);
	$link    = $custom["useful_link"][0];
	?>
	<div class="group">
		<label>Ссылка:</label>
			<?if ($link) {?>
				<input class="useful_link" name="useful_link" type="text" value="<?=$link?>">
			<?} else {?>
				<input class="useful_link" name="useful_link" type="text">
			<?}?>
	</div>
<?
}