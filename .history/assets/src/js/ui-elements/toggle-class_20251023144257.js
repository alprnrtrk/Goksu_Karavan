function toggleClass(node, target, className = 'active') {
  node.addEventListener('click', () => {
    node.toggleClass(className)
    target.toggleClass(className)
  })
}

export default toggleClass