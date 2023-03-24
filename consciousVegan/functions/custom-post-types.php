<?php
// Register a single custom post type
function cv_register_post_type($handle, $args) {
	$words = explode('-', $handle);
	$name = '';

	for ($i = 0; $i < count($words); $i++) {
		$name .= strtoupper($words[$i][0]) . substr($words[$i], 1);

		if ($i < count($words) - 1) {
			$name .= ' ';
		}
	}

	$name_plural = $name;

	if (array_key_exists('plural', $args)) {
		if ($args['plural'] === 'y') {
			$name_plural = rtrim($name, 'y') . 'ies';
		}
		else {
			$name_plural = $name . 's';
		}
	}

	$default_args = [
		'public' => false, //exclude_from_search: true && public_queryable: false
		'show_ui' => true, //negate public false
		'show_in_nav_menus' => true, //negate public false
		'show_in_menu' => true, //use existing top level page name to insert into submenu
		'show_in_admin_bar' => false, //wpadminbar
		'menu_position' => 25, //below comments
		'menu_icon' => null, //posts menu icon
		'hierarchical' => false, //no parenting etc
		'has_archive' => false, //no archive page
		'can_export' => true, //can be exported with regular export tools
		'delete_with_user' => false, //do not delete if author user is deleted
		'supports' => [
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'trackbacks',
			'custom-fields',
			'comments',
			'revisions',
			'page-attributes',
			'post-formats'
		],
		'taxonomies' => [
			'category',
			'post_tag'
		],
		'labels' => [
			'name' => $name_plural,
			'singular_name' => $name,
			'add_new_item' => 'Add New ' . $name,
			'edit_item' => 'Edit ' . $name,
			'new_item' => 'New ' . $name,
			'view_item' => 'View ' . $name,
			'view_items' => 'View ' . $name_plural,
			'search_items' => 'Search ' . $name_plural,
			'not_found' => 'No ' . $name_plural . ' Found',
			'not_found_in_trash' => 'No ' . $name_plural . ' Found in Trash',
			'all_items' => 'All ' . $name_plural,
			'archives' => $name . ' Archives',
			'attributes' => $name . ' Attributes',
			'insert_into_item' => 'Insert into ' . $name,
			'uploaded_to_this_item' => 'Uploaded to this ' . $name
		]
	];

	register_post_type($handle, array_merge($default_args, $args));
}

// Alter 'update post' system messages for custom posts
function cv_custom_post_updated_messages($messages) {
	global $post, $post_ID;
	$link = esc_url(get_permalink($post_ID));

	$post_types = [
		'post-type-identifier' => 'Custom Post Type'
	];

	foreach ($post_types as $post_type => $name) {
		$messages[$post_type] = [
			'',
			sprintf(__($name . ' updated. <a href="%s">View ' . strtolower($name) . '</a>'), $link),
			__('Custom field updated.'),
			__('Custom field deleted.'),
			__($name . ' updated.'),
			isset($_GET['revision']) ? sprintf(__($name . ' restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
			sprintf(__($name . ' published. <a href="%s">View ' . strtolower($name) . '</a>'), $link),
			__($name . ' saved.'),
			sprintf(__($name . ' submitted. <a target="_blank" href="%s">Preview ' . strtolower($name) . '</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
			sprintf(__($name . ' scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview ' . strtolower($name) . '</a>'), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), $link),
			sprintf(__($name . ' draft updated. <a target="_blank" href="%s">Preview ' . $name . '</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID))))
		];
	}

	return $messages;
}
add_filter('post_updated_messages', 'cv_custom_post_updated_messages');

// Alter bulk 'update post' system messages for custom posts
function cv_custom_post_bulk_updated_messages($bulk_messages, $bulk_counts) {
	$post_types = [
		'post-type-identifier' => ['single' => 'Custom Post Type', 'plural' => 'Custom Post Types']
	];

	foreach ($post_types as $post_type => $texts) {
		$single = $texts['single'];
		$plural = $texts['plural'];

		$bulk_messages[$post_type] = [
			'updated'   => _n('%s ' . $single . ' updated.', '%s ' . $plural . ' updated.', $bulk_counts["updated"]),
			'locked'    => _n('%s ' . $single . ' not updated, somebody is editing it.', '%s ' . $plural . ' not updated, somebody is editing them.', $bulk_counts["locked"]),
			'deleted'   => _n('%s ' . $single . ' permanently deleted.', '%s ' . $plural . ' permanently deleted.', $bulk_counts["deleted"]),
			'trashed'   => _n('%s ' . $single . ' moved to the Trash.', '%s ' . $plural . ' moved to the Trash.', $bulk_counts["trashed"]),
			'untrashed' => _n('%s ' . $single . ' restored from the Trash.', '%s ' . $plural . ' restored from the Trash.', $bulk_counts["untrashed"]),
		];
	}

	return $bulk_messages;
}
add_filter('bulk_post_updated_messages', 'cv_custom_post_bulk_updated_messages', 10, 2);

// Alter "enter title here" system messages for custom posts
function cv_custom_post_enter_title_here($title) {
	$screen = get_current_screen();

	if (isset($screen->post_type)) {
		switch ($screen->post_type) {
			case 'post-type-identifier':
				$title = 'Name the Custom Post';
				break;
			default:
				$title = 'Enter title here';
				break;
		}
	}

	return $title;
}
add_filter('enter_title_here', 'cv_custom_post_enter_title_here');

// Register all custom post types
function cv_register_post_types() {
	$post_types = [
		'post-type-identifier' => [
			/* override args */
		]
	];

	foreach ($post_types as $handle => $args) {
		cv_register_post_type($handle, $args);
	}
}
