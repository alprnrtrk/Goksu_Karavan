import initLenis from './ui-elements/lenis.js';

document.addEventListener('DOMContentLoaded', () => {
  initLenis({
    duration: 1.2,
    smooth: true,
    lerp: 0.1,
    direction: "vertical",
    gestureDirection: "vertical",
    smoothTouch: false,
  })
});
