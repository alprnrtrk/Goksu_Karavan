function toggleClass(node, target, class : 'active') {
  node.addEventListener('click', () => {
    document.querySelectorAll(target)[0].toggleClass('active')
  })
}