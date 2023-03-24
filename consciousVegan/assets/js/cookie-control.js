import mergeWith from 'lodash/mergeWith';

// Cookie Actions Start
const enableGtag = (id) => {
	if (window.dataLayer) {
		// If Google analytics has already been set up, re-enable it
		window[`ga-disable-${id}`] = false;
	} else {
		const gtagScript = document.createElement('script');
		const gtagInitScript = document.createElement('script');
		gtagScript.src = `https://www.googletagmanager.com/gtag/js?id=${id}`;

		const gtagInitScriptContents = [
			'window.dataLayer = window.dataLayer || [];',
			'function gtag() { dataLayer.push(arguments); }',
			'gtag("js", new Date());',
			`gtag("config", '${id}');`,
		];

		for (const code of gtagInitScriptContents) {
			const line = document.createTextNode(code);

			gtagInitScript.appendChild(line);
		}

		document.body.appendChild(gtagScript);
		document.body.appendChild(gtagInitScript);
	}
};
// Cookie Actions End

// See README for documentation
export const controlCookies = (overrideConfig = {}, gtagTrackingId = false) => {
	const cc = window.CookieControl;

	const defaultConfig = {
		product: 'COMMUNITY',
		position: 'LEFT',
		theme: 'LIGHT',
		initialState: 'OPEN',
		rejectButton: true,
		acceptBehaviour: 'recommended',
		necessaryCookies: ['wordpress_*', 'wp-*', 'wporg_*', 'comment_*'],
		optionalCookies: [
			{
				name: 'analytics',
				label: 'Analytical cookies',
				description: 'Analytical cookies help us to improve our website by collecting and reporting information on its usage.',
				cookies: ['_ga', '_gid', '_gat', '_gat*'],
				recommendedState: true,
				onAccept() {
					// Enable GTAG
					if (gtagTrackingId) enableGtag(gtagTrackingId);
				},
				onRevoke() {
					// Disable GTAG
					if (gtagTrackingId) window[`ga-disable-${gtagTrackingId}`] = true;
				},
			},
		],
	};

	// If GTAG ID is present, add the analytical cookies setup
	if (gtagTrackingId) {
		defaultConfig.optionalCookies.push({
			name: 'analytics',
			label: 'Analytical cookies',
			description: 'Analytical cookies help us to improve our website by collecting and reporting information on its usage.',
			cookies: ['_ga', '_gid', '_gat', '_gat*'],
			recommendedState: true,
			onAccept() {
				// Enable GTAG
				if (gtagTrackingId) enableGtag(gtagTrackingId);
			},
			onRevoke() {
				// Disable GTAG
				if (gtagTrackingId) window[`ga-disable-${gtagTrackingId}`] = true;
			},
		});
	}

	// Merge options
	const cookieConfig = mergeWith(defaultConfig, overrideConfig, (objValue, srcValue) => {
		if (Array.isArray(objValue) && typeof objValue[0] === 'string') {
			return objValue.concat(srcValue);
		}

		return undefined;
	});

	cc.load(cookieConfig);
};
