<?php
$location = isset($args['location']) ? $args['location'] : false;
$modifier = isset($args['modifier']) ? $args['modifier'] : false;
$is_sub_field = isset($args['is_sub_field']) ? $args['is_sub_field'] : true;

$is_carousel = flex_acf_get('gallery_type', $is_sub_field, $location);

$gallery_type = $is_carousel ? 'carousel' : 'grid';

get_template_part('inc/components/content', 'gallery-' . $gallery_type, [
	'location' => $location,
	'modifier' => $modifier,
	'is_sub_field' => $is_sub_field,
]);
