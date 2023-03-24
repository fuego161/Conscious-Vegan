import Glide from '@glidejs/glide';
import GLightbox from 'glightbox';
import { slideUp, slideDown } from './_utils';

export class CarouselGallery {
	constructor(selector) {
		// Get the gallery element
		this.gallery = document.querySelector(selector);

		// Get the selector name minus the class or ID selector
		this.selector = selector.slice(1);

		// Options for when initiating glide
		// Maybe look to merge later
		this.glideOptions = {
			type: 'carousel',
			autoplay: 20000,
			animationDuration: 0,
			gap: 0,
			classes: {
				swipeable: `${this.selector}--swipeable`,
				dragging: `${this.selector}--dragging`,
				type: {
					slider: `${this.selector}--slider`,
					carousel: `${this.selector}--carousel`,
				},
				slide: {
					clone: `${this.selector}__slide--clone`,
					active: `${this.selector}__slide--active`,
				},
				nav: {
					active: `${this.selector}__bullet--active`,
				},
				arrow: {
					disabled: `${this.selector}__arrow--disabled`,
				},
			},
		};

		// Options for when initiating glight
		// Maybe look to merge later
		this.glightOptions = {
			loop: true,
		};

		// Gallery Elements
		this.el = {
			mobileToggle: this.gallery.querySelector(`.${this.selector}__toggle`),
			controlsOverlay: this.gallery.querySelector(`.${this.selector}__overlay`),
			thumbsTrigger: this.gallery.querySelector(`.${this.selector}__switch--thumbs`),
			thumbsOverlay: this.gallery.querySelector(`.${this.selector}__thumbs`),
			slides: this.gallery.querySelectorAll(`.${this.selector}__slide`),
		};

		// Create new glide instance for the main gallery track
		this.slider = new Glide(this.gallery, this.glideOptions);

		// Create GLightbox
		this.lightbox = GLightbox(this.glightOptions);

		// Flags
		this.flags = {
			thumbsOverlayShowing: false,
		};

		this.init();
	}

	init() {
		// Mount/Init the Glide slider
		this.slider.mount();

		/*
		 * We want to manually set the lightbox elements
		 * This stop us having to have the main gallery track be the trigger
		 * Create lightboxElements and we'll push all elements into this
		 */
		const lightboxElements = [];

		for (const slide of this.el.slides) {
			// Get the href for setting the element from data-src
			const href = slide.dataset.src;

			// The type will always be set to image
			const tempElement = {
				type: 'image',
				href,
			};

			// Push the temp element into lightboxElements
			lightboxElements.push(tempElement);
		}

		// Set the lightbox elements with the result from above
		this.lightbox.setElements(lightboxElements);
	}

	mobileOverlayToggle() {
		// Simple class switching. Actual visible switching relies on CSS
		this.el.mobileToggle.classList.toggle(`${this.selector}__toggle--hidden`);
		this.el.controlsOverlay.classList.toggle(`${this.selector}__overlay--showing`);
	}

	thumbsOverlayToggle() {
		// Set the overlay hidden class
		const overlayHiddenClass = `${this.selector}__overlay--hidden`;

		// Set the options for the slideUp/Down
		const slideOps = { fade: true, duration: 250 };

		if (this.flags.thumbsOverlayShowing) {
			// Remove the class to make the control overlay disappear
			this.el.controlsOverlay.classList.remove(overlayHiddenClass);
			// Slide up the thumbs overlay
			slideUp(this.el.thumbsOverlay, slideOps);
		} else {
			// Add the class to make the control overlay disappear
			this.el.controlsOverlay.classList.add(overlayHiddenClass);
			// Slide down the thumbs overlay
			slideDown(this.el.thumbsOverlay, slideOps);
		}

		// Update the thumbs overlay state flag
		this.flags.thumbsOverlayShowing = !this.flags.thumbsOverlayShowing;
	}

	openLightbox() {
		// Get the current slide index
		const slideIndex = this.slider.index;

		// Set the lightbox to open at the slide index
		this.lightbox.settings.startAt = slideIndex;

		// Open the lightbox
		this.lightbox.open();
	}
}
