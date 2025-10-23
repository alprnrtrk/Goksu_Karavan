import gsap from 'gsap';
import ScrollTrigger from 'gsap-trial/ScrollTrigger';

import initLenis from './ui-elements/lenis.js';

gsap.registerPlugin(ScrollTrigger);

function registerLenis() {
  let lenis = initLenis({
    duration: 1.2,
    smooth: true,
    lerp: 0.1,
    direction: "vertical",
    gestureDirection: "vertical",
    smoothTouch: false,
  })

  if (!lenis) return;

  lenis.on("scroll", ScrollTrigger.update);

  ScrollTrigger.refresh();
};

function registerPartials() {
  const partials = document.querySelectorAll('[data-partial]')

  partials.forEach(element => {

  });
}

document.addEventListener('DOMContentLoaded', () => {
  registerLenis();


});
