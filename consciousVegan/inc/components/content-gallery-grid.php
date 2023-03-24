<?php
$location = isset($args['location']) ? $args['location'] : false;
$modifier = isset($args['modifier']) ? $args['modifier'] : false;
$is_sub_field = isset($args['is_sub_field']) ? $args['is_sub_field'] : true;

$title = flex_acf_get('gallery_title', $is_sub_field, $location);
$images = flex_acf_get('gallery', $is_sub_field, $location);

if ($images) {
?>

	<section class="g-gallery <?php echo 'g-gallery--' . $modifier; ?>">
		<div class="wrapper">

			<?php
			if ($title) {
			?>

				<h2 class="section-title"><?php echo $title; ?></h2>

			<?php
			}
			?>

			<div class="g-gallery__output">

				<?php
				foreach ($images as $image) {
					// Get the full size image url
					$full_size_url = esc_url($image['url']);

					// Get the thumbnail image url
					$thumbnail_url = esc_url($image['sizes']['gallery-thumb']);

					// Get the alt for the image
					$image_alt = esc_html($image['alt']);

					// Get the caption for the image
					$image_caption = $image['caption'];

					// Set the base for the gallery caption
					$gallery_caption = '';

					// If there's an alt tag for the image, add it as the title
					if ($image_alt) $gallery_caption.= 'title: ' . $image_alt . '; ';
					// If there's a caption for the image, add it as the description
					if ($image_caption) $gallery_caption.= 'description: ' . $image_caption . ';';

					// Check to see if the gallery caption has changed since being set
					$is_caption = $gallery_caption !== '';
				?>

					<a class="g-gallery__item" href="<?php echo $full_size_url; ?>" data-gallery="g-gallery" <?php if ($is_caption) echo 'data-glightbox="' . $gallery_caption . '"'; ?>>
						<img class="g-gallery__image" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $image_alt; ?>">
					</a><!-- .g-gallery__item -->

				<?php
				}
				?>

			</div><!-- .g-gallery__output -->

		</div><!-- .wrapper -->
	</section><!-- .g-gallery -->

<?php
}
?>
