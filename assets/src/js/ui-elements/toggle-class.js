function toggleClass(node, target, className = 'active') {
  node.addEventListener('click', () => {
    node.classList.toggle(className)
    target.classList.toggle(className)
  })
}

export default toggleClass