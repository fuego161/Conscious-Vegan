module.exports = {
	extends: ['airbnb-base', 'plugin:prettier/recommended'],
	parserOptions: {
		ecmaVersion: 2020,
		sourceType: 'module',
		ecmaFeatures: {
			impliedStrict: true,
		},
	},
	env: {
		es6: true,
		browser: true,
	},
	rules: {
		'no-console': 0,
		'no-restricted-syntax': 0,
		'import/prefer-default-export': 0,
		'class-methods-use-this': 0,
		'no-param-reassign': ['error', { props: false }],
		'prettier/prettier': ['error', { endOfLine: 'auto' }],
	},
};
