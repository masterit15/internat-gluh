<?
// Добавляем кастомный тип записи Галерея
add_action('init', 'my_custom_gallery');
function my_custom_gallery()
{
	register_post_type('gallery', array(
		'labels' => array(
			'name' => 'Галереи',
			'singular_name' => 'Галерея',
			'add_new' => 'Добавить галерею',
			'add_new_item' => 'Добавить новоую галерею',
			'edit_item' => 'Редактировать галерею',
			'new_item' => 'Новая галерея',
			'view_item' => 'Посмотреть галерею',
			'search_items' => 'Найти галерею',
			'not_found' => 'Галерей не найдено',
			'not_found_in_trash' => 'В корзине галерей не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Галереи',

		),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'rewrite' => array('slug' => 'gallery', 'with_front' => true),
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
		'show_in_rest' => true,
		'rest_base' => 'gallery',
		'menu_icon' => 'dashicons-format-gallery'
	));

	// Добавляем для кастомных типов записей Категории
	register_taxonomy(
		"gallery-cat",
		array("gallery"),
		array(
			"hierarchical" => true,
			"label" => "Категории",
			"singular_label" => "Категория",
			"rewrite" => array('slug' => 'gallery', 'with_front' => false),
		)
	);
}

add_action("admin_init", "gallery_field_init");
function gallery_field_init()
{
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if($post_type == 'gallery'){
			add_meta_box("gallery", "Ссылки на видео", "gallery_field_video", 'gallery', "normal", "low");
		}
		
	}
}

function gallery_field_video()
{
	global $post;
	$custom = get_post_custom($post->ID);
	$video  = array_key_exists('gallery', $custom) ? $custom["gallery"][0] : '';
?>
	<div class="field_wrap">
		<div class="one_colimn">
			<div class="fields">
				<div class="video_input">
					<input id="video-0" placeholder="Ссылка на видео" type="text" name="video" />
				</div>
				<span class="add_video">Добавить</span>
			</div>
			<input type="hidden" name="videos" <? if ($video != '') { ?>value="<?= $video ?>" <? } ?> />
		</div>
		<div class="two_colimn">
			<?
			$videoArr = explode(',', $video);
			if (count($videoArr) > 0) {
				foreach ($videoArr as $key => $vd) {
			?>
					<? if ($video != '') { ?>
						<div class="video" data-video-id="<?= $vd ?>">
							<div class="video_input">
								<input type="text" value="<?= $vd ?>" name="video-<?= $key ?>" />
							</div>
							<div class="video_frame">
								<img src="https://img.youtube.com/vi/<?= $vd ?>/0.jpg" />
							</div>
							<span class="delete_video" data-video-id="<?= $vd ?>">Удалить</span>
						</div>
			<? }
				}
			} ?>
		</div>
	</div>
<?
}
add_action('save_post', 'save_gallery_field');
function save_gallery_field()
{
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
		}
		update_post_meta($post->ID, "gallery", $_POST["videos"]);
	}
}

function nextAlbum($id)
{
	$prevId = '';
	$reviews = new WP_Query(
		array(
			'p' => $id,
			'post_type' => 'gallery',
			'post_status' => 'publish',
		)
	);
	if ($reviews->have_posts()) {
		while ($reviews->have_posts()) {
			$reviews->the_post();
			$prevId = get_previous_post();
		}
	}
	// wp_reset_postdata();
	return $prevId->ID;
}
//вывод элементов галереи ФОТО и ВИДЕО
function single_gallery($p, $count = 1000000000000000000){
	preg_match('~=(.*?)]~', $p->post_content, $output);
	preg_match('/"([^"]+)"/', $output[1], $ids);
	$array = explode(",", $ids[1]);
	$i = 0;
	$custom = get_post_custom($p->ID);
	$video    = explode(',', $custom["gallery"][0]);
	$elArr = array();
	foreach ($array as $key => $id) {
		$i++;
		if ($id != '') {
			if ($count >= $i) {
				$imgUrl = wp_get_attachment_image_src($id, 'large')[0];
				echo '<a class="gallery_item" title="' . $p->post_title . '" class="popup-image" href="' . $imgUrl . '"><div class="gallery_item_media" style="background-image: url(' . $imgUrl . ')"></div></a>';
			}
		}
	}
	foreach ($video as $key => $vd) {
		$i++;
		if ($vd != '') {
			if ($count >= $i) {
				echo '<div class="gallery_item"><a title="' . $p->post_title . '" class="popup-youtube" href="http://www.youtube.com/watch?v=' . $vd . '"><div class="gallery_item_media videobg" style="background-image: url(https://img.youtube.com/vi/' . $vd . '/0.jpg)"></div><i class="fa fa-play-circle"></i></a></div>';
			}
		}
	}
	foreach($elArr as $key => $el){
		echo $el;
	}
}
