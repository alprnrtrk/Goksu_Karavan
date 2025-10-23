function toggleClass(node, target) {
  node.addEventListener('click', () => {
    document.querySelectorAll(target)[0].toggleClass('active')
  })
}