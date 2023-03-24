<?php
$location = isset($args['location']) ? $args['location'] : false;
$modifier = isset($args['modifier']) ? $args['modifier'] : false;
$is_sub_field = isset($args['is_sub_field']) ? $args['is_sub_field'] : true;

// Check to see if main FAQ is set if so,
// We're going to be using this to output FAQ schema
$main_faq = flex_acf_get('main_faq', $is_sub_field, $location);

if (have_rows('faq_groups', $location)) {
?>

	<section class="accordion <?php echo 'accordion--' . $modifier; ?>">
		<div class="wrapper">

			<?php
			while (have_rows('faq_groups', $location)) {
				the_row();

				$title = get_sub_field('title');

				if (have_rows('faq')) {
			?>

					<div class="accordion__group">

						<?php
						if ($title) {
						?>

							<h2 class="accordion__subtitle section-subtitle">
								<?php echo $title; ?>
							</h2>

						<?php
						}

						while (have_rows('faq')) {
							the_row();

							$q = get_sub_field('faq_q');
							$a = get_sub_field('faq_a');
						?>

							<div class="accordion__block" <?php if ($main_faq) echo 'itemscope itemprop="mainEntity" itemtype="https://schema.org/Question"'; ?>>

								<div class="accordion__header accordion__trigger">

									<h3 class="accordion__question section-subtitle" <?php if ($main_faq) echo ' itemprop="name"'; ?>><?php echo $q; ?></h3>

									<div class="accordion__icon-holder">
										<svg class="accordion__icon" width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M.458 8.417a1.674 1.674 0 0 1 2.212 0L16 20.561 29.33 8.417a1.674 1.674 0 0 1 2.212 0c.61.557.61 1.459 0 2.015l-14.436 13.15a1.674 1.674 0 0 1-2.212 0L.458 10.433a1.337 1.337 0 0 1 0-2.015Z" />
										</svg>
									</div><!-- .accordion__icon-holder -->

								</div><!-- .accordion__header -->

								<div class="accordion__content" <?php if ($main_faq) echo ' itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"'; ?>>
									<p class="accordion__text" <?php if ($main_faq) echo ' itemprop="text"'; ?>>
										<?php echo $a; ?>
									</p>
								</div><!-- .accordion__content -->

							</div><!-- .accordion__block -->

						<?php
						}
						?>

					</div><!-- .accordion__group -->

			<?php
				}
			}
			?>

		</div><!-- .wrapper -->
	</section><!-- .accordion -->

<?php
}
?>
