<?php
$show_prompt = get_field('show_prompt', 'prompt');
$pages_to_hide_on = get_field('pages_to_hide_on', 'prompt');

if ($show_prompt && !is_page($pages_to_hide_on)) {
	$expires = get_field('prompt_expires', 'prompt');
	$text = get_field('prompt_text', 'prompt');
	$button = get_field('prompt_link', 'prompt');
	$close_button = get_field('prompt_close_style', 'prompt');

	$button_url = $button['url'];
	$button_title = $button['title'];
	$button_target = $button['target'];
?>

	<section class="prompt" data-expires="<?php echo $expires; ?>">
		<div class="wrapper">

			<p class="prompt__text">
				<?php echo $text; ?>
			</p>

			<a
				class="prompt__btn btn prompt__close"
				href="<?php echo $button_url; ?>"
				title="<?php echo $button_title; ?>"
				target="<?php echo $button_target; ?>"
			>
				<?php echo $button_title; ?>
			</a>

			<?php
			if ($close_button) {
				$button_text = get_field('prompt_close_button_text', 'prompt');
			?>

				<a class="prompt__btn btn prompt__close" href="javascript:;">
					<?php echo $button_text; ?>
				</a>

			<?php
			}
			else {
			?>

				<svg class="prompt__icon prompt__close" width="100%" height="100%" viewbox="0 0 26 20" xmlns="http://www.w3.org/2000/svg">
					<path d="M3.707 19.092a1 1 0 010-1.414L20.677.708a1 1 0 111.415 1.413l-16.97 16.97a1 1 0 01-1.415 0z"/>
					<path d="M3.707.707a1 1 0 011.414 0l16.97 16.97a1 1 0 11-1.414 1.415L3.707 2.122a1 1 0 010-1.415z"/>
				</svg>

			<?php
			}
			?>

		</div>
	</section>

<?php
}
?>
