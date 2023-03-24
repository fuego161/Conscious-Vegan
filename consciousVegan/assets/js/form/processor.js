import { ProcessingError } from './helpers';
import { slideUp, slideDown } from '../_utils';

export class FormProcessor {
	constructor(form, validationRules, events) {
		// The form we're operating on
		this.form = form;

		// Get the WP Ajax URL
		this.ajaxUrl = window.wpAjaxUrl;

		// A flag to check if the validity is showing to the user
		this.validityShowing = false;

		// A to-be-constructed map of validation rules for all forms
		this.validators = validationRules;

		// A list of validation errors, populated by validate()
		this.validationErrors = [];

		// Get the form elements
		this.formElements = {
			errorMessage: document.querySelector('.messages__message--error'),
			successMessage: document.querySelector('.messages__message--success'),
			submitBtn: document.querySelector('.js-form__btn'),
		};

		this.initialise(events);
	}

	// Helper Functions
	disableInput(input) {
		return input.setAttribute('disabled', true);
	}

	enableInput(input) {
		return input.removeAttribute('disabled');
	}

	// Validation Functions
	regexValidation(input, regex, required) {
		let valid = false;

		if (!required && input.value.length === 0) {
			valid = true;
		} else {
			valid = regex.test(input.value);
		}

		// Simple pass-through regex testing
		return {
			valid,
			el: input,
		};
	}

	checkboxValidation(input) {
		// Simple pass-through regex testing
		return {
			valid: input.checked,
			el: input,
		};
	}

	selectValidation(input) {
		// Get the value of the selected option
		const selectValue = input.value;

		// Default value for selects is empty string. If empty string not valid
		return {
			valid: selectValue !== '',
			el: input,
		};
	}

	radioValidation(name) {
		// Get the radio btns or select for the name provided and check if at least one of them is checked
		const radioBtns = Array.from(document.querySelectorAll(`[name="${name}"]`));

		return {
			valid: radioBtns.some((radio) => radio.checked),
			el: document.querySelector(`[name="${name}"]`),
		};
	}

	resetValidity() {
		// Reset the validityShowing flag
		this.validityShowing = false;

		// Reset the validationErrors
		this.validationErrors = [];

		// Hide the user friendly error message
		slideUp(this.formElements.errorMessage, { fade: false, timing: 10 });
		this.formElements.errorMessage.innerHTML = '';
	}

	// Main Form Initialiser
	initialise(events) {
		// Register events
		for (const event of Object.keys(events)) {
			// All events bound to this instance to simplify callbacks
			// Justification: form instance normally bound as this for eventListener callback still available via "this".form
			this.form.addEventListener(event, events[event].bind(this));
		}
	}

	success() {
		const msg = 'Thank you for contacting us, we will be in touch with you shortly.';

		// Set the successMessage
		this.formElements.successMessage.textContent = msg;

		// Slide up the form
		slideUp(this.form, { fade: true, timing: 600 });

		// Slide down the successMessage
		slideDown(this.formElements.successMessage, { fade: true });
	}

	sendData(formData) {
		fetch(this.ajaxUrl, {
			body: formData,
			method: 'POST',
		})
			.then((response) => {
				// Get the response status
				const { status } = response;

				// If the response status is 200 return the json data and move on
				if (status === 200) return response.json();

				// If any other status, throw the status to the catch
				throw status;
			})
			.then((data) => {
				if (data.success) {
					// Fire success message
					this.success();
				} else {
					// Get errors
					const { errors } = data;

					// Join the field names
					const errorFieldNamesString = errors.join(', ');

					console.log(data);

					this.handleError(
						new ProcessingError(
							'sending',
							`There looks like there might be an issue with the following field(s): <strong>${errorFieldNamesString}</strong>. If this persists please refresh and try again.`,
							`PHP mailing process returned errors for the following field(s): ${errorFieldNamesString}.`
						)
					);
				}
			})
			.catch((error) => {
				// Create an array containing the bad response numbers
				const badResponses = [400, 404, 500, 504];
				// Set the generic user facing error message for status problems
				const statusErrorMsg = 'There was a problem communicating with the form process, please try again.';

				let caughtError;

				if (badResponses.includes(error)) {
					caughtError = new ProcessingError('status', statusErrorMsg, `There was a bad response, status: ${error}.`);
				} else {
					caughtError = new ProcessingError(
						'sendCatch',
						'There was a problem trying to send your form details, please try again.',
						`Form send caught an error: ${error}.`
					);
				}

				this.handleError(caughtError);
			});
	}

