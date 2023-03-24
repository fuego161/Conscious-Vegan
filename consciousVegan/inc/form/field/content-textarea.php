<label class="form__label">

	<?php echo $label; ?>

	<textarea
	 class="form__input form__input--textarea js-form__input"
	 name="<?php echo $name_hyphen; ?>"
	 <?php if ($response_data) echo $response_data['el_attrs']; ?>
	></textarea>

</label>
