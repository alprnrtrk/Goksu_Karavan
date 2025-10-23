function toggleClass(node, target, className = 'active') {
  node.addEventListener('click', () => {
    document.querySelectorAll(target)[0].toggleClass(className)
  })
}

export default toggleClass