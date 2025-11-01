import slidingPanels from "../ui-elements/sticky-panels";

export default function (node) {
  console.log('sliding about partial loaded on:', node);

  if (window.innerWidth > 780) {
    slidingPanels(node)
  }
}