import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import 'swiper/css'

Swiper.use(Navigation)

export default function (node) {
  const swiperWrapper = node.querySelector('[data-swiper="wrapper"]')

  new Swiper(swiperWrapper, {
    speed: 500,
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    centeredSlides: true,
    loopAddBlankSlides: true,
    navigation: {
      nextEl: node.querySelector('[data-swiper="next"]'),
      prevEl: node.querySelector('[data-swiper="prev"]'),
    },
    breakpoints: {
      780: {
        slidesPerView: 3,
        spaceBetween: 20,
      }
    }
  })
}