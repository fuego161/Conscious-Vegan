/*
 * Set the WordPress version
 * WPversion should be updated every time a new WP version is installed
 * If it's a fresh project: WPversion = 'latest'
 * Once project initialised: WPversion = 'wordpress-{versionNumber}', eg:  WPversion = 'wordpress-5.2.3'
 */
const WPversion = 'latest';

// Set the name of the theme
const theme = 'flex';

// The path to where your site is being served
const url = 'http://local/path/here';

/*
 * The WordPress plugins you use for the site
 * Keep this updated as you work on the site
 * 'plugin-name': 'version.number',
 * To get the plugin name, go to https://en-gb.wordpress.org/plugins/
 * And search for the plugin (won't work for plugins not on the marketplace, ACF Pro for instance)
 * Right click on the download button and grab the link, see WP Migrate DB example:
 * https://downloads.wordpress.org/plugin/wp-migrate-db.1.0.12.zip
 * https://downloads.wordpress.org/plugin/{plugin-name}.{version.number}.zip
 * Pass the plugin name and version number to the object below
 */
const plugins = {
	'acf-content-analysis-for-yoast-seo': '3.0.1',
	'classic-editor': '1.6.2',
	'wordpress-seo': '19.9',
	'wp-migrate-db': '2.4.2',
};

/*
 * Set the paths for the sass complier to look for
 * You need to tell the sass complier where it's expected to find the sass for your @imports
 * `${theme}/assets/scss/` caters for you scss files
 * Most other paths here should only need to be for finding your modules styles
 * Use normalize as an example
 */
const sassPaths = [
	`${theme}/assets/scss/`,
	'node_modules/normalize-scss/sass',
	'node_modules/@glidejs/glide/src/assets/sass',
	'node_modules/glightbox/dist/css',
];

/*
 * Files or directories to be ignored by the linter
 * Desirably all JS/SCSS files will be linted, but if we're importing a library we have no control over and can't import in any other way then add it to the ignore array below
 */
const esLintIgnore = [];
const scssLintIgnore = [`!${theme}/assets/scss/base/fonts.scss`];

module.exports = {
	WPversion,
	theme,
	url,
	plugins,
	sassPaths,
	esLintIgnore,
	scssLintIgnore,
};
