// Without TypeScript interfaces, a class is a good way to encapsulate the requirements for error reporting
export class ProcessingError {
	constructor(errorType, message, technicalMessage) {
		this.errorType = errorType;
		this.message = message;
		this.technicalMessage = technicalMessage;
	}
}

// Without TypeScript enums, an object in the global namespace is a good way to collect reusable generic resources like regexes
export const Regexes = {
	exists: /.+/,
	email: /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/,
	telephone: /(\+)?[0-9\s]{7,}/,
	leastAmountOfCharacters(amount) {
		return new RegExp(`^(.|\n){${amount},}`);
	},
	characterCountBetween(start, end) {
		return new RegExp(`^(.|\n){${start},${end}}$`);
	},
};
