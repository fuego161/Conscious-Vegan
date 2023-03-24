<?php
$location = isset($args['location']) ? $args['location'] : false;
$modifier = isset($args['modifier']) ? $args['modifier'] : false;
$is_sub_field = isset($args['is_sub_field']) ? $args['is_sub_field'] : true;

$title = flex_acf_get('gallery_title', $is_sub_field, $location);
$images = flex_acf_get('gallery', $is_sub_field, $location);

if ($images) {
?>

	<section class="c-gallery <?php echo 'c-gallery--' . $modifier; ?>">
		<div class="wrapper">

			<?php
			if ($title) {
			?>

				<h2 class="section-title"><?php echo $title; ?></h2>

			<?php
			}
			?>

			<div class="c-gallery__container">

				<div class="c-gallery__track" data-glide-el="track">
					<ul class="c-gallery__slides">

						<?php
						foreach ($images as $image) {
							$image_url = esc_url($image['url']);
							$image_caption = esc_html($image['caption']);

							$background_deceleration = 'background-image: url(' . $image_url . ');';
						?>

							<li class="c-gallery__slide" style="<?php echo $background_deceleration; ?>" data-src="<?php echo $image_url; ?>">
								<div class="c-gallery__spacer"></div>
							</li><!-- .gallery__slide -->

						<?php
						}
						?>

					</ul><!-- .c-gallery__slides -->
				</div><!-- .c-gallery__track -->

				<div class="c-gallery__toggle">
					<svg class="c-gallery__toggle-icon" width="100%" height="100%" viewbox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M24.807 13.256a7.762 7.762 0 00-4.177-1.19 8.595 8.595 0 00-3.728.861c-2.695 1.301-4.444 4.171-4.455 7.311-.01 2.951 1.746 5.765 4.486 7.177a8.184 8.184 0 003.614.836 8.303 8.303 0 004.246-1.178c2.377-1.416 3.862-4.094 3.873-6.991.008-2.692-1.473-5.308-3.859-6.826zm1.017 10.42c-1.109 1.745-3.081 2.786-5.273 2.786a6.5 6.5 0 01-2.821-.64c-2.352-1.21-3.716-3.674-3.477-6.275.235-2.562 2.109-4.771 4.658-5.5a5.905 5.905 0 011.619-.226c2.013 0 4.002 1.028 5.194 2.678 1.48 2.06 1.522 4.944.1 7.177z" fill="#fff"/>
						<path d="M40.135 15.923c-.453-1.368-.909-2.739-1.364-4.103-.161-.499-.696-.779-1.233-.649l-.421.1c-1.014.243-2.028.488-3.042.729a15.976 15.976 0 00-3.518-4.058c.376-.955.758-1.912 1.137-2.866l.176-.446c.206-.524.011-1.075-.466-1.312l-3.87-1.937c-.466-.233-1.039-.053-1.329.416l-1.859 3.037a16.085 16.085 0 00-5.358-.382l-1.413-3.271c-.22-.502-.775-.762-1.257-.599l-4.101 1.367c-.51.167-.782.686-.65 1.234l.831 3.466a15.892 15.892 0 00-4.059 3.517L5.027 8.851c-.51-.201-1.083 0-1.313.467l-1.936 3.866c-.237.473-.064 1.032.417 1.333 1.011.617 2.023 1.237 3.036 1.861a15.87 15.87 0 00-.382 5.356l-3.273 1.413c-.517.227-.77.757-.599 1.257l1.367 4.104a.992.992 0 00.962.679c.089 0 .183-.01.271-.032l.328-.078 3.138-.753a15.948 15.948 0 003.516 4.06l-1.313 3.314c-.204.525-.009 1.075.466 1.311l3.865 1.935c.47.238 1.044.053 1.331-.416a524.505 524.505 0 011.864-3.034c1.744.425 3.555.555 5.356.379l1.413 3.275c.174.395.541.648.94.648.105 0 .213-.018.316-.052l1.171-.389c.978-.325 1.954-.651 2.936-.975.503-.168.775-.687.645-1.235l-.831-3.464a15.994 15.994 0 004.059-3.519l3.315 1.315c.088.034.181.056.285.066a.956.956 0 001.026-.533l1.932-3.866c.239-.474.066-1.033-.415-1.332l-1.96-1.201-1.075-.66a15.96 15.96 0 00.381-5.358l3.27-1.413c.515-.223.768-.751.599-1.257zm-5.307 1.104c-.448.196-.707.614-.644 1.036.29 2.064.143 4.121-.439 6.113-.119.412.079.858.496 1.112l2.888 1.773-1.112 2.225-3.15-1.25c-.439-.172-.928-.069-1.188.27a14.433 14.433 0 01-4.634 4.017c-.374.208-.552.665-.44 1.139l.792 3.296c-.789.262-1.574.524-2.362.789-.33-.768-.662-1.533-.993-2.298l-.353-.816c-.175-.397-.531-.655-.911-.655a1.05 1.05 0 00-.125.009 14.48 14.48 0 01-6.117-.438c-.407-.116-.866.096-1.105.498l-1.775 2.888-2.224-1.113 1.248-3.147c.151-.375.127-.888-.271-1.19a14.445 14.445 0 01-4.013-4.626c-.201-.375-.667-.557-1.142-.447l-3.296.789-.785-2.362.213-.091a649.33 649.33 0 012.903-1.25c.443-.197.701-.614.642-1.037a14.455 14.455 0 01.437-6.116c.119-.408-.079-.854-.492-1.111-.966-.589-1.927-1.179-2.891-1.771l.12-.238.995-1.987 3.151 1.251c.435.17.932.063 1.183-.274a14.463 14.463 0 014.631-4.013c.379-.207.559-.665.446-1.141a984.628 984.628 0 01-.791-3.296c.785-.263 1.573-.524 2.358-.786l1.347 3.114c.191.439.612.704 1.034.643a14.441 14.441 0 016.118.441c.406.115.865-.094 1.107-.498l1.773-2.888 2.224 1.114-1.248 3.15c-.149.376-.124.889.27 1.188a14.45 14.45 0 014.017 4.63c.202.372.661.556 1.139.445l3.298-.789.787 2.359-3.116 1.339z" fill="#fff"/>
					</svg>
				</div><!-- .c-gallery__toggle -->

				<div class="c-gallery__overlay">

					<div class="c-gallery__switch c-gallery__switch--thumbs c-gallery__thumb-toggle">
						<svg class="c-gallery__icon" width="100%" height="100%" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 12h4v4h-4zM12 6h4v4h-4zM12 0h4v4h-4zM0 12h4v4H0zM6 12h4v4H6zM0 6h4v4H0zM6 6h4v4H6zM0 0h4v4H0zM6 0h4v4H6z"/>
						</svg>
					</div>

					<div class="c-gallery__bullets" data-glide-el="controls[nav]">

						<?php
						foreach ($images as $row => $image) {
						?>

							<button class="c-gallery__bullet" data-glide-dir="=<?php echo $row; ?>"></button>

						<?php
						}
						?>

					</div><!-- .gallery__bullets -->

					<div class="c-gallery__switch c-gallery__switch--lightbox">
						<svg class="c-gallery__icon" width="100%" height="100%" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 10a4.5 4.5 0 100-9 4.5 4.5 0 000 9zM5 3h1v2h2v1H6v2H5V6H3V5h2V3zm.5 8a5.5 5.5 0 114.432-2.242l.11.25L16 15l-1 1-6-6-.157-.132A5.476 5.476 0 015.5 11z"/>
						</svg>
					</div>

				</div><!-- .c-gallery__overlay -->

				<div class="c-gallery__thumbs">
					<div class="c-gallery__thumbs-wrapper" data-glide-el="controls[nav]">

						<?php
						foreach ($images as $row => $image) {
							$thumbnail_url = esc_url($image['sizes']['thumbnail']);
							$thumbnail_alt = esc_attr($image['alt']);
						?>

							<img class="c-gallery__thumb c-gallery__thumb-toggle" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $thumbnail_url; ?>" data-glide-dir="=<?php echo $row; ?>">

						<?php
						}
						?>

					</div><!-- .gallery__thumbs-wrapper -->
				</div><!-- .c-gallery__thumbs -->

			</div><!-- .gallery__container -->

		</div><!-- .wrapper -->
	</section><!-- .c-gallery -->

<?php
}
?>
