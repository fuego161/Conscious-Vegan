<?php
$location = isset($args['location']) ? $args['location'] : false;
$modifier = isset($args['modifier']) ? $args['modifier'] : false;
$is_sub_field = isset($args['is_sub_field']) ? $args['is_sub_field'] : true;
$date = isset($args['date']) ? $args['date'] : false;

// Find out if we're overriding the title
$title_override = flex_acf_get('override_page_title', $is_sub_field, $location);

// Get either the override title or the page title
$title = $title_override ? flex_acf_get('intro_title', $is_sub_field) : get_the_title($location);

// Find if we're showing a subtitle
$show_subtitle = flex_acf_get('intro_show_subtitle', $is_sub_field, $location);

// Get the text
$text = flex_acf_get('intro_text', $is_sub_field, $location);

// Get the check to see if there's a button
$intro_show_button = flex_acf_get('intro_show_button', $is_sub_field, $location);

// Get the image type
$img_type = flex_acf_get('intro_image_type', $is_sub_field, $location);
?>

<section class="intro <?php if ($modifier) echo 'intro--' . $modifier; ?>">
	<div class="wrapper">

		<?php
		get_template_part('inc/components/content', 'multi-img-output', [
			'prefix' => 'intro',
			'location' => $location,
			'img_type' => $img_type,
			'is_sub_field' => $is_sub_field,
		]);
		?>

		<div class="intro__content">

			<?php
			if ($date) {
			?>

				<p class="intro__date date">
					Posted: <?php echo $date['day']; ?><sup class="suffix"><?php echo $date['suffix']; ?></sup>

					<?php echo $date['month_year']; ?>
				</p>

			<?php
			}
			?>

			<h2 class="intro__title section-title">
				<?php echo $title; ?>
			</h2>

			<?php
			if ($show_subtitle) {
				// Get the subtitle
				$subtitle = flex_acf_get('intro_subtitle', $is_sub_field, $location);
			?>

				<h3 class="intro__subtitle section-subtitle">
					<?php echo $subtitle; ?>
				</h3>

			<?php
			}
			?>

			<p class="intro__text">
				<?php echo $text; ?>
			</p>

			<?php
			if ($intro_show_button) {
				$btn = flex_acf_get('intro_button', $is_sub_field, $location);

				$btn_url = $btn['url'];
				$btn_title = $btn['title'];
				$btn_target = $btn['target'];
			?>

				<a
					class="intro__btn btn"
					href="<?php echo $btn_url; ?>"
					title="<?php echo $btn_title; ?>"
					target="<?php echo $btn_target; ?>"
				>
					<?php echo $btn_title; ?>
				</a>

			<?php
			}
			?>

		</div><!-- .intro__content -->

	</div><!-- .wrapper -->
</section><!-- .intro -->
