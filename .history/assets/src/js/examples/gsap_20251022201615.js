/**
 * ============================
 * ✅ GSAP FREE FUNCTIONS & UTILITIES OVERVIEW
 * ============================
 * Here are the main free GSAP functions you'll use:
 *
 * 1️⃣ gsap.to()        → Animate TO a value
 * 2️⃣ gsap.from()      → Animate FROM a value
 * 3️⃣ gsap.fromTo()    → Animate FROM -> TO
 * 4️⃣ gsap.set()       → Instantly set values (no animation)
 * 5️⃣ gsap.timeline()  → Sequence multiple animations
 *
 * ✅ Easing (Built-in free eases)
 *    power1, power2, power3, power4 (in, out, inOut)
 *    elastic, bounce, back, expo, circ, sine
 *
 * ✅ Utilities
 *    gsap.utils.random()
 *    gsap.utils.toArray()
 *    gsap.utils.wrap()
 *    gsap.utils.clamp()
 *    gsap.utils.interpolate()
 *    gsap.utils.selector()
 *
 * ✅ Plugins available for FREE:
 *    - ScrollTrigger (scroll-based animations)
 *    - Draggable (drag elements)
 *    - MotionPathPlugin (move along path)
 *
 * ✅ HOW TO USE BELOW:
 * Just include gsap and scrolltrigger in HTML (CDN)
 * Then copy this JS into a file like main.js
 */


// ===========================
// 1️⃣ SIMPLE "TO" ANIMATION
// ===========================
gsap.to(".box1", {
  x: 200,
  duration: 1,
  rotation: 45,
  ease: "power2.out"
});

// ===========================
// 2️⃣ ANIMATE FROM (start off-screen)
// ===========================
gsap.from(".box2", {
  opacity: 0,
  y: 100,
  duration: 1.5
});

// ===========================
// 3️⃣ FROM - TO ANIMATION
// ===========================
gsap.fromTo(
  ".box3",
  { scale: 0.5, opacity: 0 },
  { scale: 1, opacity: 1, duration: 1 }
);

// ===========================
// 4️⃣ SET (Instant changes without animation)
// ===========================
gsap.set(".box4", { backgroundColor: "orange", borderRadius: "10px" });

// ===========================
// 5️⃣ TIMELINE (Sequence animations)
// ===========================
const tl = gsap.timeline({ repeat: -1, yoyo: true });

tl.to(".tl-box", { x: 200, duration: 1 })
  .to(".tl-box", { y: 100, duration: 1 })
  .to(".tl-box", { rotation: 360, duration: 1 });

// ===========================
// 6️⃣ ScrollTrigger Example (needs plugin)
// ===========================
gsap.registerPlugin(ScrollTrigger);

gsap.to(".scroll-box", {
  x: 300,
  duration: 2,
  scrollTrigger: {
    trigger: ".scroll-box",
    start: "top 80%",
    end: "bottom 20%",
    scrub: true, // sync with scroll
    markers: false // set to true for debugging
  }
});

// ===========================
// 7️⃣ UTILITY: Random Animation
// ===========================
gsap.to(".random-box", {
  x: () => gsap.utils.random(-200, 200),
  y: () => gsap.utils.random(-200, 200),
  duration: 2,
  repeat: -1,
  yoyo: true
});

// ===========================
// 8️⃣ UTILITY: toArray for looping multiple elements
// ===========================
gsap.utils.toArray(".multi-box").forEach((box, i) => {
  gsap.to(box, { x: 100 * (i + 1), duration: 1 });
});

// ===========================
// ✅ HTML EXAMPLE
// Copy + Paste this in a file named index.html
// ===========================
/**
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>GSAP Examples</title>
<style>
  .box, .tl-box, .scroll-box, .random-box, .multi-box {
    width: 80px; height: 80px; margin: 20px;
    background: lightblue; display: inline-block;
  }
</style>
</head>
<body>

<h1>GSAP Examples</h1>

<div class="box box1">TO</div>
<div class="box box2">FROM</div>
<div class="box box3">FROM-TO</div>
<div class="box box4">SET</div>

<div class="tl-box">Timeline</div>
<div class="scroll-box">Scroll</div>
<div class="random-box">Random</div>

<div class="multi-box">1</div>
<div class="multi-box">2</div>
<div class="multi-box">3</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="main.js"></script>
</body>
</html>
*/

