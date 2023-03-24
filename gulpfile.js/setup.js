const { src } = require('gulp');
const { argv } = require('yargs');
const shell = require('gulp-shell');
const { WPversion, theme, plugins } = require('./variables');

// Paths to the dev and dist directories
const themePathDev = `dev/wp-content/themes/${theme}`;
const themePathDist = `dist/${theme}`;

// Find the files dest path
const pathFinder = (isDist) => {
	return isDist ? themePathDist : themePathDev;
};

// Set a group of helpful task variables
const task = {
	isDist: argv.dist,
	isDev: !argv.dist,
	isStrict: argv.strict,
	destPath: pathFinder(argv.dist),
};

// Task for initial install of WP
const wpInstall = () => {
	return src('.').pipe(
		shell([
			`curl -O https://wordpress.org/${WPversion}.zip`,
			`unzip ${WPversion}.zip`,
			'mv wordpress dev',
			`rm ${WPversion}.zip`,
			'mv dev/wp-config-sample.php wp-config.php',
			'rm -rf dev/wp-content/themes/twentyfifteen',
			'rm -rf dev/wp-content/themes/twentysixteen',
			'rm -rf dev/wp-content/themes/twentyseventeen',
			'rm -rf dev/wp-content/themes/twentynineteen',
			'rm -rf dev/wp-content/themes/twentytwenty',
			'rm -rf dev/wp-content/themes/twentytwentyone',
			'rm -rf dev/wp-content/themes/twentytwentytwo',
			'rm -rf dev/wp-content/themes/twentytwentythree',
			'rm -rf dev/wp-content/plugins/akismet',
			'rm dev/wp-content/plugins/hello.php',
		])
	);
};

// Installs plugins, add to this as you develop, makes the next persons life easier
const installPlugins = () => {
	const shellCommands = [];

	for (const [plugin, version] of Object.entries(plugins)) {
		const command = [
			`curl -o ${plugin}.zip https://downloads.wordpress.org/plugin/${plugin}.${version}.zip`,
			`unzip ${plugin}.zip`,
			`mv ${plugin} dev/wp-content/plugins/`,
			`rm ${plugin}.zip`,
		];

		shellCommands.push(...command);
	}

	return src('.').pipe(shell(shellCommands));
};

module.exports = {
	themePathDev,
	themePathDist,
	task,
	pathFinder,
	wpInstall,
	installPlugins,
};
