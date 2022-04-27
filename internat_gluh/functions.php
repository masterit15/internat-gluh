<?php
/**
 * internat_gluh functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package internat_gluh
 */
// функция отладки
function PR($var, $all = false, $die = false) {
	$bt = debug_backtrace();
	$bt = $bt[0];
	$dRoot = $_SERVER["DOCUMENT_ROOT"];
	$dRoot = str_replace("/", "\\", $dRoot);
	$bt["file"] = str_replace($dRoot, "", $bt["file"]);
	$dRoot = str_replace("\\", "/", $dRoot);
	$bt["file"] = str_replace($dRoot, "", $bt["file"]);
	?>
		<div style='position:relative;font-size:9pt; color:#000; background:#fff; border:1px dashed #000;z-index: 999'>
		<div style='padding:3px 5px; background:#99CCFF; font-weight:bold;'>File: <?=$bt["file"]?> [<?=$bt["line"]?>]</div>
		<pre style='padding:10px;'><?print_r($var)?></pre>
		</div>
		<?
	if ($die) {
		die;
	}
}
if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function internat_gluh_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on internat_gluh, use a find and replace
		* to change 'internat_gluh' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'internat_gluh', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'internat_gluh' ),
		)
	);
	register_nav_menus(
		array(
			'menu-home-items' => esc_html__( 'Home-items', 'internat_gluh' ),
		)
	);
	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'internat_gluh_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'internat_gluh_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function internat_gluh_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'internat_gluh_content_width', 640 );
}
add_action( 'after_setup_theme', 'internat_gluh_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function internat_gluh_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'internat_gluh' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'internat_gluh' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Specvarsion', 'internat_gluh' ),
			'id'            => 'specvarsion-1',
			'description'   => esc_html__( 'Add widgets here.', 'internat_gluh' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}
add_action( 'widgets_init', 'internat_gluh_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function internat_gluh_scripts() {
	wp_enqueue_style( 'internat_gluh-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'internat_gluh-main', get_template_directory_uri() .'/css/main.min.css');
	wp_style_add_data( 'internat_gluh-style', 'rtl', 'replace' );

	wp_enqueue_script( 'internat_gluh-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'internat_gluh-libs', get_template_directory_uri() . '/assets/js/libs.min.js');
	wp_enqueue_script( 'internat_gluh-main', get_template_directory_uri() . '/js/index.min.js');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'internat_gluh_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/mycustomizer.php';


require get_template_directory() . '/inc/useful_links.php';
require get_template_directory() . '/inc/contact_data.php';
require get_template_directory() . '/inc/documents.php';
require get_template_directory() . '/inc/slider.php';
require get_template_directory() . '/inc/form.php';
require get_template_directory() . '/inc/videoPrewiew.php';
require get_template_directory() . '/inc/application.php';
require get_template_directory() . '/inc/gallery.php';
require get_template_directory() . '/inc/specialists.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/documents_filter.php';
require get_template_directory() . '/inc/documents_filter_admin.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function admin_style() {
	wp_enqueue_style('admin-styles-fontsAwesome', get_template_directory_uri().'/libs/fontawesome/font-awesome.min.css');
	wp_enqueue_style('admin-styles-air-datepicker', get_template_directory_uri().'/libs/air-datepicker/air-datepicker.css');
	wp_enqueue_style('admin-styles-jquery-ui', get_template_directory_uri().'/libs/jquery/jquery-ui.min.css');
	wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

function admin_js() {
  global $post;
	if ($post) {
    wp_enqueue_script( 'admin-script-jquery-script', get_template_directory_uri() . '/libs/jquery/jquery.min.js');
    wp_enqueue_script( 'admin-script-jquery-ui-script', get_template_directory_uri() . '/libs/jquery/jquery-ui.min.js');
    wp_enqueue_script( 'admin-script-air-datepicker', get_template_directory_uri() . '/libs/air-datepicker/air-datepicker.js');
    wp_enqueue_script( 'admin-script', get_template_directory_uri() . '/js/admin.js' );
  }
}
add_action('admin_enqueue_scripts', 'admin_js');


//pagination
function wp_corenavi()
{
    global $wp_query, $wp_rewrite;
    $pages = '';
    $max = $wp_query->max_num_pages;
    if (!$current = get_query_var('paged')) $current = 1;
    $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
    $a['total'] = $max;
    $a['current'] = $current;

    $total = 0; //1 - выводить текст "Страница N из N", 0 - не выводить
    $a['mid_size'] = 5; //сколько ссылок показывать слева и справа от текущей
    $a['end_size'] = 1; //сколько ссылок показывать в начале и в конце
    $a['prev_text'] = '&laquo;'; //текст ссылки "Предыдущая страница"
    $a['next_text'] = '&raquo;'; //текст ссылки "Следующая страница"

    if ($max > 1) echo '<li>';
    if ($total == 1 && $max > 1) $pages = '<span class="pages">Страница ' . $current . ' из ' . $max . '</span>' . "\r\n";
    echo $pages . paginate_links($a);
    if ($max > 1) echo '</li>';
}