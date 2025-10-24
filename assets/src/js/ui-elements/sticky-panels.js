import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

function slidingPanels(node) {
  const panels = gsap.utils.toArray(node.querySelectorAll('[data-gsap-sticky-panel]'));
  const panelCount = panels.length;

  if (panelCount < 2) return;

  panels.forEach((panel, i) => {
    gsap.set(panel, { zIndex: panelCount + i, yPercent: i === 0 ? 0 : 100 });
  });

  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: node,
      start: "top top",
      end: `+=200%`,
      pin: true,
      scrub: 1.5,
    },
  });

  panels.forEach((panel, i) => {
    if (i > 0) {
      const prevPanel = panels[i - 1];
      tl.to(
        panel,
        {
          yPercent: 0,
          ease: "power2.inOut",
        },
        `panel-${i}`
      );

      tl.to(
        prevPanel,
        {
          yPercent: -i * 5,
          ease: "power2.inOut",
        },
        `panel-${i}`
      );
    }
  });
}

export default slidingPanels;