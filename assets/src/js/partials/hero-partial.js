import { gsap } from 'gsap';
import Swiper from 'swiper';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const animateHero = (node) => {
	const animatedElements = node.querySelectorAll('[data-hero-animate]');

	if (!animatedElements.length) {
		return;
	}

	gsap.from(animatedElements, {
		y: 24,
		opacity: 0,
		stagger: 0.15,
		duration: 0.8,
		ease: 'power2.out',
	});
};

const initHeroSlider = (node) => {
	const sliderNode = node.querySelector('[data-hero-slider]');

	if (!sliderNode) {
		return null;
	}

	return new Swiper(sliderNode, {
		modules: [Autoplay, Navigation, Pagination],
		loop: true,
		speed: 650,
		autoplay: {
			delay: 4500,
			disableOnInteraction: false,
		},
		pagination: {
			el: node.querySelector('[data-hero-pagination]'),
			clickable: true,
		},
		navigation: {
			nextEl: node.querySelector('[data-hero-next]'),
			prevEl: node.querySelector('[data-hero-prev]'),
		},
	});
};

const bootHeroPartial = (node) => {
	animateHero(node);
	initHeroSlider(node);
};

export default bootHeroPartial;
