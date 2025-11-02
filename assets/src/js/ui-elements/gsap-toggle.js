import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

export function initGsapToggle() {
  const elements = document.querySelectorAll("[data-gsap-toggle]");

  elements.forEach((el) => {
    const device = el.dataset.device || "all"; // desktop | mobile | all
    const isMobile = window.innerWidth < 1024;

    // Skip based on device condition:
    if (
      (device === "desktop" && isMobile) ||
      (device === "mobile" && !isMobile)
    ) {
      return; // do nothing for this element
    }

    const toggleClass = el.dataset.gsapToggle || "active";
    const start = el.dataset.start || "top bottom";
    const end = el.dataset.end || "bottom top";
    const mode = el.dataset.mode || "inout"; // in | out | inout
    const markers = el.dataset.markers === "true";
    const delay = Number(el.dataset.delay || 0);

    const addClass = () => {
      gsap.delayedCall(delay, () => el.classList.add(toggleClass));
    };

    const removeClass = () => {
      gsap.delayedCall(delay, () => el.classList.remove(toggleClass));
    };

    ScrollTrigger.create({
      trigger: el,
      start,
      end,
      markers,

      onEnter: () => {
        if (mode === "in" || mode === "inout") addClass();
        if (mode === "out") removeClass();
      },

      onLeave: () => {
        if (mode === "inout") removeClass();
      },

      onEnterBack: () => {
        if (mode === "in" || mode === "inout") addClass();
        if (mode === "out") removeClass();
      },

      onLeaveBack: () => {
        if (mode === "inout") removeClass();
      },
    });
  });
}
