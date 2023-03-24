<?php
function cv_load_more_posts() {
	$query = isset($_POST['query']) ? $_POST['query'] : [];
	$page = isset($_POST['page']) ? $_POST['page'] : '';

	$args = json_decode(stripslashes($query), true);
	$args['paged'] = $page + 1;
	$args['post_status'] = 'publish';

	$fresh_query = new WP_Query($args);

	if ($fresh_query->have_posts()) {
		while ($fresh_query->have_posts()) {
			$fresh_query->the_post();
			get_template_part('inc/shared-loops/content', 'blog-posts');
		}
	}

	die();
}
add_action('wp_ajax_cv_load_more_posts', 'cv_load_more_posts');
add_action('wp_ajax_nopriv_cv_load_more_posts', 'cv_load_more_posts');
