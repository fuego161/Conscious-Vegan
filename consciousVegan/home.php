<?php
get_header();

get_template_part('inc/components/content', 'flexible-page', [
	'location' => get_option('page_for_posts'),
	'is_sub_field' => false,
]);

get_template_part('inc/components/content', 'blog');

get_footer();
?>
