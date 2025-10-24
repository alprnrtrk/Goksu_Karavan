import Swiper from "swiper";
import 'swiper/css';
import { Autoplay } from 'swiper/modules';

import registerGsapParallaxImage from "../ui-elements/gsap-parallax-image";

export default function (node) {
  registerGsapParallaxImage(node)

  const ratings = node.querySelectorAll('[data-star]');

  ratings.forEach(el => {
    const rating = parseInt(el.dataset.rating, 10) || 0;
    const stars = el.querySelectorAll('i');

    stars.forEach((star, index) => {
      if (index < rating) {
        star.classList.add('text-primary');
      } else {
        star.classList.remove('text-primary');
      }
    });
  });

  const swiperWrapper = node.querySelector('[data-swiper="wrapper"]');

  const swiper = new Swiper(swiperWrapper, {
    modules: [Autoplay],
    slidesPerView: 1, // always flowing
    spaceBetween: 30,
    loop: true,
    speed: 3000,
    allowTouchMove: true,
    freeMode: true,
    autoplay: {
      delay: 0,
    },
    breakpoints: {
      780: {
        slidesPerView: 3, // always flowing
      }
    }
  });
}
