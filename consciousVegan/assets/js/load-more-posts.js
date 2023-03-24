import { ProcessingError } from './form/helpers';
import { slideDown, slideUp } from './_utils';

// Set the generic user facing error message
const genericErrorMsg = 'There was a problem retrieving more results, please try again.';
const errorMessageEl = document.querySelector('.results__error');

let currentPage = 1;

const handlePostCollectionError = (e) => {
	// Show the user the user friendly error message
	errorMessageEl.innerHTML = e.message;
	slideDown(errorMessageEl);
};

export const loadMoreResults = (btn, container, action) => {
	// If error is showing
	if (errorMessageEl.style.display === 'block') {
		// Hide it
		slideUp(errorMessageEl, { fade: false, duration: 10 });
	}

	// Create new form data for the post
	const postData = new FormData();

	// An object containing the data which will be appended to formData
	const data = {
		action,
		query: JSON.stringify(window.posts),
		page: currentPage,
	};

	// Loop over the data obj and append all formData
	for (const [name, value] of Object.entries(data)) {
		postData.append(name, value);
	}

	// Store default button text content
	const defaultBtnText = btn.textContent;
	// Set loading text
	btn.textContent = 'Loading...';

	fetch(window.wpAjaxUrl, {
		body: postData,
		method: 'POST',
	})
		.then((response) => {
			// Restore text
			btn.textContent = defaultBtnText;

			// Get the response status
			const { status } = response;

			// If the response status is 200 return the json data and move on
			if (status === 200) return response.text();

			console.log(status);

			// If any other status, throw the status to the catch
			throw status;
		})
		.then((posts) => {
			if (posts) {
				// Up the current page number
				currentPage += 1;

				// Insert the posts before the button
				container.insertAdjacentHTML('beforeend', posts);

				// Remove the button if we're on the last page
				if (currentPage === window.maxPage) {
					btn.remove();
				}
			} else {
				handlePostCollectionError(
					new ProcessingError('dataResponse', genericErrorMsg, 'PHP passed a response but there was no data')
				);
			}
		})
		.catch((error) => {
			// Create an array containing the bad response numbers
			const badResponses = [400, 404, 500];

			let caughtError;

			if (badResponses.includes(error)) {
				caughtError = new ProcessingError('status', genericErrorMsg, `There was a bad response, status: ${error}`);
			} else {
				caughtError = new ProcessingError(
					'generalCollection',
					genericErrorMsg,
					`There was a error collecting more results: ${error}.`
				);
			}

			handlePostCollectionError(caughtError);
		});
};