	collectData() {
		// Init new FormData
		const formData = new FormData();
		// Get the action needed for WP Ajax
		const formAction = document.querySelector('[name="action"]').value;

		// Append the action
		formData.append('action', formAction);

		// Loop over the input fields and pass their values to the formData
		for (const name of Object.keys(this.validators)) {
			const input = document.querySelector(`[name="${name}"]`);

			if (!input.hasAttribute('disabled')) {
				const { value, type } = input;

				if (type === 'radio') {
					const radioValue = document.querySelector(`[name="${name}"]:checked`).value;
					formData.append(name, radioValue);
				} else {
					formData.append(name, value);
				}
			}
		}

		this.sendData(formData);
	}

	validate(name, validation) {
		const input = document.querySelector(`[name="${name}"]`);

		if (validation.type === 'valid' || input.hasAttribute('disabled')) return;

		let validationResult;

		switch (validation.type) {
			case 'regex':
				validationResult = this.regexValidation(input, validation.regex, validation.required);
				break;
			case 'checkbox':
				validationResult = this.checkboxValidation(input, validation.required);
				break;
			case 'select':
				validationResult = this.selectValidation(input);
				break;
			case 'radio':
				validationResult = this.radioValidation(name);
				break;
			default:
				this.handleError(
					new ProcessingError(
						'validation',
						"There's an issue trying to validate the form, please try again.",
						`Unable to find the validation type for the input: ${name}.`
					)
				);

				// end processing
				return;
		}

		const { valid, el } = validationResult;

		const hint = document.querySelector(`.js-form__hint--${name}`);

		if (!valid) {
			this.validationErrors.push({ el, hint });

			el.classList.add('form__input--invalid');
			if (hint) {
				slideDown(hint, { fade: true });
			}
		} else {
			el.classList.remove('form__input--invalid');
			if (hint) {
				slideUp(hint, { fade: true });
			}
		}
	}

	validateAll() {
		this.resetValidity();

		// Validate the given form name
		for (const [name, validation] of Object.entries(this.validators)) {
			this.validate(name, validation);
		}

		if (this.validationErrors.length === 0) {
			this.collectData();
		} else {
			this.validityShowing = true;
			this.enableInput(this.formElements.submitBtn);
		}
	}

	liveValidation(input) {
		// Get the input currently being used
		const name = input.getAttribute('name');
		// Grab the inputs validation rules from the validators object
		const validation = this.validators[name];

		// Call the validation
		this.validate(name, validation);
	}

	handleError(e) {
		// Show the user the user friendly error message
		this.formElements.errorMessage.innerHTML = e.message;
		slideDown(this.formElements.errorMessage);

		// Allow the submit to be clicked again
		this.enableInput(this.formElements.submitBtn);
	}

	toggleResponseFields(clickedTrigger) {
		// Get the data from the trigger clicked
		const { triggerGroup } = clickedTrigger.dataset;

		// Set a variable to hold the action. Select and Radio inputs get this information in different ways
		let action = '';

		if (clickedTrigger.tagName === 'SELECT') {
			// Get the selected option
			const selectedOption = clickedTrigger.options[clickedTrigger.selectedIndex];

			// Get the action of the selected option
			action = selectedOption.dataset.action;
		} else {
			// Get the action of the radio option
			action = clickedTrigger.dataset.action;
		}

		// Get the response group container
		const responseGroup = document.querySelectorAll(`[data-response-group="${triggerGroup}"]`);
		// Get the value of the response groups state
		const { stateValue } = responseGroup[0].dataset;

		// Check to see if a change is need
		const changeNeeded = action !== stateValue;

		if (changeNeeded) {
			// Get the input elements within the response group
			const responseElements = document.querySelectorAll(`[data-response-element="${triggerGroup}"]`);

			// Set whether or not you'd like the elements sliding in/out to fade
			const fade = true;

			for (const group of Object.values(responseGroup)) {
				// Update states
				group.dataset.state = action;

				if (action === 'show') {
					slideDown(group, { fade });
				} else {
					slideUp(group, { fade });
				}
			}

			for (const input of Object.values(responseElements)) {
				// Update states
				input.dataset.state = action;

				if (action === 'show') {
					this.enableInput(input);
				} else {
					this.disableInput(input);
				}
			}
		}
	}

	showInfo(target) {
		const groupParent = target.closest('.form__group');
		const infoBox = groupParent.querySelector('.form__info');

		slideDown(infoBox, { fade: true });
	}

	hideInfo() {
		const infoBoxes = this.form.querySelectorAll('.form__info');

		if (infoBoxes) {
			for (const box of infoBoxes) {
				slideUp(box, { fade: true });
			}
		}
	}
}
