<?php
// Get the number attributes
$number_attributes = $field_data['number_attributes'];

// Set an array to store the attributes with values
$attrs = [];

foreach ($number_attributes as $name => $value) {
	// If a value exists, create an attribute
	if ($value) $attrs[] = $name . "=\"" . $value . "\"";
}

// Join the attributes
$attrs = join($attrs, ' ');
?>

<label class="form__label label">

	<?php echo $label; ?>

	<input
	 class="form__input form__input--<?php echo $type; ?> js-form__input"
	 name="<?php echo $name_hyphen; ?>"
	 type="range"
	 <?php if ($response_data) echo $response_data['el_attrs']; ?>
	>

</label>
