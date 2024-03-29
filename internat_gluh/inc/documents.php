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
	add_meta_box("documents", "Документы (допустимые форматы: jpeg,jpg,png,tif,gif,pdf,doc,docx,xls,xlsx,zip,rar)", "documents", 'documents', "normal", "low");
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
	$file['original_name'] = get_the_title($fileid);
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
		if ($custom['documents'][0]) { ?>
			<ul id="post_document_list" class="document_list">
				<? if (str_contains($custom['documents'][0], ',')) {
					$attach_ids = explode(',', $custom['documents'][0]);
					foreach ($attach_ids as $attach_id) {
						$file = getFileArr($attach_id);
						// PR($file);
						$name =  array_shift(explode('.', $file['name']));

				?>
						<li class="document_list_item" data-id="<?= $file['id'] ?>" data-post="<?=$post->ID?>">
							<div class="document_list_item_wrap">
								<span class="file_icon"><?= $file['icon'] ?></span>
								<span class="file_name"> <input type="text" name="file_name" id="file-<?= $file['id'] ?>" value="<?= $file['original_name'] ?>" disabled /></span>
								<span class="file_size"><?= $file['size'] ?></span>
							</div>
							<div class="file_action">
								<span class="file_edit" data-url="<?php echo site_url() ?>/wp-admin/admin-ajax.php?action=documentEdit"><i class="fa fa-pencil"></i></span>
								<span class="file_delete" data-url="<?php echo site_url() ?>/wp-admin/admin-ajax.php?action=documentDelete"><i class="fa fa-times"></i></span>
								<span class="file_link"><a href="<?= $file['path'] ?>" target="_blank"><i class="fa fa-link"></i></a></span>
							</div>
						</li>
					<? }
				} else {
					$file = getFileArr($custom['documents'][0]);
					?>
					<li class="document_list_item" data-id="<?= $file['id'] ?>" data-post="<?=$post->ID?>">
						<div class="document_list_item_wrap">
							<span class="file_icon"><?= $file['icon'] ?></span>
							<span class="file_name"> <input type="text" name="file_name" id="file-<?= $file['id'] ?>" value="<?= $file['original_name']?>" disabled /></span>
							<span class="file_size"><?= $file['size'] ?></span>
						</div>
						<div class="file_action">
							<span class="file_edit" data-url="<?php echo site_url() ?>/wp-admin/admin-ajax.php?action=documentEdit"><i class="fa fa-pencil"></i></span>
							<span class="file_delete" data-url="<?php echo site_url() ?>/wp-admin/admin-ajax.php?action=documentDelete"><i class="fa fa-times"></i></span>
							<span class="file_link"><a href="<?= $file['path'] ?>"><i class="fa fa-link"></i></a></span>
						</div>
					</li>
				<? } ?>
			</ul>
		<? } ?>
		<div class="group">
			<div class="form_row__photo-previews">
				<input type="file" name="files[]" multiple id="js-photo-upload">
				<input type="hidden" name="documents" id="documents_ids" value="<?=$custom['documents'][0]?>">
				<div class="add_photo-content">
				<div class="progress_bar"></div>
					<div class="add_photo-item"></div>
					<ul id="uploadImagesList" class="document_list">
						<li class="document_list_item">
							<div class="document_list_item_wrap">
							<span class="img-wrap file_icon"></span>
							<span class="file_name"></span>
							<span class="file_size">0KB</span>
							</div>
							<div class="file_action">
							<span class="file_edit"><i class="fa fa-pencil"></i></span>
							<span class="file_delete delete" title="Удалить">
								<i class="fa fa-times"></i>
							</span>
							<span class="file_link"><a href="#"><i class="fa fa-link"></i></a></span>
							</div>
						</li>
					</ul>
				</div>
				<div class="errormassege"></div>
				<a href="#!" class="btn" data-url="<?php echo site_url() ?>/wp-admin/admin-ajax.php?action=documentsUpload">Прикрепить</a>
			</div>
		</div>
	</div>
<?
}
// ajax функция добавления документа(ов)
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

