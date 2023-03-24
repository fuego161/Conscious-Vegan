const browserSync = require('browser-sync').create();
const { url } = require('./variables');

const { reload } = browserSync;

const initLiveReload = () => {
	return browserSync.init({
		proxy: url,
		watch: true,
	});
};

module.exports = {
	initLiveReload,
	reload,
};
