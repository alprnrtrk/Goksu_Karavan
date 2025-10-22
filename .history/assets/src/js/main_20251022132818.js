import initLenis from './ui-elements/lenis.js';

const initHeroPartial = () => {
	const heroSections = document.querySelectorAll('[data-partial="hero"]');

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
	initLenis();
	initHeroPartial();
});
