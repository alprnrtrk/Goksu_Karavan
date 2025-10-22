const initHeroPartial = () => {
	const heroSections = document.querySelectorAll('[data-hero-partial]');

	if (!heroSections.length) {
		return;
	}

	import('./partials/hero-partial.js')
		.then(({ default: bootHeroPartial }) => {
			heroSections.forEach((node) => {
				bootHeroPartial(node);
			});
		})
		.catch((error) => {
			// eslint-disable-next-line no-console
			console.error('Failed to load hero partial script.', error);
		});
};

document.addEventListener('DOMContentLoaded', () => {
	initHeroPartial();
});
