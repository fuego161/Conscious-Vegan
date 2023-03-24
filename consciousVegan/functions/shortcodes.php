<?php
// Shortcode: [youtube embed=""]
function youtube_embed_output($atts) {
	ob_start();
	set_query_var('embed', $atts['embed']);
	get_template_part('inc/components/content', 'youtube');
	return ob_get_clean();
}
add_shortcode('youtube', 'youtube_embed_output');
