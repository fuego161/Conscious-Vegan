<section class="posts">
	<div class="wrapper">

		<div class="posts__output">
			<?php
			set_query_var('featured', true);

			while (have_posts()) {
				the_post();

				get_template_part('inc/shared-loops/content', 'blog-posts');
			}
			?>
		</div><!-- posts__output -->

		<?php
		global $wp_query;
		$max_pages = $wp_query->max_num_pages;

		if ($max_pages > 1) {
		?>

			<span class="load-more load-more--blog btn">More Posts</span>

			<p class="results__error"></p>

		<?php
		}
		?>

	</div><!-- .wrapper -->
</section><!-- .posts -->
