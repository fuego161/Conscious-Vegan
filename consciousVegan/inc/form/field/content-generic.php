<?php
// Get the field type
$type = $field_data['type'];
?>

<label class="form__label label">

	<?php echo $label; ?>

	<input
	 class="form__input form__input--<?php echo $type; ?> js-form__input"
	 name="<?php echo $name_hyphen; ?>"
	 type="<?php echo $type; ?>"
	 <?php if ($response_data) echo $response_data['el_attrs']; ?>
	>

</label>
