import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

import initLenis from './ui-elements/lenis.js';

gsap.registerPlugin(ScrollTrigger);

function registerLenis(duration = 1.2, lerp = 0.1) {
  const lenis = initLenis({
    duration,
    smooth: true,
    lerp,
    direction: "vertical",
    gestureDirection: "vertical",
    smoothTouch: false,
  });

  if (!lenis) return;

  function raf(time) {
    lenis.raf(time);
    ScrollTrigger.update(); // ensures triggers respond
    requestAnimationFrame(raf);
  }

  requestAnimationFrame(raf);
}

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
