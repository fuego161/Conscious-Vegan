<label class="form__label">

	<?php echo $label; ?>

	<input
	 class="form__input form__input--date js-form__input <?php if ($field_data['required']) echo 'form__input--required'; ?>"
	 name="<?php echo $name_hyphen; ?>"
	 type="text"
	 placeholder="Select a Date"
	 <?php if ($response_data) echo $response_data['el_attrs']; ?>
	>

</label>
