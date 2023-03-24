/*
 * Dev + Dist process for WP theme project
 */
const { series, parallel, watch } = require('gulp');

const { wpInstall, installPlugins } = require('./setup');
const { configTransfer, themeTransfer } = require('./theme');
const { stylesLint, stylesCompile } = require('./styles');
const { scriptsLint, scriptsGroupCompile } = require('./scripts');
const { initLiveReload, reload } = require('./reload');
const { theme } = require('./variables');

const devSetup = series(wpInstall, themeTransfer, installPlugins);
const styles = series(stylesLint, stylesCompile);
const scripts = series(scriptsLint, scriptsGroupCompile);
const build = series(parallel(configTransfer, themeTransfer), parallel(styles, scripts));

const dev = () => {
	initLiveReload();

	build();

	watch('wp-config.php', configTransfer).on('all', reload);

	watch([`${theme}/**/*.php`, `${theme}/assets/img/**/*`, `${theme}/assets/fonts/**/*`], themeTransfer).on('all', reload);

	watch(`${theme}/assets/scss/**/*.scss`, styles).on('all', reload);

	watch(`${theme}/assets/js/**/*.js`, scripts).on('all', reload);
};

module.exports = {
	devSetup,
	styles,
	scripts,
	dev,
	build,
};
