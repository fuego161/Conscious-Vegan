import Glide from '@glidejs/glide';
import GLightbox from 'glightbox';
import { createCookie, readCookie, ready, slideDown, slideToggle, slideUp } from './_utils';
import { CarouselGallery } from './Carousel-Gallery';
import { loadMoreResults } from './load-more-posts';
import { FormProcessor } from './form/processor';
import { Regexes } from './form/helpers';

const openPrompt = (prompt) => {
	// Check to see if the prompt has been seen
	const promptSeen = readCookie('promptSeen');

	// If prompt hasn't been seen and it's present
	if (!promptSeen && prompt) {
		// Show the prompt
		slideDown(prompt, { fade: false });
	}
};

const closePrompt = () => {
	// Get the prompt
	const prompt = document.querySelector('.prompt');

	// Get the expires data
	const { expires } = prompt.dataset;

	// Stop it from showing again
	createCookie('promptSeen', true, expires);

	// Remove it
	slideUp(prompt, { fade: false });
};

const toggleNavState = () => {
	// Get the nav
	const nav = document.querySelector('.nav');
	// Get the navigation
	const navbar = document.querySelector('.navbar');
	// Get the classes from the navbar
	const navbarClasses = navbar.classList;
	// Set the open class
	const openClass = 'navbar--open';
	// Check to see if the navbar is open
	const isNavOpen = navbarClasses.contains(openClass);

	if (isNavOpen) {
		navbarClasses.remove(openClass);
		slideUp(nav);
	} else {
		navbarClasses.add(openClass);
		slideDown(nav);
	}
};

// Toggle Content
const toggleAccordionBlock = (trigger) => {
	// Get the toggle block parent of the trigger
	const toggleBlock = trigger.closest('.accordion__block');

	// Get the toggle content using the toggle block
	const toggleContent = toggleBlock.querySelector('.accordion__content');

	// Check to see if the class list contains 'open'. Add/remove as needed
	const openClass = 'accordion__block--open';
	if (toggleBlock.classList.contains(openClass)) {
		toggleBlock.classList.remove(openClass);
	} else {
		toggleBlock.classList.add(openClass);
	}

	// Toggle the state of the toggle content
	slideToggle(toggleContent);
};

// Share Posts
const fixedEncodeURIComponent = (str) => {
	return encodeURIComponent(str).replace(/[!'()*]/g, (c) => {
		return `%${c.charCodeAt(0).toString(16)}`;
	});
};

const sharePosts = (e, shareInfo) => {
	const parent = e.target.closest('.share__link');
	const { platform } = parent.dataset;

	const openArgs = {
		url: '',
		windowName: `${platform}Share`,
		windowFeatures: 'width=580, height=300',
	};

	switch (platform) {
		case 'facebook':
			openArgs.url = `https://www.facebook.com/sharer/sharer.php?u=${shareInfo.permalink}`;
			break;
		case 'twitter':
			openArgs.url = `https://twitter.com/intent/tweet?text=${shareInfo.title}&url=${shareInfo.permalink}`; // add "&via=TwitterHandle" to make this @ a user on share
			break;
		case 'linkedIn':
			openArgs.url = `https://www.linkedin.com/sharing/share-offsite/?url=${shareInfo.permalink}`;
			openArgs.windowFeatures = 'width=640, height=740';
			break;
		default:
			return false;
	}

	return window.open(...Object.values(openArgs));
};

