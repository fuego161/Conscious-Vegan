const { src, dest } = require('gulp');
const cache = require('gulp-cached');
const gulpif = require('gulp-if');

const eslint = require('gulp-eslint-new');
const browserify = require('browserify');
const babelify = require('babelify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const sourcemaps = require('gulp-sourcemaps');
const terser = require('gulp-terser');

const { task } = require('./setup');
const { theme, esLintIgnore } = require('./variables');

/*
 * Task for linting scripts.
 * Looks in the assets js folder for js files.
 * Runs a linting process which automatically fixes fixable errors.
 * Fixable errors get written to the source file.
 * Errors and warnings get printed to the console.
 * When running under "watch", it will only check changed files.
 * Will fail on errors when building distributed version.
 */
const scriptsLint = (done) => {
	const scriptsLintTask = () => {
		return src([`${theme}/assets/js/**/*`, ...esLintIgnore])
			.pipe(cache(scriptsLint))
			.pipe(eslint({ fix: true }))
			.pipe(cache(scriptsLint))
			.pipe(eslint.format('codeframe'))
			.pipe(gulpif(task.isDist, eslint.failAfterError()))
			.pipe(dest(`${theme}/assets/js/`));
	};

	return task.isStrict ? scriptsLintTask() : done();
};

/*
 * Task for compiling scripts
 * Using Browserify & Babel we're be able to work with the most recent JS features.
 * Browserify & Babel take our JS and compile it into es5 compatible JS.
 * When running dev this task will create sourcemaps.
 * When running dist this task will uglify our code.
 */
const scriptsCompile = (script) => {
	const bundler = browserify(`${theme}/assets/js/${script}.js`, {
		debug: true,
	}).transform(
		babelify.configure({
			presets: ['@babel/preset-env'],
			plugins: [['@babel/transform-runtime']],
		})
	);

	return bundler
		.bundle()
		.on('error', function handler(err) {
			console.error(err);
			this.emit('end');
		})
		.pipe(source(`${script}.js`))
		.pipe(buffer())
		.pipe(gulpif(task.isDev, sourcemaps.init({ loadMaps: true })))
		.pipe(gulpif(task.isDist, terser()))
		.pipe(gulpif(task.isDev, sourcemaps.write('./')))
		.pipe(dest(`${task.destPath}/assets/js/`));
};

/*
 * Group all calls of the scripts process, although we don't want lot's of JS files being individually called.
 * We should use modules and import into main scripts.
 * If a large script is needed elsewhere on a limited section of the site,
 * then consider creating a separate script and scriptsCompile() call.
 */
const scriptsGroupCompile = (done) => {
	scriptsCompile('main');
	return done();
};

module.exports = {
	scriptsLint,
	scriptsGroupCompile,
};
