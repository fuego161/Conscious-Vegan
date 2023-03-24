<?php
// Get the select items
$select_items = $field_data['group']['options'];
?>

<label class="form__label">

	<?php echo $label; ?>

	<select
	 class="form__select js-form__input"
	 name="<?php echo $name_hyphen; ?>"
	 <?php if ($response_data) echo $response_data['el_attrs']; ?>
	>

		<option value="">Please select an option</option>

		<?php
		foreach ($select_items as $select) {
			$option = $select['option'];
			echo '<option value="' . $option . '">' .$option  . '</option>"';
		}
		?>

	</select>

</label>
