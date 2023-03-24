<?php
if (function_exists('acf_add_options_page')) {
	// Contact Details
	acf_add_options_page([
		'page_title' => 'Contact Details',
		'menu_slug' => 'contact-details',
		'post_id' => 'contact_details',
		'capability' => 'edit_posts',
		'parent_slug' => '',
		'position' => 27,
		'icon_url' => 'dashicons-email-alt',
		'update_button' => __('Update Contact Details', 'acf'),
		'updated_message' => __('Contact Details Updated', 'acf'),
	]);

	// Prompt Options Page
	acf_add_options_page(
		[
			'page_title' => 'Prompt',
			'menu_slug' => 'prompt',
			'post_id' => 'prompt',
			'capability' => 'edit_posts',
			'parent_slug' => '',
			'position' => 29,
			'icon_url' => 'dashicons-megaphone',
			'update_button' => __('Update Prompt', 'acf'),
			'updated_message' => __('Prompt Updated', 'acf'),
		]
	);
}
