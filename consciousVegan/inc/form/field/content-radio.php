<?php
// Check to see if there's a radio split
$radio_split = $field_data['group']['split'] ? $field_data['group']['split'] : 'full';

// Get the radio items
$radios = $field_data['group']['options'];

// Check to see if options invokes action
$invokes_action = $field_data['triggers_action'];

$i = 0;

foreach ($radios as $radio) {
	// Set the radio identifier
	$identifier = $name_hyphen . '-' . $i;

	// Get the name and value of the option
	$option = $radio['option'];

	// Check to see if the option invokes action
	if ($invokes_action) {
		// Get the action
		$action = $radio['action'];

		// Set the action attributes
		$action = 'data-trigger-group="' . $name_hyphen . '" data-action="' . $action . '"';
	}
?>

	<div class="form__selectable form__selectable--<?php echo $radio_split; ?>">

		<input
			id="<?php echo $identifier; ?>"
			class="form__radio js-form__input"
			name="<?php echo $name_hyphen; ?>"
			type="radio"
			value="<?php echo $option; ?>"
			<?php if ($invokes_action) echo $action; ?>
			<?php if ($response_data) echo $response_data['el_attrs']; ?>
		>

		<label class="form__label form__label--radio" for="<?php echo $identifier; ?>">

			<?php echo $option; ?>

		</label>

	</div>

<?php
	$i++;
}
?>
