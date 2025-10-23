import gsap from "gsap";
import ScrollTrigger from "gsap-trial/ScrollTrigger";

gsap.registerPlugin({ ScrollTrigger });

const options = {
  regAttribute: 'data-gsap-parallax-image',
  regWrapper: 'wrapper',
  regItem: 'image'
};

function registerGsapParallaxImage(node, settings) {
  const effectedItems = node.querySelectorAll(`[${options.regAttribute}]`);

  if (effectedItems.length) { console.warn(`no ${regAttribute} found on the page gsap-parallax-image.js is useless?`); return; };


};

export default registerGsapParallaxImage();