import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const options = {
  regAttribute: 'data-gsap-parallax-image',
  regWrapper: 'wrapper',
  regItem: 'image',
  regPower: 'power'
};

function registerGsapParallaxImage(node, settings = { yPercent: -30 }) {
  const wrappers = node.querySelectorAll(`[${options.regAttribute}="${options.regWrapper}"]`);

  // Exit quietly if no wrappers exist
  if (!wrappers.length) return;

  wrappers.forEach((wrapper) => {
    const images = wrapper.querySelectorAll(
      `[${options.regAttribute}="${options.regItem}"]`
    );

    if (!images.length) {
      console.warn(
        `No parallax items found inside wrapper:`, wrapper
      );
      return;
    }

    images.forEach((img) => {
      const powerAttr = img.getAttribute(`${options.regAttribute}-${options.regPower}`);
      const yPercent = powerAttr !== null ? Number(powerAttr) : settings.yPercent;

      if (isNaN(yPercent)) {
        console.warn(
          `Invalid power value "${powerAttr}" on:`, img,
          `Using default:`, settings.yPercent
        );
      }

      gsap.to(img, {
        yPercent: isNaN(yPercent) ? settings.yPercent : yPercent,
        ease: "none",
        scrollTrigger: {
          trigger: wrapper,
          start: "top bottom",
          end: "bottom top",
          scrub: true
        }
      });
    });
  });
}

export default registerGsapParallaxImage;
