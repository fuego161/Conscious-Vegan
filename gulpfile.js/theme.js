const { src, dest } = require('gulp');
const { task } = require('./setup');
const { theme } = require('./variables');

// Development task for copying wp-config into dev directory
const configTransfer = (done) => {
	return !task.isDist ? src('wp-config.php').pipe(dest('dev')) : done();
};

// Task for copying theme to the destination directory
const themeTransfer = () => {
	return src([`${theme}/**`, `!${theme}/assets/js/**`, `!${theme}/assets/scss/**`]).pipe(dest(task.destPath));
};

module.exports = {
	configTransfer,
	themeTransfer,
};
