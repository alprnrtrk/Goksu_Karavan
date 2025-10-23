import gsap from "gsap";
import ScrollTrigger from "gsap-trial/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const options = {
  regAttribute: 'data-gsap-parallax-image',
  regWrapper: 'wrapper',
  regItem: 'image'
};

function registerGsapParallaxImage(node, settings = { yPercent: -30 }) {
  const effectedElements = node.querySelectorAll(`[${options.regAttribute}]`);
  if (!effectedElements.length) {
    console.warn(`no ${options.regAttribute} found on the page, gsap-parallax-image.js is useless?`);
    return;
  }

  const wrapperElements = node.querySelectorAll(
    `[${options.regAttribute}="${options.regWrapper}"]`
  );
  if (!wrapperElements.length) {
    console.warn(
      `no ${options.regAttribute}="${options.regWrapper}" found on the registered node. You need to define this attribute on one of the node's children.`
    );
    return;
  }

  wrapperElements.forEach((wrapperElement) => {
    const effectElementList = wrapperElement.querySelectorAll(
      `[${options.regAttribute}="${options.regItem}"]`
    );

    if (effectElementList.length > 1) {
      console.warn(
        `multiple ${options.regAttribute}="${options.regItem}" found in the registered wrapper node. You can only define one effected node.`
      );
      return;
    }

    if (!effectElementList.length) {
      console.warn(
        `no ${options.regAttribute}="${options.regItem}" found in wrapper`
      );
      return;
    }

    const effectElement = effectElementList[0];

    // ✅ PARALLAX EFFECT
    gsap.to(effectElement, {
      yPercent: settings.yPercent,
      ease: "none",
      scrollTrigger: {
        trigger: wrapperElement,
        start: "top bottom",
        end: "bottom top",
        scrub: true
      }
    });
  });
}

export default registerGsapParallaxImage;
