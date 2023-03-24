<?php
class CV_Form {

	public $action;
	public $form_name;
	public $section_data;
	public $submit_text;
	public $sectioned;

	public function __construct($form_data) {
		$this->action = $form_data['action'];
		$this->form_name = $this->hyphenate_string($form_data['form']);
		$this->section_data = $form_data['sections'];
		$this->submit_text = $form_data['submit_text'];
		$this->sectioned = count($form_data['sections']) > 1;
	}

	private function hyphenate_string($string) {
		// Transform the sting to lowercase
		$lower_case_string = strtolower($string);

		// Replace spaces with hyphens
		$string_hyphenated = str_replace(' ', '-', $lower_case_string);

		return $string_hyphenated;
	}

	private function create_label($name, $field_data) {
		// If there's no label field data, set the name as the label start
		$label_start =  $field_data['label'] ? $field_data['label'] : $name;

		// Start the array of label pieces
		$label = [
			$label_start,
		];

		// Check to see if the field is required required
		$required = $field_data['required'];

		// Set the required markup
		$required_markup = '<span class="label--required">*</span>';

		// If the field is required add the required markup
		if ($required) $label[] = $required_markup;

		// Check to see if info is present
		$has_info = $field_data['has_info'];

		// If the field has info add the required markup
		if ($has_info) {
			$label[] = '<span class="label__info">
				<svg width="16" height="16" viewbox="0 0 88 88" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M44 88c24.3 0 44-19.7 44-44S68.3 0 44 0 0 19.7 0 44s19.7 44 44 44zm0-8c19.882 0 36-16.118 36-36S63.882 8 44 8 8 24.118 8 44s16.118 36 36 36zm7-54.987c0 1.657-.57 3.072-1.714 4.235C48.146 30.417 46.77 31 45.161 31c-1.614 0-2.993-.583-4.148-1.752-1.152-1.163-1.73-2.578-1.73-4.235 0-1.654.578-3.071 1.73-4.25C42.165 19.587 43.547 19 45.161 19c1.608 0 2.984.589 4.125 1.764C50.431 21.942 51 23.359 51 25.014zm-.573 39.453a99.741 99.741 0 01-4.114 1.886c-1.022.433-2.212.648-3.567.648-2.08 0-3.699-.62-4.854-1.852-1.154-1.235-1.731-2.802-1.731-4.703 0-.736.042-1.493.13-2.264.086-.77.225-1.642.416-2.614l2.15-9.246c.19-.885.353-1.725.482-2.519.132-.788.196-1.513.196-2.167 0-1.18-.2-2.006-.601-2.47-.4-.465-1.164-.7-2.297-.7-.556 0-1.127.11-1.709.318-.584.21-.928-2.25-.928-2.25a48.232 48.232 0 014.038-1.788c1.287-.496 2.503-.745 3.653-.745 2.066 0 3.661.608 4.78 1.823 1.12 1.215 1.68 2.791 1.68 4.735 0 .4-.037 1.109-.115 2.12a16.997 16.997 0 01-.431 2.79l-2.14 9.21c-.174.74-.332 1.586-.469 2.537-.141.946-.21 1.668-.21 2.153 0 1.224.224 2.057.675 2.502.452.444 1.232.665 2.34.665.52 0 1.111-.112 1.769-.333.657-.22.857 2.264.857 2.264z" />
				</svg>
			</span>';
		}

		// Join and return the label
		return join(' ', $label);
	}

	public function get_response_data($response) {
		// Get the group we're responding to
		$responds_to = $response['responds_to'];
		// Get the starting visibility state
		$state = $response['state'];

		// Set the initial response data
		$response_data = [
			// If $triggered has a value then the field will be a respondee
			'responds_to' => $responds_to,
			// Set hide to false as a default
			'state' => $state,
		];

		$response_data['group_attrs'] = 'data-response-group="' . $responds_to . '"';

		// Set the attributes which will be added to the input element
		$response_data['el_attrs'] = 'data-response-element="' . $responds_to . '" data-state="' . $state . '"';

		// If state is hide
		if ($response_data['state'] === 'hide') {
			// Add a disable attribute to the input elements attributes
			$response_data['el_attrs'].= ' disabled';
		}

		return $response_data;
	}

	public function render_info($info) {
		if (!$info) return;

		ob_start();
		get_template_part('inc/form/content', 'info');
		return ob_get_clean();
	}

	public function render_hint($hint) {
		if (!$hint) return;

		ob_start();
		get_template_part('inc/form/content', 'hint');
		return ob_get_clean();
	}

	public function render_field($name, $field_data, $response_data) {
		// Create and set the label
		set_query_var('label', $this->create_label($name, $field_data));
		// Set response data as variable to use in field rendering
		set_query_var('response_data', $response_data);

		// Get the field type
		$type = $field_data['type'];

		// Set an array of generic fields
		$generic_fields = [
			'email',
			'password',
			'tel',
			'text',
			'url',
		];

		// Check to see if field is generic
		$is_generic_field = in_array($type, $generic_fields);

		// If generic field, set file to generic. If not, set to type
		$file = $is_generic_field ? 'generic' : $type;

		ob_start();
		get_template_part('inc/form/field/content', $file);
		return ob_get_clean();
	}

	public function render_groups($group_data) {
		// Check to see if split has a value. If not place a fallback of 'full'
		$split = $group_data['split'] ? $group_data['split'] : 'full';

		ob_start();

		foreach ($group_data['fields'] as $field_data) {
			set_query_var('name', $field_data['name']);
			set_query_var('name_hyphen', $this->hyphenate_string($field_data['name']));
			set_query_var('type', $field_data['type']);
			set_query_var('response', $field_data['response']);
			set_query_var('field_data', $field_data);

			// Check to see if there's a split override
			$group_split = $field_data['override_group_split'] ? $field_data['split_individual'] : $split;
			set_query_var('group_split', $group_split);

			get_template_part('inc/form/content', 'group');
		}

		return ob_get_clean();
	}

	public function render_sections() {
		ob_start();

		foreach ($this->section_data as $data) {
			set_query_var('data', $data);
			set_query_var('title', $data['title']);
			set_query_var('subtitle', $data['subtitle']);

			get_template_part('inc/form/content', 'section');
		}

		return ob_get_clean();
	}

	public function render() {
		set_query_var('form', $this);

		ob_start();
		get_template_part('inc/form/content', 'main');
		return ob_get_clean();
	}
}
