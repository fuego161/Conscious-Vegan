<?php
// After theme setup
function cv_setup() {
	if (is_user_logged_in() && strpos(wp_get_current_user()->user_email, 'tidydesign.com')) {
		show_admin_bar(false);
	}

	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	add_theme_support('menus');
	add_image_size('gallery-thumb', 360, 360, true);
}
add_action('after_setup_theme', 'cv_setup');

// Init
function cv_init() {
	// cv_register_post_types();

	// Close comments on the front-end
	add_filter('comments_open', '__return_false', 20, 2);
	add_filter('pings_open', '__return_false', 20, 2);
}
add_action('init', 'cv_init');

// Remove items from admin bar
function cv_remove_admin_bar_items() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'cv_remove_admin_bar_items');

// Remove menu pages
function cv_remove_cpt_support() {
	// Disable support for comments and trackbacks in post types
	foreach (get_post_types() as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('admin_init', 'cv_remove_cpt_support', 999);

function cv_remove_menu_pages() {
	global $submenu;

	remove_menu_page('edit-comments.php');
	remove_menu_page('options-discussion.php');
	unset($submenu['options-general.php'][25]);
}
add_action('admin_menu', 'cv_remove_menu_pages');

// Remove unnecessary dashboard widgets
function cv_remove_dashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
add_action('wp_dashboard_setup', 'cv_remove_dashboard_widgets' );

// Remove capabilities for accounts without "tidydesign.com" in their email
if (is_user_logged_in() && !strpos(wp_get_current_user()->user_email, 'tidydesign.com')) {
	// Don't show ACF
	add_filter('acf/settings/show_admin', '__return_false');

	// Remove menu pages
	function cv_remove_non_tidy_menu_pages() {
		remove_menu_page('plugins.php');
	}
	add_action('admin_init', 'cv_remove_non_tidy_menu_pages', 999);

	function cv_remove_add_media($settings) {
		$current_screen = get_current_screen();

		// Post types for which the media buttons should be kept
		$post_types = [
			// 'name of the post type you'd like the "Add Media" button shown on',
		];

		// Bail out if media buttons should not be removed for the current post type.
		if (!$current_screen || !in_array($current_screen->post_type, $post_types, true)) {
			$settings['media_buttons'] = false;
		}

		return $settings;
	}

	// Remove "Add Media" from above WYSIWYG
	add_filter('wp_editor_settings', 'cv_remove_add_media');
}

// Remove WYSIWYG editor
function cv_remove_content_editor() {
	// Array of template which want the WYSIWYG
	$allowed_templates = [];

	// Get the current template slug
	$template = get_page_template_slug();

	if (!in_array($template, $allowed_templates)) {
		remove_post_type_support('page', 'editor');
		remove_post_type_support('post', 'editor');
	}
}
add_action('admin_head', 'cv_remove_content_editor');
