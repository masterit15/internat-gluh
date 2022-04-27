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
		'menu_position' => 38,
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
	$videoYoutube  = array_key_exists('video_youtube', $custom) ? $custom["video_youtube"][0] : '';
	$videoRutube  = array_key_exists('video_rutube', $custom) ? $custom["video_rutube"][0] : '';
?>
	<div class="field_wrap">
		<div class="one_colimn">
			<div class="video_fields">
				<div class="video_input">
					<input id="video-0" placeholder="Ссылка видео c youtube, rutube" type="text" name="video" />
				</div>
				<span class="add_video" data-url="<?php echo site_url() ?>/wp-admin/admin-ajax.php?action=getVideoPreview">Добавить</span>
			</div>
			<input type="hidden" name="video_youtube" <? if ($videoYoutube != '') { ?>value="<?= $videoYoutube ?>" <? } ?> />
			<input type="hidden" name="video_rutube" <? if ($videoRutube != '') { ?>value="<?= $videoRutube ?>" <? } ?> />
		</div>
		<div class="two_colimn">
			<?
			$videoArr = explode(',', $videoYoutube);
			if (count($videoArr) > 0) {
				foreach ($videoArr as $key => $vd) {
					if($vd){
				$json = file_get_contents('https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v='.$vd.'&format=json');
				$videoInfo = json_decode($json, true);
			?>
					<? if ($videoYoutube != '') { ?>
						<div class="video" data-video-id="<?= $vd ?>">
								<div class="video_frame">
										<img src="<?=$videoInfo['thumbnail_url']?>"/>
								</div>
								<p class="video_title"><?=$videoInfo['title']?></p>
								<span class="delete_video youtube" data-video-id="<?= $vd ?>"><i class="fa fa-times"></i></span>
						</div>
			<? }
			}
				}
			} ?>
			<?
			$videoArr = explode(',', $videoRutube);
			if (count($videoArr) > 0) {
				foreach ($videoArr as $key => $vd) {
					if($vd){
				$url = file_get_contents('http://rutube.ru/api/video/'.$vd.'?format=json');
				$videoInfo = json_decode($url, true);
			?>
					<? if ($videoRutube != '') { ?>
						<div class="video" data-video-id="<?= $vd ?>">
							<div class="video_frame">
								<img src="<?=$videoInfo['thumbnail_url']?>"/>
							</div>
							<p class="video_title"><?=$videoInfo['title']?></p>
							<span class="delete_video ruutube" data-video-id="<?= $vd ?>"><i class="fa fa-times"></i></span>
						</div>
			<? }}
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
		update_post_meta($post->ID, "video_youtube", $_POST["video_youtube"]);
		update_post_meta($post->ID, "video_rutube", $_POST["video_rutube"]);
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
	$videoYoutube    = explode(',', $custom["video_youtube"][0]);
	$videoRutube    = explode(',', $custom["video_rutube"][0]);
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
	foreach ($videoYoutube as $key => $vd) {
		$i++;
		if ($vd != '') {
			$json = file_get_contents('https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v='.$vd.'&format=json');
			$videoInfo = json_decode($json, true);
			if ($count >= $i) {
				echo '<div class="gallery_item"><a title="' . $videoInfo['title'] . '" class="popup-video" href="http://www.youtube.com/watch?v=' . $vd . '">
				<div class="gallery_item_media videobg" style="background-image: url('.$videoInfo['thumbnail_url'].')"></div><i class="fa fa-play-circle"></i></a></div>';
			}
		}
	}
	$videoInfo = array();
	foreach ($videoRutube as $key => $vd) {
		$i++;
		if ($vd != '') {
			$url = file_get_contents('http://rutube.ru/api/video/'.$vd.'?format=json');
			$videoInfo = json_decode($url, true);
			if ($count >= $i) {
				echo '<div class="gallery_item"><a title="' . $videoInfo['title'] . '" class="popup-video" href="https://rutube.ru/pl/?pl_id&pl_type&pl_video=' . $vd . '">
				<div class="gallery_item_media videobg" style="background-image: url('.$videoInfo['thumbnail_url'].')"></div><i class="fa fa-play-circle"></i></a></div>';
			}
		}
	}
	foreach($elArr as $key => $el){
		echo $el;
	}
}
