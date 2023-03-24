<?php
// A collection of small functions to help with tasks across the project

/**
 * Replace YouTube links
 * Runs prior to inserting into or updating the database
 * Searches the post_content for embed YouTube links without the privacy enhanced "-nocookie" addition.
 * If it comes across any instances all will be replaced
 */
function cv_replace_youtube_links($data) {
	// Set the both YouTube links
	$non_privacy_youtube_link = 'youtube.com/embed/';
	$privacy_youtube_link = 'youtube-nocookie.com/embed/';

	// Get the post content
	$post_content = $data['post_content'];

	// Search for the non privacy enhanced YouTube link
	// When using PHP 8 replace this with str_contains($post_content, $non_privacy_youtube_link)
	if (strpos($post_content, $non_privacy_youtube_link)) {
		// Replace the non privacy enhanced YouTube link
		$post_content = str_replace($non_privacy_youtube_link, $privacy_youtube_link, $post_content);

		// Replace the $data's post content
		$data['post_content'] = $post_content;
	}

	return $data;
}

add_filter('wp_insert_post_data', 'cv_replace_youtube_links', 99);

/*
 * A quick helper function to return a random amount of errors from 0 to 4
 * This helps test error messages, also the the transition from showing errors to success
 * To use place '$return['errors'] = random_errors();' above the conditional 'if (count($return['errors']) === 0)'
*/
function cv_form_random_errors() {
	$rand_num = rand(0, 4);

	switch ($rand_num) {
		case 1:
			$errors = [
				'phone',
			];
			break;
		case 2:
			$errors = [
				'phone',
				'email',
			];
			break;
		case 3:
			$errors = [
				'phone',
				'email',
				'name',
			];
			break;
		case 4:
			$errors = [
				'phone',
				'email',
				'name',
				'message'
			];
			break;
		default:
			$errors = [];
			break;
	}

	return $errors;
}

/**
 * A helper function for creating number list select options
 * $start: the first number you want an option
 * $finish: the last number you want an option
 */
function cv_select_options_count($start, $finish) {
	// Create an array to store the count
	$count = [];

	// Set the current number to the starting value
	$current = $start;

	for ($current; $current <= $finish; $current++) {
		// Add the new current count to the count array
		$count[] = $current;
	}

	return $count;
}

/**
 * Used to pass back the value of either "get_field" or "get_sub_field" for a field name
 * Makes cvible components available to be used as standalone components
 *
 * $field_name (string) - the field wanting to be retrieved
 * $is_sub_field (bool) - whether or not it's a sub-field
 */
function cv_acf_get($field_name, $is_sub_field = false, $location = false) {
	return $is_sub_field ? get_sub_field($field_name) : get_field($field_name, $location);
}
