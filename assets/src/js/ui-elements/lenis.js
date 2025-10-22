import Lenis from 'lenis';

let lenisInstance = null;
let isAnimating = false;

const startRaf = (lenis) => {
	if (isAnimating) {
		return;
	}

	const raf = (time) => {
		lenis.raf(time);
		requestAnimationFrame(raf);
	};

	isAnimating = true;
	requestAnimationFrame(raf);
};

/**
 * Initialise smooth scrolling via Lenis.
 *
 * @param {import('lenis').LenisOptions} options
 * @returns {import('lenis').default|null}
 */
const initLenis = (options = {}) => {
	if (typeof window === 'undefined') {
		return null;
	}

	if (lenisInstance) {
		return lenisInstance;
	}

	const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
	if (prefersReducedMotion.matches) {
		return null;
	}

	const lenis = new Lenis({
		duration: 1.1,
		smoothWheel: true,
		smoothTouch: false,
		...options,
	});

	startRaf(lenis);

	lenisInstance = lenis;
	return lenisInstance;
};

export default initLenis;
