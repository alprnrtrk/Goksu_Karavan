import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function registerGsapParallaxImage(node) {
  const wrappers = node.querySelectorAll('[data-gsap-parallax-image="wrapper"]');
  if (!wrappers.length) return;

  wrappers.forEach(wrapper => {
    const images = [...wrapper.querySelectorAll('[data-gsap-parallax-image="image"]')];
    if (!images.length) return;

    const layers = images.map(img => {
      const power = Number(img.getAttribute('data-gsap-parallax-image-power')) || 1;
      return {
        power,
        setY: gsap.quickSetter(img, "y", "px") // ✅ use pixels now
      };
    });

    const maxOffset = wrapper.offsetHeight; // movement range (you can tweak)

    ScrollTrigger.create({
      trigger: wrapper,
      start: "top center",
      end: "bottom center",
      scrub: true,
      onUpdate: self => {
        const scrollOffset = self.progress * maxOffset;
        layers.forEach(layer => {
          layer.setY(scrollOffset * layer.power);
        });
      }
    });
  });
}

export default registerGsapParallaxImage;
