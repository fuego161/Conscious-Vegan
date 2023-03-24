<?php
$prefix = isset($args['prefix']) ? $args['prefix'] : 'intro';
$location = isset($args['location']) ? $args['location'] : false;
$sub = isset($args['is_sub_field']) ? $args['is_sub_field'] : true;
$img_type = isset($args['img_type']) ? $args['img_type'] : false;

if ($img_type === 'video') {
	// Get the video embed ID
	$embed_id = flex_acf_get($prefix . '_video_url', $sub, $location);
?>

	<div class="<?php echo $prefix; ?>__media <?php echo $prefix; ?>__video wysiwyg__iframe-holder">
		<iframe class="wysiwyg__iframe" width="560" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $embed_id; ?>?modestbranding=1&rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>

<?php
}

if ($img_type === 'slider') {
	// Get the split slider
	$slider = flex_acf_get($prefix . '_slider', $sub, $location);
?>

	<div class="<?php echo $prefix; ?>__media <?php echo $prefix; ?>__media--slider slider slider--fade">
		<div class="slider__track" data-glide-el="track">
			<ul class="slider__slides">

				<?php
				foreach ($slider as $image) {
					$image_url = esc_url($image['url']);
					$background_deceleration = 'background-image: url(' . $image_url . ');';
				?>

					<li
						class="slider__slide"
						style="<?php echo $background_deceleration; ?>"
						data-src="<?php echo $image_url; ?>"
					>
						<div class="slider__spacer"></div>
					</li><!-- .${prefix}__slide -->

				<?php
				}
				?>

			</ul><!-- .${prefix}__slides -->
		</div><!-- .${prefix}__track -->
	</div><!-- .${prefix}__slider -->

<?php
}

if ($img_type === 'featured' || $img_type === 'choice') {
	if ($img_type === 'featured') {
		// Get the featured image
		$image_url = esc_url(get_the_post_thumbnail_url($location, 'medium_large'));
	}
	else if ($img_type === 'choice') {
		// Get the override image
		$image_array = flex_acf_get($prefix . '_image', $sub, $location);
		$image_url = esc_url($image_array['sizes']['medium_large']);
	}

	$background_deceleration = 'background-image: url(' . $image_url . ');';
?>

	<div class="<?php echo $prefix; ?>__media <?php echo $prefix; ?>__media--image" style="<?php echo $background_deceleration; ?>"></div>

<?php
}
?>
