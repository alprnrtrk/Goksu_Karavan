import toggleClass from "../ui-elements/toggle-class";

export default function (node) {
  let lastScrollY = window.scrollY;
  let scrollTimeout = null;

  const onScroll = () => {
    const currentScrollY = window.scrollY;

    if (currentScrollY > 20) {
      node.classList.add('scrolled');

      if (currentScrollY > lastScrollY) {
        node.classList.add('scrolled-down');
      } else {
        node.classList.remove('scrolled-down');
      }
    } else {
      clearTimeout(scrollTimeout);
      node.classList.remove('scrolled', 'scrolled-down');
    }

    lastScrollY = currentScrollY;
  };

  window.addEventListener('scroll', onScroll);

  const toggleButton = node.querySelector('[data-mobile-toggler]')
  const mobileMenu = node.querySelector('[data-mobile-menu]')
  toggleClass(toggleButton, '[data-mobile-menu]')
}
