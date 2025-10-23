import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function registerGsapParallaxImage(node) {
  const wrappers = node.querySelectorAll('[data-gsap-parallax-image="wrapper"]');
  if (!wrappers.length) return;

  wrappers.forEach(wrapper => {
    const images = [...wrapper.querySelectorAll('[data-gsap-parallax-image="image"]')];
    if (!images.length) return;

    // Create fast setters for each image
    const layers = images.map(img => {
      const power = Number(img.getAttribute('data-gsap-parallax-image-power')) || 1;
      return {
        power,
        setY: gsap.quickSetter(img, "yPercent", "px")
      };
    });

    // Single ScrollTrigger driving all layers
    ScrollTrigger.create({
      trigger: wrapper,
      start: "top bottom",
      end: "bottom top",
      scrub: true,
      onUpdate: self => {
        console.log(self);
        const progress = self.progress * 100; // Convert to % scale
        layers.forEach(layer => {
          layer.setY(progress * layer.power);
        });
      }
    });
  });
}

export default registerGsapParallaxImage;
