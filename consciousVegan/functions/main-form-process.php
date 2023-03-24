<?php
function cv_main_form_process() {
	$return = [
		'errors' => [],
		'success' => false
	];

	// Retrieve & validate form fields
	// Name
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$name_validated = '';

	// Must be present
	if (!empty($name)) {
		$name_validated = $name;
	}
	else {
		$return['errors'][] = 'Name';
	}

	// Email
	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	$email_validated = '';

	// Must be an email
	if (!empty($email) && preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $email) == 1 && filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
		$email_validated = $email;
	} else {
		$return['errors'][] = 'Email';
	}

	// Telephone
	$telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
	$telephone_validated = '';

	// Must be a telephone number
	if (!empty($telephone) && preg_match('/(\+)?[0-9\s]{7,}/', $telephone) == 1) {
		$telephone_validated = $telephone;
	} else {
		$return['errors'][] = 'Telephone';
	}

	// Message
	$message = isset($_POST['message']) ? $_POST['message'] : '';
	$message_validated = '';

	// Must be longer than 30 characters
	if (!empty($message) && preg_match('/.{30,}/', $message) == 1) {
		$message_validated = $message;
	} else {
		$return['errors'][] = 'Message';
	}

	if (count($return['errors']) === 0) {
		// Send email
		$to = 'EMAIL_HERE';
		$from = strip_tags($email_validated);
		$headers = "From: " . $name_validated . " <" . $from . ">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8";

		$subject = 'Enquiry via {COMPANY_NAME} Website';

		$styles = '
			<style>
				p,
				li {
					font-size: 14px;
					color: #000;
					line-height: 135%;
				}

				ul {
					margin-top: 8px;
					margin-bottom: 8px;
				}
				li {
					margin-bottom: 6px;
				}
			</style>
		';

		$content = "
			<p>Hello {COMPANY_NAME},</p>

			<p>You've been contacted via the {COMPANY_NAME} website.</p>

			<h3>Contact Information:</h3>
			<ul>
				<li><strong>Name:</strong> " . $name_validated . "</li>
				<li><strong>Email:</strong> " . $email_validated . "</li>
				<li><strong>Telephone:</strong> " . $telephone_validated . "</li>
			</ul>

			<h3>Message Given:</h3>
			<p>" . $message_validated . "</p>
		";

		$body = $styles . $content;

		$return['success'] = wp_mail($to, $subject, $body, $headers);
	}

	echo json_encode($return);
	die();
}
add_action('wp_ajax_cv_main_form_process', 'cv_main_form_process');
add_action('wp_ajax_nopriv_cv_main_form_process', 'cv_main_form_process');
