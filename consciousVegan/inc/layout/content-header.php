<?php
$location = isset($args['location']) ? $args['location'] : false;

$show_header = get_field('show_full_header', $location);

if ($show_header) {
	// Find out if we're overriding the title
	$title_override = get_field('header_override_page_title', $location);

	// Get either the override title or the page title
	$title = $title_override ? get_field('header_title', $location) : get_the_title($location);

	// Find if we're showing a subtitle
	$show_subtitle = get_field('header_show_subtitle', $location);

	// Get the check to see if there's a button
	$show_button = get_field('header_show_button', $location);

	// Find out if we're overriding the featured image
	$featured_img_override = get_field('header_override_featured_image', $location);

	if ($featured_img_override) {
		// Get the override image
		$image_array = get_field('header_image', $location);
		$image_url = esc_url($image_array['url']);
	}
	else {
		// Get the featured image
		$image_url = esc_url(get_the_post_thumbnail_url($location, 'full'));
	}

	$background_deceleration = 'background-image: url(' . $image_url . ');';
?>

	<header class="header" <?php if ($background_deceleration) echo "style='" . $background_deceleration . "'"; ?>>
		<div class="wrapper">

			<h1 class="header__title header-title">
				<?php echo $title; ?>
			</h1>

			<?php
			if ($show_subtitle) {
				// Get the subtitle
				$subtitle = get_field('header_subtitle', $location);
			?>

				<h2 class="header__subtitle header-subtitle">
					<?php echo $subtitle; ?>
				</h2>

			<?php
			}

			if ($show_button) {
				$btn = get_field('header_button', $location);
			?>

				<a
					class="header__btn btn"
					href="<?php echo $btn['url']; ?>"
					title="<?php echo $btn['title']; ?>"
					target="<?php echo $btn['target']; ?>"
				>
					<?php echo $btn['title']; ?>
				</a>

			<?php
			}
			?>

		</div><!-- .wrapper -->
	</header>

<?php
}
?>
