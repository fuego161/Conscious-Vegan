<?php
// Get the post of the date. Format example: 3rd January, 2019
$date = [
	'day' => get_the_date('j'),
	'suffix' => get_the_date('S'),
	'month_year' => get_the_date(' F, Y'),
];

// Get the posts title
$title = get_the_title();
// Get the posts thumbnail url
$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
// Get the post permalink
$url = get_permalink();
?>

<div class="posts__card card <?php if (isset($featured) && $featured) echo 'card--featured'; ?>">

	<div class="card__image" style="background-image: url('<?php echo $thumbnail_url; ?>');"></div>

	<div class="card__content">

		<p class="card__date date">
			<?php echo $date['day']; ?><sup class="date__suffix"><?php echo $date['suffix']; ?></sup>

			<?php echo $date['month_year']; ?>
		</p>

		<h3 class="card__subtitle section-subtitle">
			<?php echo $title; ?>
		</h3>

		<?php
		if (isset($featured) && $featured) {
			$snippet = wp_trim_words(get_field('intro_text', get_the_ID()), 50);
		?>

			<p class="card__snippet">
				<?php echo $snippet; ?>
			</p>

		<?php
			set_query_var('featured', false);
		}
		?>

		<a class="card__link btn" href="<?php echo $url; ?>">Read More</a>

	</div><!-- .card__content -->

</div><!-- .posts__card -->
