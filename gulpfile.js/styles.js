const { src, dest } = require('gulp');
const cache = require('gulp-cached');
const gulpif = require('gulp-if');

const styleLint = require('@ronilaukkarinen/gulp-stylelint');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const sourcemaps = require('gulp-sourcemaps');

const { task } = require('./setup');
const { theme, sassPaths, scssLintIgnore } = require('./variables');

/*
 * Task for linting styles.
 * Looks in the assets scss folder for scss files.
 * Runs a linting process which automatically fixes fixable errors.
 * Fixable errors get written to the source file.
 * Errors and warnings get printed to the console.
 * When running under "watch", it will only check changed files.
 * Will fail on errors when building distributed version.
 */
const stylesLint = (done) => {
	const stylesLintTask = () => {
		return src([`${theme}/assets/scss/**/*.scss`, ...scssLintIgnore])
			.pipe(cache(stylesLint))
			.pipe(
				styleLint({
					failAfterError: task.isDist,
					reporters: [{ formatter: 'verbose', console: true }],
					debug: true,
					fix: true,
				})
			)
			.pipe(cache(stylesLint))
			.pipe(dest(`${theme}/assets/scss/`));
	};

	return task.isStrict ? stylesLintTask() : done();
};

/*
 * Task for compiling styles
 * Using gulp-sass & autoprefixer we're be able to work with SCSS & most recent CSS features.
 * Browserify & Babel take our JS and compile it into es5 compatible JS.
 * When running dev this task will prefix our styles & create sourcemaps.
 * When running dist this task will prefix & uglify our styles.
 */
const stylesCompile = () => {
	const devPlugins = [
		autoprefixer({
			grid: 'no-autoplace',
		}),
	];

	const distPlugins = [
		autoprefixer({
			grid: 'no-autoplace',
		}),
		cssnano(),
	];

	const plugins = task.isDist ? distPlugins : devPlugins;

	return src(`${theme}/assets/scss/style.scss`)
		.pipe(gulpif(task.isDev, sourcemaps.init()))
		.pipe(
			sass({
				includePaths: sassPaths,
				quietDeps: true,
			}).on('error', sass.logError)
		)
		.pipe(postcss(plugins))
		.pipe(gulpif(task.isDev, sourcemaps.write('./')))
		.pipe(dest(`${task.destPath}/`));
};

module.exports = {
	stylesLint,
	stylesCompile,
};
