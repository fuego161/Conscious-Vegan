module.exports = {
	extends: ['stylelint-config-recommended-scss', 'stylelint-prettier/recommended'],
	rules: {
		// At-rule
		'at-rule-name-space-after': 'always',
		'at-rule-semicolon-newline-after': 'always',
		'at-rule-semicolon-space-before': 'never',
		// Unit
		'unit-no-unknown': true,
		'unit-case': 'lower',
		// Property
		'property-no-unknown': true,
		'property-no-vendor-prefix': true,
		'property-case': 'lower',
		// Keyframe declaration
		'keyframe-declaration-no-important': true,
		// Declaration
		'declaration-no-important': true,
		'declaration-colon-space-after': 'always',
		'declaration-colon-space-before': 'never',
		'declaration-bang-space-after': 'never',
		'declaration-bang-space-before': 'always',
		// Declaration block
		'declaration-block-no-duplicate-properties': true,
		'declaration-block-no-shorthand-property-overrides': true,
		'declaration-block-semicolon-space-before': 'never',
		'declaration-block-trailing-semicolon': 'always',
		// Block
		'block-no-empty': true,
		'block-opening-brace-newline-after': 'always-multi-line',
		'block-closing-brace-newline-before': 'always-multi-line',
		// Selector
		'selector-pseudo-class-no-unknown': true,
		'selector-pseudo-element-no-unknown': true,
		'selector-type-no-unknown': true,
		'selector-class-pattern': null,
		'selector-attribute-brackets-space-inside': 'never',
		'selector-attribute-quotes': 'always',
		'selector-combinator-space-after': 'always',
		'selector-combinator-space-before': 'always',
		'selector-pseudo-class-case': 'lower',
		'selector-pseudo-class-parentheses-space-inside': 'never',
		'selector-pseudo-element-case': 'lower',
		'selector-pseudo-element-colon-notation': 'single',
		'selector-type-case': 'lower',
		'no-descending-specificity': null,
		// Selector list
		'selector-list-comma-newline-after': 'always-multi-line',
		'selector-list-comma-space-before': 'never',
		// Comment
		'comment-no-empty': true,
		// General / Sheet
		'no-duplicate-selectors': true,
		'no-extra-semicolons': true,
		indentation: 'tab',
		'max-empty-lines': 2,
		// Number
		'number-max-precision': 3,
		'number-leading-zero': 'never',
		'number-no-trailing-zeros': true,
		// Shorthand property
		'shorthand-property-no-redundant-values': true,
		// Value
		'value-no-vendor-prefix': true,
		'value-keyword-case': 'lower',
		// Value List
		'value-list-comma-newline-after': 'always-multi-line',
		'value-list-comma-space-after': 'always-single-line',
		'value-list-comma-space-before': 'never',
		// Color
		'color-hex-case': 'lower',
		'color-hex-length': 'short',
		// Font
		'font-family-name-quotes': 'always-where-recommended',
		'font-weight-notation': 'numeric',
		// Function
		'function-comma-space-after': 'always',
		'function-parentheses-space-inside': 'never',
		'function-url-quotes': 'always',
		'function-max-empty-lines': 0,
		'function-name-case': 'lower',
		'function-whitespace-after': 'always',
		// String
		'string-quotes': 'single',
		// Length
		'length-zero-no-unit': true,
	},
};
