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

async function registerPartials(regPartial = 'data-partial') {
  const partials = document.querySelectorAll(`[${regPartial}]`);

  for (const element of partials) {
    const partialName = element.getAttribute(`${regPartial}`);

    try {
      const module = await import(`./partials/${partialName}.js`);
      if (typeof module.default === 'function') {
        module.default(element);
      } else {
        console.warn(`Partial "${partialName}" does not export a default function.`);
      }
    } catch (err) {
      console.error(`Failed to load partial "${partialName}":`, err);
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  registerLenis();
  registerPartials();
});
