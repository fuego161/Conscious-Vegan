<?php
$modifier = isset($args['modifier']) ? $args['modifier'] : false;
$location = isset($args['location']) ? $args['location'] : false;
$is_sub_field = isset($args['is_sub_field']) ? $args['is_sub_field'] : true;

$show_cta = flex_acf_get('show_cta', $is_sub_field, $location);

if ($show_cta) {
	$title = flex_acf_get('cta_title', $is_sub_field, $location);
	$text = flex_acf_get('cta_content', $is_sub_field, $location);
	$button_1 = flex_acf_get('cta_button_1', $is_sub_field, $location);
	$show_button_2 = flex_acf_get('show_button_2', $is_sub_field, $location);
	$background = flex_acf_get('cta_background', $is_sub_field, $location);
?>

	<section class="cta <?php if ($background) echo 'cta--background' ; echo ' cta--' . $modifier; ?>">
		<div class="wrapper">

			<h2 class="cta__title section-title">
				<?php echo $title; ?>
			</h2>

			<p class="cta__text">
				<?php echo $text; ?>
			</p>

			<?php
			if ($button_1 || $show_button_2) {
			?>

				<div class="cta__btns">

					<?php
					if ($button_1) {
					?>

						<a
							class="cta__btn btn <?php if ($background) echo 'btn--alt' ; ?>"
							href="<?php echo $button_1['url']; ?>"
							title="<?php echo $button_1['title']; ?>"
							target="<?php echo $button_1['target']; ?>"
						>
							<?php echo $button_1['title']; ?>
						</a>

					<?php
					}

					if ($show_button_2) {
						$button_2 = flex_acf_get('cta_button_2', $is_sub_field, $location);
					?>

						<a
							class="cta__btn btn <?php if ($background) echo 'btn--alt' ; ?>"
							href="<?php echo $button_2['url']; ?>"
							title="<?php echo $button_2['title']; ?>"
							target="<?php echo $button_2['target']; ?>"
						>
							<?php echo $button_2['title']; ?>
						</a>

					<?php
					}
					?>

				</div><!-- .cta-btns -->

			<?php
			}
			?>

		</div><!-- .wrapper -->
	</section><!-- .cta -->

<?php
}
?>
