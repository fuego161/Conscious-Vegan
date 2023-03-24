<?php
$flush = isset($footer_flush);

$menu_args = [
	'menu' => 'footer',
	'container' => '',
	'menu_class' => 'fnav__list',
	'items_wrap' => '<ul class="%2$s">%3$s</ul>',
	'walker' => new Walker_Menus('footer', 'fnav')
];
?>

		<footer class="footer <?php if ($flush) echo 'footer--flush'; ?>">

			<div class="footer__top">
				<div class="wrapper">

					<div class="footer__group footer__group--links">

						<h3 class="footer__title section-subtitle">Quick Links</h3>

						<?php wp_nav_menu($menu_args); ?>

					</div><!-- .footer__group -->

					<div class="footer__group footer__group--contact">

						<h3 class="footer__title section-subtitle">Contact Us</h3>

						<ul class="footer__list">

							<?php
							$contact_address = get_field('contact_address', 'contact_details');
							$contact_email = get_field('contact_email', 'contact_details');
							$contact_tel = get_field('contact_telephone', 'contact_details');

							if ($contact_address) {
							?>

								<li class="footer__item">
									<?php echo $contact_address; ?>
								</li>

							<?php
							}

							if ($contact_email) {
							?>

								<li class="footer__item">
									<a class="footer__link" href="mailto:<?php echo $contact_email; ?>">
										<?php echo $contact_email; ?>
									</a>
								</li>

							<?php
							}

							if ($contact_tel) {
								$contact_tel_stripped = get_field('contact_telephone_stripped', 'contact_details');
							?>

								<li class="footer__item">
									<a class="footer__link" href="tel: <?php echo $contact_tel_stripped; ?>">
										<?php echo $contact_tel; ?>
									</a>
								</li>

							<?php
							}
							?>

						</ul><!-- .footer__list -->

					</div><!-- .footer__group -->

					<?php
					if (have_rows('social_media', 'contact_details')) {
					?>

						<div class="footer__group footer__group--social">

							<h3 class="footer__title section-subtitle">Follow Us</h3>

							<ul class="footer__list">

								<?php
								while (have_rows('social_media', 'contact_details')) {
									the_row();

									$name = get_sub_field('name');
									$link = get_sub_field('link')['url'];
								?>

									<li class="footer__item">
										<a class="footer__link" href="<?php echo $link; ?>" target="_blank">
											<?php echo $name; ?>
										</a>
									</li>

								<?php
								}
								?>

							</ul><!-- .footer__list -->

						</div><!-- .footer__group -->

					<?php
					}
					?>

				</div><!-- .wrapper -->
			</div><!-- .footer__top -->

			<div class="footer__base base">
				<div class="wrapper">

					<!-- <p class="base__text">&copy; . All Rights Reserved</p> -->
					<a class="base__text base__text--link" href="https://tidydesign.com/" target="_blank">Website Design Portsmouth</a>

				</div><!-- .wrapper -->
			</div><!-- .footer__base -->

		</footer>

		<?php wp_footer(); ?>

	</body>
</html>
