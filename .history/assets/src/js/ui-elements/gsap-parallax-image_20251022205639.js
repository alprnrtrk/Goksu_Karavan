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

  if (effectedItems) { console.warn(node); console.warn(`missing attributes the element above (${options.regAttribute + options.regWrapper})`); return; };
};

export default registerGsapParallaxImage();