<?
add_action('init', 'my_custom_documents');
function my_custom_documents()
{
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
		'menu_icon' => 'dashicons-media-document'
	));
	// Добавляем для кастомных типо записей Категории
	register_taxonomy(
		"documents-cat",
		array("documents"),
		array(
			"hierarchical" => true,
			"label" => "Разделы",
			"singular_label" => "Раздел",
			"rewrite" => array('slug' => 'documents', 'with_front' => false),
		)
	);
}

//Дополнительные поля продукта
add_action("admin_init", "documents_init");
add_action('save_post', 'save_documents');
function documents_init()
{
	add_meta_box("documents", "Документы", "documents", 'documents', "normal", "low");
}
// Функция сохранения полей продукта "Цена" и "Тираж"
function save_documents()
{
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
		}
		update_post_meta($post->ID, "documents", $_POST["documents"]);
	}
}
// конвертируем байты 
function formatBytes($bytes, $precision = 2)
{

	if ($bytes >= 1073741824) {
		$bytes = number_format($bytes / 1073741824, 2) . 'GB';
	} elseif ($bytes >= 1048576) {
		$bytes = number_format($bytes / 1048576, 2) . 'MB';
	} elseif ($bytes >= 1024) {
		$bytes = number_format($bytes / 1024, 2) . 'KB';
	} elseif ($bytes > 1) {
		$bytes = $bytes . 'байты';
	} elseif ($bytes == 1) {
		$bytes = $bytes . 'байт';
	} else {
		$bytes = '0байтов';
	}

	return $bytes;
}
// выводит иконку документа, имя, путь, размер файла
function getFileArr($fileid)
{
	$fileArr = pathinfo(wp_get_attachment_url($fileid));
	$file['path'] = $fileArr["dirname"] . '/' . $fileArr["basename"];
	$file['size'] = formatBytes(filesize(get_attached_file($fileid)));
	$file['name'] = $fileArr["basename"];
	$file['type'] = $fileArr["extension"];
	$file['id'] = $fileid;
	switch (mb_strtolower($file['type'])) {
		case 'pdf':
			$ICON = 'fa-file-pdf-o';
			$ICON_COLOR = "#db544a";
			break;
		case 'jpeg':
		case 'png':
		case 'jpg':
		case 'tif':
			$ICON = 'fa-file-image-o';
			$ICON_COLOR = "#1f8490";
			break;
		case 'doc':
		case 'docx':
			$ICON = 'fa-file-word-o';
			$ICON_COLOR = "#0051a1";
			break;
		case 'rtf':
			$ICON = 'fa-file-text-o';
			$ICON_COLOR = "#6a5caf";
			break;
		case 'xls':
		case 'xlsx':
			$ICON = 'fa-file-excel-o';
			$ICON_COLOR = "#00823f";
			break;
		case 'zip':
		case '7zip':
		case '7z':
		case 'rar':
			$ICON = 'fa-file-archive-o';
			$ICON_COLOR = "#f3aa16";
			break;
		default:
			$ICON = 'fa-question';
			$ICON_COLOR = "#b5b4b5";
			break;
	}
	$file['icon'] = '<i class="fa ' . $ICON . '" style="color:' . $ICON_COLOR . '"></i>';
	return $file;
}
function documents()
{
	global $post;
	$custom = get_post_custom($post->ID);
?>
	<div class="documents">
		<?
		// PR($custom['documents'][0]);
		if ($custom['documents'][0]) { ?>
			<ul class="document_list">
				<? if (str_contains($custom['documents'][0], ',')) {
					$attach_ids = explode(',', $custom['documents'][0]);
					foreach ($attach_ids as $attach_id) {
						$file = getFileArr($attach_id);
				?>
						<li data-id="<?= $file['id'] ?>">
							<a class="document_list_item_wrap" href="<?= $file['path'] ?>">
								<span class="file_icon"><?= $file['icon'] ?></span>
								<span class="file_name"><?= $file['name'] ?></span>
								<span class="file_size"><?= $file['size'] ?></span>
							</a>
						</li>
					<? }
				} else {
					$file = getFileArr($custom['documents'][0]);
					?>
					<li data-id="<?= $file['id'] ?>">
						<a class="document_list_item_wrap" href="<?= $file['path'] ?>">
							<span class="file_icon"><?= $file['icon'] ?></span>
							<span class="file_name"><?= $file['name'] ?></span>
							<span class="file_size"><?= $file['size'] ?></span>
						</a>
					</li>
				<? } ?>
			</ul>
		<? } ?>
		<div class="group">
			<div class="form_row__photo-previews">
				<input type="file" name="files[]" multiple id="js-photo-upload">
				<input type="hidden" name="documents" id="documents_ids" value="<?= $custom['documents'][0] ?>">
				<div class="add_photo-content">
					<div class="add_photo-item"></div>
					<ul id="uploadImagesList">
						<li class="item">
							<span class="img-wrap"></span>
							<span class="delete-link" title="Удалить">
								<i class="fa fa-times"></i>
							</span>
						</li>
					</ul>
				</div>
				<div class="errormassege"></div>
				<p class="app_form_comments">Допустимые форматы: jpeg,jpg,png,tif,gif,pdf,doc,docx,xls,xlsx,zip,rar</p>
				<a href="#!" class="btn" data-url="<?php echo site_url() ?>/wp-admin/admin-ajax.php?action=documentsUpload">Прикрепить</a>
			</div>
		</div>
	</div>
<?

}
// ajax action для загрузки документов
add_action('wp_ajax_documentsUpload', 'documentsUpload'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_documentsUpload', 'documentsUpload');
function documentsUpload()
{
	global $post;
	if ($_FILES) {
		$files = $_FILES["files"];
		$res = array();
		foreach ($files['name'] as $key => $value) {
			if ($files['name'][$key]) {
				$file = array(
					'name' => $files['name'][$key],
					'type' => $files['type'][$key],
					'tmp_name' => $files['tmp_name'][$key],
					'error' => $files['error'][$key],
					'size' => $files['size'][$key]
				);
				$_FILES = array("my_file_upload" => $file);
				foreach ($_FILES as $file => $array) {
					$newupload[] = my_handle_attachment($file, $post->ID);
					if (count($newupload)) {
						$res['files'] = $newupload;
						$res['success'] = true;
					} else {
						$res['success'] = false;
					}
				}
			}
		}
	}
	echo json_encode($res);
	die();
}
// функция загрузки файлов в папку uploads
function my_handle_attachment($file_handler, $post_id, $set_thu = false)
{
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) {
		__return_false();
	}
	require_once ABSPATH . "wp-admin" . '/includes/image.php';
	require_once ABSPATH . "wp-admin" . '/includes/file.php';
	require_once ABSPATH . "wp-admin" . '/includes/media.php';
	$attach_id = media_handle_upload($file_handler, $post_id);
	return $attach_id;
}
// создаем свой шорткод для вывода на страницах - записях
add_shortcode('documents', 'documents_shortcode');

