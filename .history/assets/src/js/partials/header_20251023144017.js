import toggleClass from "../ui-elements/toggle-class";

export default function (node) {
  console.log('header loaded', node);

  let lastScrollY = window.scrollY;
  let scrollTimeout = null;

  const onScroll = () => {
    const currentScrollY = window.scrollY;

    if (currentScrollY > 20) {
      node.classList.add('scrolled');

      if (currentScrollY > lastScrollY) {
        node.classList.add('scrolled-down');
      } else {
        clearTimeout(scrollTimeout);
        node.classList.remove('scrolled-down');
      }
    } else {
      clearTimeout(scrollTimeout);
      node.classList.remove('scrolled', 'scrolled-down');
    }

    lastScrollY = currentScrollY;
  };

  window.addEventListener('scroll', onScroll);
}
