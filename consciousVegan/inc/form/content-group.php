<?php
// Set the classes of the group
$group_class_list = [
	'form__group',
	'form__group--' . $type,
	'form__group--' . $group_split,
];

// Check to see if the group responds to an action
$responds = $field_data['responds'];

if ($responds) {
	// Get the response data
	$response_data = $form->get_response_data($response);

	// Add a hidden class if needed
	if ($response_data['state'] === 'hide') $group_class_list[] = 'form__group--hide';
}

// Ready response data to be passed to render_field, will either be the data or false
$response_data = $responds ? $response_data : $responds;

// Join the classes
$group_classes = join(' ', $group_class_list);
?>

<div
 class="<?php echo $group_classes; ?>"
 <?php if ($responds) echo $response_data['group_attrs']; ?>
>

	<?php
	echo $form->render_field($name, $field_data, $response_data);

	if ($field_data['has_info']) {
		echo $form->render_info($field_data['info']);
	}

	if ($field_data['required']) {
		echo $form->render_hint($field_data['hint']);
	}
	?>

</div>


