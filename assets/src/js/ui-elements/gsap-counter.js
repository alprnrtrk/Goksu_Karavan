import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function registerCounter(node) {
  const counters = node.querySelectorAll('[data-gsap-counter]');

  counters.forEach(counter => {
    const target = +counter.dataset.target || 0;
    const duration = +counter.dataset.duration || 2;
    const suffix = counter.dataset.suffix || '';
    const startVal = +counter.innerText || 0;

    ScrollTrigger.create({
      trigger: counter,
      start: "top 80%",
      once: true,
      onEnter: () => {
        const obj = { val: startVal };

        gsap.fromTo(
          obj,
          { val: startVal },
          {
            val: target,
            duration: duration,
            ease: "expo.out",
            onUpdate: () => {
              counter.textContent = Math.floor(obj.val) + suffix;
            }
          }
        );
      }
    });
  });
}

export default registerCounter;
