// Document Ready
export const ready = (cb) => {
	if (document.readyState !== 'loading') {
		// Document is already ready, call the callback directly
		cb();
	} else if (document.addEventListener) {
		// All modern browsers to register DOMContentLoaded
		document.addEventListener('DOMContentLoaded', cb);
	} else {
		// Old IE browsers
		document.attachEvent('onreadystatechange', function docReady() {
			if (document.readyState === 'complete') {
				cb();
			}
		});
	}
};

// Throttle
export const throttle = (func, duration) => {
	let shouldWait = false;

	return (...args) => {
		if (!shouldWait) {
			func.apply(this, args);
			shouldWait = true;

			setTimeout(() => {
				shouldWait = false;
			}, duration);
		}
	};
};

// Slide Functions (Up, Down, Toggle)
// Set default options
const defaultOptions = {
	display: 'block',
	timing: 350,
	fade: false,
};

// Merges the user options with the default options
const getOptions = (givenOptions) => {
	return { ...defaultOptions, ...givenOptions };
};

const hiddenElementStyles = (target, fade) => {
	target.style.overflow = 'hidden';
	target.style.height = 0;
	target.style.paddingTop = 0;
	target.style.paddingBottom = 0;
	target.style.marginTop = 0;
	target.style.marginBottom = 0;
	if (fade) target.style.opacity = 0;

	return target;
};

export const slideUp = (target, options, callback = false) => {
	const mergedOptions = getOptions(options);

	const { timing, fade } = mergedOptions;

	if (callback) {
		target.ontransitionend = () => {
			callback();
		};
	}

	// Get the targets current height
	const height = target.offsetHeight;

	// Set the base styles before sliding up
	let transitionProperties = 'height, margin, padding';
	if (fade) transitionProperties += ', opacity';

	target.style.height = `${height}px`;
	target.style.transitionProperty = transitionProperties;
	target.style.transitionDuration = `${timing}ms`;

	// Set the the hidden element styles
	setTimeout(() => {
		hiddenElementStyles(target, fade);
	}, 10);

	// After the end of the transition set to display none and remove styles applied above
	setTimeout(() => {
		target.style.display = 'none';
		target.style.removeProperty('height');
		target.style.removeProperty('padding-top');
		target.style.removeProperty('padding-bottom');
		target.style.removeProperty('margin-top');
		target.style.removeProperty('margin-bottom');
		target.style.removeProperty('overflow');
		target.style.removeProperty('transition-duration');
		target.style.removeProperty('transition-property');
	}, timing);
};

export const slideDown = (target, options, callback = false) => {
	const mergedOptions = getOptions(options);

	const { display, timing, fade } = mergedOptions;

	if (callback) {
		target.ontransitionend = () => {
			callback();
		};
	}

	// Get the live display property value
	const currentDisplay = window.getComputedStyle(target).display;

	// If already showing, leave
	if (currentDisplay !== 'none') return;

	// Remove the current display property if present
	target.style.removeProperty('display');

	// If display is currently none change the value to block
	if (currentDisplay === 'none') target.style.display = display;

	// Get the targets current height
	const height = target.offsetHeight;

	// Set the the hidden element styles
	hiddenElementStyles(target);

	// Set the base styles before sliding down
	let transitionProperties = 'height, margin, padding';

	if (fade) transitionProperties += ', opacity';

	// Slide down the element
	target.offsetHeight; // eslint-disable-line no-unused-expressions
	target.style.transitionProperty = transitionProperties;
	target.style.transitionDuration = `${timing}ms`;
	target.style.height = `${height}px`;
	target.style.removeProperty('opacity');
	target.style.removeProperty('padding-top');
	target.style.removeProperty('padding-bottom');
	target.style.removeProperty('margin-top');
	target.style.removeProperty('margin-bottom');

	// Remove unnecessary properties
	setTimeout(() => {
		target.style.removeProperty('height');
		target.style.removeProperty('overflow');
		target.style.removeProperty('transition-duration');
		target.style.removeProperty('transition-property');
	}, timing);
};

export const slideToggle = (target, options, callback = false) => {
	const currentDisplay = window.getComputedStyle(target).display;

	if (currentDisplay === 'none') return slideDown(target, options, callback);

	return slideUp(target, options, callback);
};

/*
 * Cookie Related
 */
export const createCookie = (name, value, days) => {
	let expires = '';

	if (days) {
		const date = new Date();

		date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);

		expires = `; expires=${date.toGMTString()}`;
	}

	document.cookie = `${name}=${value}${expires}; path=/`;
};

export const readCookie = (name) => {
	const nameEQ = `${name}=`;
	const ca = document.cookie.split(';');

	for (let i = 0; i < ca.length; i += 1) {
		let c = ca[i];

		while (c.charAt(0) === ' ') {
			c = c.substring(1, c.length);
		}

		if (c.indexOf(nameEQ) === 0) {
			return c.substring(nameEQ.length, c.length);
		}
	}

	return null;
};

export const eraseCookie = (name) => {
	createCookie(name, '', -1);
};
