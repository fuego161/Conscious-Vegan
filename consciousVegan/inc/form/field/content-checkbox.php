<label class="form__label">

	<input
	 class="form__checkbox js-form__input <?php if ($field_data['required']) echo 'form__checkbox--required'; ?>"
	 name="<?php echo $name_hyphen; ?>"
	 type="checkbox"
	 value="<?php echo $field_data['label']; ?>"
	 <?php if ($response_data) echo $response_data['el_attrs']; ?>
	>

	<?php echo $label; ?>

</label>

