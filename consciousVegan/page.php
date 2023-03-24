<?php
get_header();

$location = get_the_ID();

get_template_part('inc/components/content', 'flexible-page', [
	'location' => $location,
]);

get_footer();
?>
