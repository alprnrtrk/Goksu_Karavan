export default function (node) {
  console.log('header loaded', node);

  let lastScrollY = window.scrollY;
  let scrollTimeout = null;

  const onScroll = () => {
    const currentScrollY = window.scrollY;

    // If scrolled more than 20px, add 'scrolled'; otherwise, remove both classes
    if (currentScrollY > 20) {
      node.classList.add('scrolled');

      // Detect scrolling direction
      if (currentScrollY > lastScrollY) {
        // Scrolling down - delay adding 'scrolled-down'
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
          node.classList.add('scrolled-down');
        }, 1000);
      } else {
        // Scrolling up - remove 'scrolled-down' immediately
        clearTimeout(scrollTimeout);
        node.classList.remove('scrolled-down');
      }
    } else {
      // Reset if near top
      clearTimeout(scrollTimeout);
      node.classList.remove('scrolled', 'scrolled-down');
    }

    lastScrollY = currentScrollY;
  };

  window.addEventListener('scroll', onScroll);
}
