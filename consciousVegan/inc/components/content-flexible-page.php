<?php
$location = isset($args['location']) ? $args['location'] : false;
$modifier = isset($args['modifier']) ? $args['modifier'] : 'flexible';

$component_args = [
	'location' => $location,
	'modifier' => $modifier,
	'is_sub_field' => true,
];

$last_layout = '';

if (have_rows('flexible', $location)) {
	while (have_rows('flexible', $location)) {
		the_row();

		$row_layout = get_row_layout();

		if ($row_layout === 'flex_intro') {
			get_template_part('inc/components/flexible', 'intro', $component_args);
		}
		else if ($row_layout === 'flex_split_content') {
			get_template_part('inc/components/flexible', 'split', $component_args);
		}
		else if ($row_layout === 'flex_cta') {
			get_template_part('inc/components/flexible', 'cta', $component_args);
		}
		else if ($row_layout === 'flex_faq') {
			get_template_part('inc/components/flexible', 'faq', $component_args);
		}
		else if ($row_layout === 'flex_gallery') {
			get_template_part('inc/components/flexible', 'gallery', $component_args);
		}
	}

	$last_layout = $row_layout;
}

if ($last_layout === 'flex_cta') {
	set_query_var('footer_flush', true);
}
?>
