<?
add_action('init', 'my_custom_documents');
function my_custom_documents() {
	register_post_type('documents', array(
		'labels' => array(
			'name' => 'Документы',
			'singular_name' => 'Документы',
			'add_new' => 'Добавить документ',
			'add_new_item' => 'Добавить новый документ',
			'edit_item' => 'Редактировать документ',
			'new_item' => 'Новый документ',
			'view_item' => 'Посмотреть документ',
			'search_items' => 'Найти документ',
			'not_found' => 'Документов не найдено',
			'not_found_in_trash' => 'В корзине документы не найдены',
			'parent_item_colon' => '',
			'menu_name' => 'Документы',

		),
		'public' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'documents', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title'),
		'show_in_rest' => true,
		'rest_base' => 'documents',
	));
	// Добавляем для кастомных типо записей Категории
	// register_taxonomy(
	// 	"documents-cat",
	// 	array("documents"),
	// 	array(
	// 		"hierarchical" => true,
	// 		"label" => "Категории",
	// 		"singular_label" => "Категория",
	// 		"rewrite" => array('slug' => 'documents', 'with_front' => false),
	// 	)
	// );
}
function admin_js() {
  global $post;
	if ($post) {
    wp_enqueue_script( 'jquery-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js' );
    wp_enqueue_script( 'admin-script', get_template_directory_uri() . '/admin.js' );
  }
}
add_action('admin_enqueue_scripts', 'admin_js');

//Дополнительные поля продукта
add_action("admin_init", "documents_init");
add_action('save_post', 'save_documents');
function documents_init() {
		add_meta_box("documents", "Контактные данные", "documents", 'documents', "normal", "low");
}
// Функция сохранения полей продукта "Цена" и "Тираж"
function save_documents() {
  if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
  }
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post->ID, "documents", $_POST["documents"]);
	}
}
//Дополнительные поля продукта html
function documents() {
	global $post;
	$custom = get_post_custom($post->ID);
	$link    = $custom["_link"][0];
	?>
		<div class="documents">
			<div class="group">
					<?if ($custom['documents_document']) {?>
						<input class="documents_document" name="document" type="text" value="<?=$custom['documents_document'][0]?>">
					<?} else {?>
            <div class="form_row__photo-previews">
								<input type="file" name="files[]" multiple id="js-photo-upload">
								<div class="add_photo-content">
									<div class="add_photo-item"></div>
									<ul id="uploadImagesList">
										<li class="item">
											<span class="img-wrap">
												<img src="" alt="">
											</span>
											<span class="icon-wrap">
												<i class="fa"></i>
											</span>
											<span class="delete-link" title="Удалить">
                      <i class="fa-solid fa-circle-xmark"></i>
											</span>
										</li>
									</ul>
								</div>
								<div class="errormassege"></div>
								<p class="app_form_comments">Допустимые форматы: jpeg,jpg,png,tif,gif,pdf,doc,docx,xls,xlsx,zip,rar</p>
							</div>
					<?}?>
			</div>
		</div>
<?




}