import ScrollTrigger from 'gsap-trial/ScrollTrigger';
import initLenis from './ui-elements/lenis.js';

document.addEventListener('DOMContentLoaded', () => {
  let lenis = initLenis({
    duration: 1.2,
    smooth: true,
    lerp: 0.1,
    direction: "vertical",
    gestureDirection: "vertical",
    smoothTouch: false,
  })

  lenis.on("scroll", ScrollTrigger.update);
});
