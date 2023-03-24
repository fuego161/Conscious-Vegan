<?php
// Variables
define('THEME_PATH', get_stylesheet_directory_uri() . '/');

$function_includes = [
	'setup',
	'enqueue',
	// 'custom-post-types',
	'helpers',
	'acf-options',
	'shortcodes',
	'main-form-process',
	'form-creation',
	'load-more-blog-posts',
	'walker-menus',
];

foreach ($function_includes as $include) {
	include_once('functions/' . $include . '.php');
}
