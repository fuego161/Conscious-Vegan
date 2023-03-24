<?php
$menu_args = [
	'menu' => 'main',
	'container' => '',
	'menu_class' => 'nav__list',
	'items_wrap' => '<ul class="%2$s">%3$s</ul>',
	'walker' => new Walker_Menus('main', 'nav')
];
?>

<section class="navbar">
	<div class="wrapper">

		<a class="navbar__home" href="<?php echo home_url(); ?>">
			<svg class="navbar__logo" width="100%" height="100%" viewbox="0 0 680 260" xmlns="http://www.w3.org/2000/svg">
				<path fill="#D84548" d="M0 0h680v260H0V0Z"/>
				<path fill="#fff" d="M148.26 94.194v31.646h50.074v16.343H148.26V182H129V78h75.705v16.194H148.26ZM241.108 78h19.26v87.657h54.222V182h-73.482V78ZM425.352 165.806V182h-77.778V78h75.704v16.194h-56.445v27.04h50.075v15.897h-50.075v28.675h58.519ZM528.777 182l-28.148-39.52L472.777 182H450.85l38.519-53.04L452.925 78h21.778l26.519 36.994L527.444 78h20.889l-36.297 50.217L551 182h-22.223Z"/>
			</svg>
		</a>

		<div class="navbar__toggles">
			<svg class="navbar__toggle navbar__toggle--open" width="26" height="18" viewBox="0 0 26 18" xmlns="http://www.w3.org/2000/svg">
				<path d="M0 0h26v2H0V0zM0 8h26v2H0V8zM0 16h26v2H0v-2z"/>
			</svg>

			<svg class="navbar__toggle navbar__toggle--close" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
				<path d="M1.515.101l18.384 18.385-1.414 1.414L.1 1.515z"/>
				<path d="M.1 18.485L18.485.101l1.414 1.414L1.514 19.9z"/>
			</svg>
		</div>

		<nav class="navbar__nav nav">
			<?php wp_nav_menu($menu_args); ?>
		</nav>

	</div>
</section>
