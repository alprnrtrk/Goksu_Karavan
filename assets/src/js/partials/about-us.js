import registerCounter from "../ui-elements/gsap-counter";
import registerGsapParallaxImage from "../ui-elements/gsap-parallax-image";

export default function (node) {
  registerGsapParallaxImage(node)
  registerCounter(node)
}