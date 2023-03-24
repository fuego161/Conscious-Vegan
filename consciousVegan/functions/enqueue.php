<?php
// A function to give the ability to set an enqueued script to be async or deferred
// To do this append either (or both)'#asyncload' or '#deferload' to the end of a src in the 'wp_enqueue_script' function
function cv_async_defer_scripts($url) {
	if (strpos($url, '#asyncload')) {
		if (is_admin()) {
			$url = str_replace( '#asyncload', '', $url );
		}
		else {
			$url = str_replace( '#asyncload', '', $url )."' async='async";
		}
	}

	if (strpos($url, '#deferload')) {
		if (is_admin()) {
			$url = str_replace( '#deferload', '', $url );
		}
		else {
			$url = str_replace( '#deferload', '', $url )."' defer='defer";
		}
	}

	return $url;
}
add_filter('clean_url', 'cv_async_defer_scripts', 11, 1);


function cv_assets() {
	/* ==================
	STYLES
	================== */
	$deps = [];

	// concatenated + compressed theme css + scss files
	wp_enqueue_style('main-style', THEME_PATH . 'style.css', $deps, '0.0.1');

	/* ==================
	SCRIPTS
	================== */
	$deps = [];

	wp_enqueue_script('cookie-control', '//cc.cdn.civiccomputing.com/9/cookieControl-9.x.min.js', $deps, '9.0.0', true);
	$deps[] = 'cookie-control';

	// compiled, converted concatenated + uglified theme scripts
	wp_enqueue_script('main-script', THEME_PATH . 'assets/js/main.js' , $deps, '0.0.1', true);

	// Get the ajax url & theme path
	$ajax_url = json_encode(admin_url('admin-ajax.php'));
	$theme_path = json_encode(THEME_PATH);

	$inline_vars = [
		'wpAjaxUrl = ' . $ajax_url . ';',
		'themePath = ' . $theme_path . ';',
	];

	if (is_home() || is_category()) {
		global $wp_query;
		$posts = json_encode($wp_query->query_vars);
		$max_page = $wp_query->max_num_pages;

		$inline_vars[] = 'posts = ' . $posts . ';';
		$inline_vars[] = 'var maxPage = ' . $max_page . ';';
	}

	// Add the admin ajax url to the page
	wp_add_inline_script('main-script', join($inline_vars), 'before');
}
add_action('wp_enqueue_scripts', 'cv_assets');
