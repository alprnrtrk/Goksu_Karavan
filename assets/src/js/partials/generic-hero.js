import Swiper from "swiper";
import { Navigation, Parallax, Autoplay } from "swiper/modules";
import 'swiper/css'

Swiper.use(Navigation, Parallax, Autoplay)

export default function (node) {
  const swiperWrapper = node.querySelector('[data-swiper="wrapper"]')

  new Swiper(swiperWrapper, {
    modules: [Parallax, Autoplay],
    speed: 1000,
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    autoplay: {
      speed: 500,
    },
    parallax: true
  })
}