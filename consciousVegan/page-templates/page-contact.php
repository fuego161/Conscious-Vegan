<?php
// Template Name: Contact

$form_data = [
	'form' => 'main',
	'action' => 'flex_main_form_process',
	'submit_text' => 'Submit',
	'sections' => [
		[
			'title' => '',
			'subtitle' => '',
			'split' => 'full',
			'fields' => [
				[
					'name' => 'Name',
					'type' => 'text',
					'label' => '',
					'required' => true,
					'hint' => 'Please enter your name',
					'has_info' => false,
					'info' => '',
					'group' => [
						'split' => '',
						'options' => [],
					],
					'notes' => '',
					'number_attributes' => [
						'min' => '',
						'max' => '',
						'step' => '1',
					],
					'override_group_split' => false,
					'split_individual' => '',
					'triggers_action' => false,
					'effects' => '',
					'responds' => false,
					'response' => [
						'responds_to' => '',
						'state' => '',
					],
				],
				[
					'name' => 'Email',
					'type' => 'email',
					'label' => '',
					'required' => true,
					'hint' => 'Please enter a valid email address',
					'has_info' => false,
					'info' => '',
					'group' => [
						'split' => '',
						'options' => [],
					],
					'notes' => '',
					'number_attributes' => [
						'min' => '',
						'max' => '',
						'step' => '1',
					],
					'override_group_split' => false,
					'split_individual' => '',
					'triggers_action' => false,
					'effects' => '',
					'responds' => false,
					'response' => [
						'responds_to' => '',
						'state' => '',
					],
				],
				[
					'name' => 'Telephone',
					'type' => 'tel',
					'label' => '',
					'required' => true,
					'hint' => 'Please enter a valid telephone number',
					'has_info' => false,
					'info' => '',
					'group' => [
						'split' => '',
						'options' => [],
					],
					'notes' => '',
					'number_attributes' => [
						'min' => '',
						'max' => '',
						'step' => '1',
					],
					'override_group_split' => false,
					'split_individual' => '',
					'triggers_action' => false,
					'effects' => '',
					'responds' => false,
					'response' => [
						'responds_to' => '',
						'state' => '',
					],
				],
				[
					'name' => 'Message',
					'type' => 'textarea',
					'label' => '',
					'required' => true,
					'hint' => 'Please enter a message over 30 characters',
					'has_info' => false,
					'info' => '',
					'group' => [
						'split' => '',
						'options' => [],
					],
					'notes' => '',
					'number_attributes' => [
						'min' => '',
						'max' => '',
						'step' => '1',
					],
					'override_group_split' => true,
					'split_individual' => 'full',
					'triggers_action' => false,
					'effects' => '',
					'responds' => false,
					'response' => [
						'responds_to' => '',
						'state' => '',
					],
				],
			],
		],
	],
];

$form = new FLEX_Form($form_data);

get_header();
?>

<section class="contact">
	<div class="wrapper">

		<div class="contact__split contact__split--details">
			<div class="contact__information">

				<h2 class="contact__title section-title">Contact Details</h2>

				<?php
				$contact_address = get_field('contact_address', 'contact_details');
				$contact_email = get_field('contact_email', 'contact_details');
				$contact_tel = get_field('contact_telephone', 'contact_details');

				if ($contact_address) {
				?>

					<p class="contact__details details">
						<strong class="details__type">Address</strong>

						<span class="details__text"><?php echo $contact_address; ?></span>
					</p>

				<?php
				}

				if ($contact_email) {
				?>

					<a class="contact__details details" href="mailto:<?php echo $contact_email; ?>">
						<strong class="details__type">Email</strong>

						<span class="details__text"><?php echo $contact_email; ?></span>
					</a>

				<?php
				}

				if ($contact_tel) {
					$contact_tel_stripped = get_field('contact_telephone_stripped', 'contact_details');
				?>

					<a class="contact__details details" href="tel:<?php echo $contact_tel_stripped; ?>">
						<strong class="details__type">Telephone</strong>

						<span class="details__text"><?php echo $contact_tel; ?></span>
					</a>

				<?php
				}

				if (have_rows('social_media', 'contact_details')) {
					$sm_icons_present = get_field('social_media_icons_present', 'contact_details');
				?>

					<p class="contact__details details">
						<strong class="details__type">Social Media</strong>
					</p>

					<ul class="contact__list">

						<?php
						while (have_rows('social_media', 'contact_details')) {
							the_row();

							$name = get_sub_field('name');
							$link = get_sub_field('link')['url'];
						?>

							<li class="contact__item <?php if ($sm_icons_present) echo 'contact__item--icon'; ?>">
								<a class="contact__link" href="<?php echo $link; ?>" target="_blank">

									<?php
									if ($sm_icons_present) {
										$icon = get_sub_field('icon');
									?>

										<span class="contact__icon">
											<?php echo $icon; ?>
										</span>

									<?php
									}

									echo $name;
									?>

								</a>
							</li>

						<?php
						}
						?>

					</ul><!-- .contact__list -->

				<?php
				}
				?>

			</div><!-- .contact__information -->
		</div><!-- .contact__split -->

		<div class="contact__split contact__split--form">

			<h2 class="contact__title section-title">Message Us</h2>

			<?php echo $form->render(); ?>

		</div><!-- .contact__split -->

	</div><!-- .wrapper -->
</section><!-- .contact -->

<?php
get_template_part('inc/components/flexible', 'cta', [
	'location' => get_the_ID(),
	'modifier' => 'contact',
	'is_sub_field' => false,
]);

get_footer();
?>
