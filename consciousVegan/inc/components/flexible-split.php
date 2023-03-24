<?php
$location = isset($args['location']) ? $args['location'] : false;
$modifier = isset($args['modifier']) ? $args['modifier'] : false;

if (have_rows('split_content', $location)) {
?>

	<section class="split <?php if ($modifier) echo 'split--' . $modifier; ?>">
		<div class="wrapper">

			<?php
			while (have_rows('split_content', $location)) {
				the_row();
				// Get the title
				$title = get_sub_field('split_title');

				// Get the subtitle
				$subtitle = get_sub_field('split_subtitle');

				// Get the content
				$content = get_sub_field('split_content');

				// Get the buttons
				$split_btn_1 = get_sub_field('split_button_1');
				$split_btn_2 = get_sub_field('split_button_2');

				// Get the image type
				$img_type = get_sub_field('split_image_type');
			?>

				<div class="split__group <?php if ($img_type === 'none') echo 'split__group--central'; ?>">

					<?php
					if ($img_type !== 'none') {
						get_template_part('inc/components/content', 'multi-img-output', [
							'prefix' => 'split',
							'location' => $location,
							'img_type' => $img_type,
							'is_sub_field' => true,
						]);
					}
					?>

					<div class="split__content">

						<?php
						if ($title) {
						?>

							<h2 class="split__title section-subtitle">
								<?php echo $title; ?>
							</h2>

						<?php
						}

						if ($subtitle) {
						?>

							<h3 class="split__subtitle">
								<?php echo $subtitle; ?>
							</h3>

						<?php
						}

						echo $content;

						if ($split_btn_1 || $split_btn_2) {
						?>

							<div class="split__btns">

								<?php
								if ($split_btn_1) {
									$split_btn_1_url = $split_btn_1['url'];
									$split_btn_1_title = $split_btn_1['title'];
									$split_btn_1_target = $split_btn_1['target'];
								?>

									<a
										class="split__btn btn"
										href="<?php echo $split_btn_1_url; ?>"
										title="<?php echo $split_btn_1_title; ?>"
										target="<?php echo $split_btn_1_target; ?>"
									>
										<?php echo $split_btn_1_title; ?>
									</a>

								<?php
								}

								if ($split_btn_2) {
									$split_btn_2_url = $split_btn_2['url'];
									$split_btn_2_title = $split_btn_2['title'];
									$split_btn_2_target = $split_btn_2['target'];
								?>

									<a
										class="split__btn btn"
										href="<?php echo $split_btn_2_url; ?>"
										title="<?php echo $split_btn_2_title; ?>"
										target="<?php echo $split_btn_2_target; ?>"
									>
										<?php echo $split_btn_2_title; ?>
									</a>

								<?php
								}
								?>

							</div><!-- .split__btns -->

						<?php
						}
						?>

					</div><!-- .split__content -->

				</div><!-- .split__group -->

			<?php
			}
			?>

		</div><!-- .wrapper -->
	</section><!-- .content -->

<?php
}
?>