function documents_shortcode($atts)
{
	$atts = shortcode_atts([
		'cats' => '', // категории документов
		'docs' => '', // категории документов
		'files'  => '', // документы
	], $atts);
	$docArr = getPostByMyFilter($atts['cats'], $atts['docs'], $atts['files']);
	PR($docArr);
?>


<? }
function getPostByMyFilter($cats = '', $docs = '', $files = '')
{
	$result = array();
	if ($cats != '') {
		$reviews = new WP_Query(
			array(
				'post_type' => 'documents',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby'          => 'date',
				'order'            => 'ASC',
				'tax_query' => array(
					// 'relation' => 'AND',
					array(
						'taxonomy' => 'documents-cat',
						'field' => 'id',
						'terms' => explode(',', $cats),
						'operator' => 'IN',
					)
				),
			)
		);
		if ($reviews->have_posts()) {
			$i = 0;
			while ($reviews->have_posts()) {
				$reviews->the_post();
				$result['documents'][] = (array) $reviews->posts[$i];
				$i++;
			}
		}
		wp_reset_postdata();
	}
	if ($docs != '') {
		$reviews = new WP_Query(
			array(
				'post_type' => 'documents',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby'          => 'date',
				'order'            => 'ASC',
				'post__in' => explode(',', $docs),
			)
		);
		if ($reviews->have_posts()) {
			$i = 0;
			while ($reviews->have_posts()) {
				$reviews->the_post();
				$result['documents'][] = (array) $reviews->posts[$i];
				$i++;
			}
		}
		wp_reset_postdata();
	}
	if ($files != '') {
		if (strpos($files, ',')) {
			$filesArr = explode(',', $files);
			foreach ($filesArr as $file) {
				$result['files'][] = getFileArr($file);
			}
		} else {
			$result['files'] = getFileArr($files);
		}
	}
	return $result;
}
// добавляем кнопку генерации шорткода для вывода на страницах - записях
add_action('media_buttons', 'add_my_media_button');

function add_my_media_button()
{
	echo '<a href="#!" data-url="' . site_url() . '/wp-admin/admin-ajax.php?action=documentsShortCodeForm" id="insert-documents" class="button"><span class="dashicons dashicons-media-text"></span>Прикрепить документы</a>';
}
// подгружаем форму генерации шорткода для вывода на страницах - записях
add_action('wp_ajax_documentsShortCodeForm', 'documentsShortCodeForm'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_documentsShortCodeForm', 'documentsShortCodeForm');
function documentsShortCodeForm()
{
?>
	<div class="document_modal_content">
		<select multiple name="documents_cat" id="documents_cat">
			<option value="#">Выберите раздел</option>
			<?php
			$cats = get_terms(
				array(
					'taxonomy'   => 'documents-cat',
					'hide_empty' => false,
				)
			);
			foreach ($cats as $cat) {
			?>
				<option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
			<? } ?>
		</select>
		<ul class="document_list">
			<?
			$reviews = new WP_Query(
				array(
					'post_type' => 'documents',
					'post_status' => 'publish',
				)
			);
			if ($reviews->have_posts()) {
				while ($reviews->have_posts()) {
					$reviews->the_post();
					$custom = get_post_custom($reviews->ID);
					$attach_ids = explode(',', $custom['documents'][0]);
					foreach ($attach_ids as $attach_id) {
						$file = getFileArr($attach_id);
			?>
						<li data-id="<?= $file['id'] ?>">
							<span class="document_list_item_wrap">
								<span class="file_icon"><?= $file['icon'] ?></span>
								<span class="file_name"><?= $file['name'] ?></span>
								<span class="file_size"><?= $file['size'] ?></span>
							</span>
						</li>
			<? }
				}
			} else {
				echo 'Ничего не найдено';
			}
			wp_reset_postdata(); ?>
		</ul>
		<input type="text" name="documents_shortcode" id="documents_shortcode" disabled>
		<a href="#!" class="add_shortcode">Добавить</a>
	</div>
<?
	die;
}
