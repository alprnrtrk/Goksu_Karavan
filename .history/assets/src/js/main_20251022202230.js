import gsap from "gsap";
import ScrollTrigger from "gsap-trial/ScrollTrigger"; // or "gsap/ScrollTrigger" for normal build
import initLenis from "./ui-elements/lenis.js";

// ✅ Register GSAP plugin
gsap.registerPlugin(ScrollTrigger);

document.addEventListener("DOMContentLoaded", () => {
  // ✅ Initialize your existing Lenis utility
  const lenis = initLenis({
    duration: 1.2,        // Override defaults if you want
    lerp: 0.1,            // Optional refinement
    smoothWheel: true,    // Already true by default
    smoothTouch: false,   // Already in your file
  });

  // ✅ If Lenis returns null (reduced motion), prevent ScrollTrigger desync
  if (!lenis) return;

  // ✅ Sync ScrollTrigger with Lenis
  lenis.on("scroll", ScrollTrigger.update);

  // ✅ Optional: Force refresh after init (good when using pinned sections)
  ScrollTrigger.refresh();
});
