import gsap from "gsap";
import ScrollTrigger from "gsap-trial/ScrollTrigger";

gsap.registerPlugin({ ScrollTrigger })

const options = {
  registiredAttribute: 'data-gsap-parallax-image',
  wrapperRegisterAttribute: 'wrapper',
  effectedImageAttribute: 'image'
}

function registerGsapParallaxImage() {
}