// ajax функция редактирования названия документа
add_action('wp_ajax_documentEdit', 'documentEdit'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_documentEdit', 'documentEdit');
function documentEdit()
{
	$res = array('success'=> false);
	$id = $_POST['pid'];
	$title = $_POST['title'];
	$attachment = array(
			'ID' => $id,
			'post_title' => $title,
	);
	// now update main post body
	if(wp_update_post( $attachment )){
		$res['success'] = true;
	}
	// die();
	$res['pid']=$id;
	$res['title']=$title;
	echo wp_send_json($res);
	exit;
}
// ajax функция удаления документа
add_action('wp_ajax_documentDelete', 'documentDelete'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_documentDelete', 'documentDelete');
function documentDelete()
{
	$res = array('success'=> false);
	if(wp_delete_attachment($_POST['fileId'], true )){
		$res['success'] = true;
		$res['update_docs'] = update_post_meta($_POST['post'], "documents", $_POST["docs"]);
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
	$file = getFileArr($attach_id);
	$html = '<li class="document_list_item" data-id="'.$file['id'].'" data-post="<?=$post->ID?>">
						<div class="document_list_item_wrap">
							<span class="file_icon">'.$file['icon'].'</span>
							<span class="file_name"> <input type="text" name="file_name" id="file-'.$file['id'].'" value="'.$file['original_name'].'" disabled /></span>
							<span class="file_size">'.$file['size'].'</span>
						</div>
						<div class="file_action">
							<span class="file_edit" data-url="'.site_url().'/wp-admin/admin-ajax.php?action=documentEdit"><i class="fa fa-pencil"></i></span>
							<span class="file_delete" data-url="'.site_url().'/wp-admin/admin-ajax.php?action=documentDelete"><i class="fa fa-times"></i></span>
							<span class="file_link"><a href="'.$file['path'].'"><i class="fa fa-link"></i></a></span>
						</div>
					</li>';
	return array("file"=>$attach_id,"html"=>$html);
}
// создаем свой шорткод для вывода на страницах - записях
add_shortcode('documents', 'documents_shortcode');

function documents_shortcode($atts)
{
	$atts = shortcode_atts([
		'docs' => '', // категории документов
		'files'  => '', // документы
	], $atts);
	return getPostByMyFilter($atts['docs'], $atts['files']);
	// PR(getPostByMyFilter($atts['docs'], $atts['files']));
	// return '<div class="col-md-4 promo-block">
	//           <h3>'.$atts['docs'].'</h3>
	//           <p>'.$atts['files'].'</p>
	//         </div>';

?>


<? }
function getPostByMyFilter($docs = '', $files = '')
{
	$html = '';
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
			while ($reviews->have_posts()) {
				global $post;
				$reviews->the_post();
				$custom = get_post_custom($post->ID);
				$filesId = explode(',', $custom['documents'][0]);
				if (count($filesId) > 1) {
					$li = '';
					foreach ($filesId as $arProperty) {
						$file = getFileArr($arProperty);
						$li .= '<li class="folder-item js_folder-item" data-id="' . $file['id'] . '">
							<a class="folder-item-wrap" href="' . $file['path'] . '">
								<div class="folder-item__icon">' . $file['icon'] . '</div>
								<div class="folder-item__details">
									<div class="folder-item__details__name">
									' . $file['name'] . '
									</div>
								</div>
								<div class="folder-item__size">' . $file['size'] . '</div>
							</a>
						</li>';
					}

					$html .= '<div class="folder">
										<div class="folder-summary js_toggle-folder">
											<div class="folder-summary__start">
												<div class="folder-summary__file-count">
													<span class="folder-summary__file-count__amount">' . count($filesId) . '</span>
													<i class="fa fa-folder"></i>
													<i class="fa fa-folder-open"></i>
												</div>
											</div>
											<div class="folder-summary__details">
												<div class="folder-summary__details__name">
													' . $post->post_title . '
												</div>
												<div class="folder-summary__details__share">
												' . $post->post_date . '
												</div>
											</div>
											<div class="folder-summary__end">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
													<path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" />
												</svg>
											</div>
										</div>
										<ul class="folder-content">
										' . $li . '
										</ul>
									</div>';
				} else {
					$file = getFileArr($filesId[0]);
					'<div class="doc_item item" title="' . $file['name'] . '" data-id="' . $file['id'] . '">
											<a href="' . $file['path'] . '">
												<span class="doc_icon">
												' . $file['icon'] . '
												</span>
												<div class="doc_detail">
													<div class="doc_title">
													' . $file['name'] . '
													</div>
													<span class="doc_date">
													' . the_date() . '
													</span>
												</div>
												<span class="doc_size">' . $file['size'] . '</span>
											</a>
										</div>';
				}; // if(count($filesId) > 1)
			}
		}
		wp_reset_postdata();
	}
	if ($files != '') {
		if (strpos($files, ',')) {
			$filesArr = explode(',', $files);
			foreach ($filesArr as $file) {
				$file = getFileArr($file);
				$html .= '<div class="doc_item item" title="' . the_title() . '" data-id="' . $file['id'] . '">
										<a href="' . $file['path'] . '">
											<span class="doc_icon">
											' . $file['icon'] . '
											</span>
											<div class="doc_detail">
												<div class="doc_title">
												' . $file['name'] . '
												</div>
												<span class="doc_date">
												' . the_date() . '
												</span>
											</div>
											<span class="doc_size">' . $file['size'] . '</span>
										</a>
									</div>';
			}
		} else {
			$file = getFileArr($files);
			$html .= '<div class="doc_item item" title="' . the_title() . '" data-id="' . $file['id'] . '">
										<a href="' . $file['path'] . '">
											<span class="doc_icon">
											' . $file['icon'] . '
											</span>
											<div class="doc_detail">
												<div class="doc_title">
												' . $file['name'] . '
												</div>
												<span class="doc_date">
												' . the_date() . '
												</span>
											</div>
											<span class="doc_size">' . $file['size'] . '</span>
										</a>
									</div>';
		}
	}
	return $html;
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
		<form id="filter" data-url="<?php echo site_url() ?>/wp-admin/admin-ajax.php?action=docfiltersAdmin">
			<div class="fields_group">
				<input type="text" name="name" id="f_name">
				<label for="f_name">По названию</label>
			</div>
			<div class="fields_group">
				<select name="f_cat" class="f_cat_list">
					<option value="#">По разделу</option>
					<?
					$terms = get_terms([
						'taxonomy' => 'documents-cat',
						'hide_empty' => false,
					]);
					foreach ($terms as $term) {
						$cat = (array) $term;
					?>
						<option value="<?= $cat['term_id'] ?>"><?= $cat['name'] ?></option>
					<? } ?>
				</select>
			</div>
			<div class="fields_group">
				<input id="f_date" name="date" type="text" class="datepicker-here" />
				<label for="f_date">По дате от - до</label>
			</div>
		</form>
		<div class="documents_wrap">
			<div style="padding: 0 20px;">
				<?
				$current_page = !empty($_GET['paged']) ? $_GET['paged'] : 1;
				$query = new WP_Query(
					array(
						'post_type' => 'documents',
						'post_status' => 'publish',
						'posts_per_page' => 20,
						'paged'          => $current_page,
					)
				);

				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();
						$custom = get_post_custom($post->ID);
						$filesId = explode(',', $custom['documents'][0]);
						if (count($filesId) > 1) {
				?>
							<div class="folder">
								<span class="checked" data-id="<?= get_the_ID() ?>"><i class="fa fa-check-square-o"></i></span>
								<div class="folder-summary js_toggle-folder">
									<div class="folder-summary__start">

										<div class="folder-summary__file-count">
											<span class="folder-summary__file-count__amount"><?= count($filesId) ?></span>
											<i class="fa fa-folder"></i>
											<i class="fa fa-folder-open"></i>
										</div>
									</div>
									<div class="folder-summary__details">
										<div class="folder-summary__details__name">
											<? the_title() ?>
										</div>
										<div class="folder-summary__details__share">
											<? the_date() ?>
										</div>
									</div>
									<div class="folder-summary__end">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
											<path d="M6 12c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zm9 0c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z" />
										</svg>
									</div>
								</div>
								<ul class="folder-content">
									<? foreach ($filesId as $arProperty) {
										$file = getFileArr($arProperty);
									?>
										<li class="folder-item js_folder-item" data-id="<?= $file['id']; ?>">
											<span class="folder-item-wrap">
												<span class="checked"><i class="fa fa-check-square-o"></i></span>
												<div class="folder-item__icon"><?= $file['icon']; ?></div>
												<div class="folder-item__details">
													<div class="folder-item__details__name">
														<?= $file['desc'] ? $file['desc'] : $file['name']; ?>
													</div>
												</div>
												<div class="folder-item__size"><?= $file['size']; ?></div>
											</span>
										</li>
									<? } ?>
								</ul>
							</div>
						<? } else {
							$file = getFileArr($filesId[0]);
						?>
							<div class="doc_item item" title='<?= the_title() ?>' data-id="<?= $file['id']; ?>">
								<span class="doc_item_wrap">
									<span class="checked"><i class="fa fa-check-square-o"></i></span>
									<span class="doc_icon">
										<?= $file['icon'] ?>
									</span>
									<div class="doc_detail">
										<div class="doc_title">
											<?= $file['name']; ?>
										</div>
										<span class="doc_date">
											<? the_date() ?>
										</span>
									</div>
									<span class="doc_size"><?= $file['size'] ?></span>
								</span>
							</div>
				<? }
					}
				}
				?>
			</div>
			<nav class="pagination">
				<? // я упомянул, что функция ничего не возвращает, если всего только 1 страница постов?
				echo paginate_links(array(
					'base' => site_url() . '%_%',
					'format' => '?paged=%#%',
					'total' => $query->max_num_pages,
					'current' => $current_page,
					'prev_next'    => True,
					'prev_text'    => __('« '),
					'next_text'    => __('»'),
					'mid_size' => 3,
					'end_size' => 2,
				));

				wp_reset_postdata(); // чтобы ничего не поломать
				?>
			</nav>
		</div>
		<a href="#!" class="add_shortcode">Добавить</a>
	</div>
<?
	die;
}
add_action('save_post', 'change_default_title_by_doc_name');
function change_default_title_by_doc_name($post_id)
{

	if (!wp_is_post_revision($post_id)) {
		$title = get_the_title($post_id);
		if (!$title || $title == "Черновик") {
			$custom = get_post_custom($post_id);
			$filesId = explode(',', $custom['documents'][0]);
			$file = getFileArr($filesId[0]);
			// удаляем этот хук, чтобы он не создавал бесконечного цикла
			remove_action('save_post', 'change_default_title_by_doc_name');
			// Update post
			$my_post = array(
				'ID'           => $post_id,
				'post_title'   => $file['name'], // new title
			);
			// обновляем пост, когда снова вызовется хук save_post
			wp_update_post($my_post);

			// снова вешаем хук
			add_action('save_post', 'change_default_title_by_doc_name');
		}
	}
}
