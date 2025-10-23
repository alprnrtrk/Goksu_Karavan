function toggleClass(node, target, className = 'active') {
  node.addEventListener('click', () => {
    node.toggleClass(className)
  })
}

export default toggleClass