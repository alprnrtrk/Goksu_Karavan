export default function (node) {
  console.log('Hero partial loaded on:', node);
  node.innerHTML = "<p>Hero initialized!</p>";
}