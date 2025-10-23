function toggleClass(node: HTMLElement, target: HTMLElement, className = 'active') {
  node.addEventListener('click', () => {
    node.classList.toggleClass(className)
    target.classList.toggleClass(className)
  })
}

export default toggleClass