ready(() => {
	// Event Handlers
	document.addEventListener('click', (e) => {
		const { target } = e;

		if (target.closest('.navbar__toggles')) {
			toggleNavState();
		} else if (target.matches('.prompt__close') || target.closest('.prompt__close')) {
			closePrompt();
		}
	});

	// Prompt
	const prompt = document.querySelector('.prompt');

	if (prompt) {
		openPrompt(prompt);
	}

	// Generic Slider
	const genericSlider = document.querySelectorAll('.slider');

	if (genericSlider.length > 0) {
		for (const sliderInstance of genericSlider) {
			const slides = sliderInstance.querySelectorAll('.slider__slide');

			// If there's more than one slide, setup Glide
			if (slides.length > 1) {
				// Set the glide options
				const options = {
					type: 'carousel',
					autoplay: 5000,
					animationDuration: 0,
					animationTimingFunc: 'ease-out',
					gap: 0,
					classes: {
						slide: {
							active: 'slider__slide--active',
						},
					},
				};

				// Initiate new Glide
				const slider = new Glide(sliderInstance, options);

				// Mount/Init the Glide slider
				slider.mount();
			} else {
				/*
				 * If there's one slide make it active
				 */
				slides[0].classList.add('slider__slide--active');
			}
		}
	}

	// Accordion
	const accordionContainer = document.querySelector('.accordion');

	if (accordionContainer) {
		accordionContainer.addEventListener('click', (e) => {
			const { target } = e;

			if (target.closest('.accordion__trigger')) {
				toggleAccordionBlock(target);
			}
		});
	}

	// Grid Gallery
	const gridGalleryContainer = document.querySelector('.g-gallery');

	if (gridGalleryContainer) {
		GLightbox({
			selector: '.g-gallery__item',
			loop: true,
			beforeSlideLoad: (slideData) => {
				const { slide } = slideData;
				const glightboxBody = slide.closest('#glightbox-body');
				glightboxBody.classList.add('glightbox-g-gallery');
			},
		});
	}

	// Carousel Gallery
	const carouselGalleryContainer = document.querySelector('.c-gallery');

	if (carouselGalleryContainer) {
		const gallery = new CarouselGallery('.c-gallery');

		carouselGalleryContainer.addEventListener('click', (e) => {
			const { target } = e;

			if (target.closest('.js-gallery__toggle')) {
				gallery.mobileOverlayToggle();
			} else if (target.closest('.c-gallery__thumb-toggle')) {
				gallery.thumbsOverlayToggle();
			} else if (target.closest('.c-gallery__switch--lightbox')) {
				gallery.openLightbox();
			}
		});
	}

	// Load More Blog Posts
	const loadMorePostsBtn = document.querySelector('.load-more--blog');

	if (loadMorePostsBtn) {
		// Get the blog posts containers
		const container = document.querySelector('.posts__output');

		// Fire the load more on click
		loadMorePostsBtn.addEventListener('click', () => loadMoreResults(loadMorePostsBtn, container, 'flex_load_more_posts'));
	}

	// Share Blog Post
	const share = document.querySelector('.share');

	if (share) {
		const shareInfoElements = {
			title: document.querySelector('.share__info .title'),
			permalink: document.querySelector('.share__info .permalink'),
		};

		const shareInfo = {
			title: fixedEncodeURIComponent(shareInfoElements.title.textContent),
			permalink: fixedEncodeURIComponent(shareInfoElements.permalink.textContent),
		};

		const shareLinks = document.querySelectorAll('.share__link');

		for (const link of Object.values(shareLinks)) {
			link.addEventListener('click', (event) => {
				event.preventDefault();
				sharePosts(event, shareInfo);
			});
		}
	}

	// Contact Form
	const mainForm = document.querySelector('.form');

	if (mainForm) {
		const defaultValidatorRules = {
			type: 'regex',
			required: true,
		};

		const validators = {
			name: {
				...defaultValidatorRules,
				regex: Regexes.exists,
			},
			email: {
				...defaultValidatorRules,
				regex: Regexes.email,
			},
			telephone: {
				...defaultValidatorRules,
				regex: Regexes.telephone,
			},
			message: {
				...defaultValidatorRules,
				regex: Regexes.leastAmountOfCharacters(30),
			},
		};
		// Configure a multi-form processor
		// eslint-disable-next-line no-unused-vars
		const mainFormProcessor = new FormProcessor(mainForm, validators, {
			submit(e) {
				e.preventDefault();
				this.disableInput(this.formElements.submitBtn);
				this.validateAll();
			},
			input(e) {
				const { target } = e;

				if (target.matches('.js-form__input') && this.validityShowing) {
					this.liveValidation(target);
				}
			},
		});
	}
});
