<?php
// Get the variables needed for the main output
$form_name = $form->form_name;
$submit_text = $form->submit_text;
$sectioned = $form->sectioned;
$action = $form->action;

// Set the form element classes
$form_class_list = [
	'form',
	'form--' . $form_name,
];

// If sectioned, add the sectioned class modifier
if ($sectioned) $form_class_list[] = 'form--sectioned';

// Join the classes
$form_classes = join(' ', $form_class_list);
?>

<form class="<?php echo $form_classes; ?>">

	<?php
	echo $form->render_sections();
	?>

	<div class="form__group form__group--btn">
		<input class="form__btn btn js-form__btn" type="submit" value="<?php echo $submit_text; ?>">
	</div><!-- .form__group-btn -->

	<input type="hidden" name="action" value="<?php echo $action; ?>">

</form><!-- .form -->

<div class="messages">
	<p class="messages__message messages__message--error hide"></p>
	<p class="messages__message messages__message--success hide"></p>
</div><!-- .-messages -->
