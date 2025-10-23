import gsap from "gsap";
import ScrollTrigger from "gsap-trial/ScrollTrigger";

gsap.registerPlugin({ ScrollTrigger });

const options = {
  regAttribute: 'data-gsap-parallax-image',
  regWrapper: 'wrapper',
  regItem: 'image'
};

function registerGsapParallaxImage(node, settings) {
  const effectedElements = node.querySelectorAll(`[${options.regAttribute}]`);

  if (effectedElements.length) { console.warn(`no ${regAttribute} found on the page gsap-parallax-image.js is useless?`); return; };

  const wrapperElements = node.querySelectorAll(`[${options.regAttribute}="${options.regWrapper}"]`);

  if (wrapperElements.length) { console.warn(`no ${options.regAttribute}="${options.regWrapper}" found on the registired node you need to define this attribute one of the node's chlids`); return; };

  wrapperElements.forEach(wrapperElement => {
    const effectElement = wrapperElement.querySelectorAll(`[${options.regAttribute}="${options.regItem}"]`)

    if (wrapperElements.length !== 0) { console.warn(`multiple ${options.regAttribute}="${options.regItem}" found on the registired node you need to define this attribute one of the node's chlids`); return; };
  });

};

export default registerGsapParallaxImage();