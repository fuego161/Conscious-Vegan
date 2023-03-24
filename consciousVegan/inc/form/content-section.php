<div class="form__section">

	<?php
	if ($title) {
	?>

		<h3 class="form__title section-subtitle">
			<?php echo $title; ?>
		</h3>

	<?php
	}
	?>

	<div class="form__wrapper">

		<?php
		if ($subtitle) {
		?>

			<label class="form__subtitle form__label">
				<?php echo $subtitle; ?>
			</label>

		<?php
		}

		echo $form->render_groups($data);
		?>

	</div><!-- .form__wrapper -->

</div><!-- .form__section -->
