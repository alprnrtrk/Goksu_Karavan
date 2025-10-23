// ✅ Vite-compatible GSAP setup
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

/* ================================
   1️⃣ BASIC METHODS
================================ */
gsap.to(".box1", {
  x: 200,
  duration: 1,
  ease: "power2.out",
});

gsap.from(".box2", {
  opacity: 0,
  y: 100,
  duration: 1.5,
});

gsap.fromTo(
  ".box3",
  { scale: 0.5, opacity: 0 },      // FROM
  { scale: 1, opacity: 1, duration: 1 } // TO
);

gsap.set(".box4", { rotation: 45 }); // Instant, no animation


/* ================================
   2️⃣ TWEEN CALLBACKS (onStart, onUpdate, onComplete, onRepeat)
================================ */
gsap.to(".callback-box", {
  x: 300,
  duration: 2,
  repeat: 2,
  yoyo: true,
  onStart: () => console.log("Animation started"),
  onUpdate: () => console.log("Animating..."),
  onRepeat: () => console.log("Looping"),
  onComplete: () => console.log("Animation completed"),
});


/* ===================================
   3️⃣ TIMELINE (chaining + callbacks)
==================================== */
const tl = gsap.timeline({
  repeat: 1,
  yoyo: true,
  delay: 0.5,
  onStart: () => console.log("Timeline Start"),
  onComplete: () => console.log("Timeline Done"),
});

tl.to(".tl-step1", { x: 100, duration: 1 })
  .to(".tl-step2", { y: 100, duration: 1, ease: "back.out(2)" })
  .to(".tl-step3", { rotation: 360, duration: 1 });


/* ===================================
   4️⃣ STAGGER (fixed, directional, function-based)
==================================== */
gsap.to(".stagger-item", {
  y: -50,
  duration: 1,
  stagger: {
    amount: 1,      // total duration for stagger
    from: "center", // start from center, or "start", "end", "edges"
    ease: "power2.out",
  },
});


/* ================================
   5️⃣ EASINGS (common free ones)
================================ */
// Examples: "power1.out" | "power4.inOut" | "back.out(2)" | "elastic.out(1, 0.3)" | "bounce.in"

/* ================================
   6️⃣ GSAP UTILS
================================ */
console.log(gsap.utils.random(0, 100));
console.log(gsap.utils.clamp(0, 50, 75)); // returns 50
console.log(gsap.utils.wrap(["a", "b", "c"], 4)); // returns "b"


/* ===================================
   7️⃣ SCROLLTRIGGER - Basic Usage
==================================== */
gsap.to(".scroll-basic", {
  x: 300,
  scrollTrigger: {
    trigger: ".scroll-basic",
    start: "top 80%",
    end: "bottom 20%",
    scrub: 1,
  },
});


/* ===================================
   8️⃣ SCROLLTRIGGER CALLBACKS (onEnter, onLeave, onEnterBack, onLeaveBack)
==================================== */
ScrollTrigger.create({
  trigger: ".scroll-callback",
  start: "top 75%",
  end: "bottom 25%",
  onEnter: () => console.log("Entered section"),
  onLeave: () => console.log("Left section"),
  onEnterBack: () => console.log("Re-entered from bottom"),
  onLeaveBack: () => console.log("Leaving upward"),
});


/* ===================================
   9️⃣ SCROLLTIMELINE (pinned + scrub timeline)
==================================== */
const scrollTl = gsap.timeline({
  scrollTrigger: {
    trigger: ".scroll-timeline",
    start: "top top",
    end: "bottom 100%",
    scrub: 2,      // smooth scroll-based animation
    pin: true,     // keeps it fixed
  },
});

scrollTl
  .to(".step1", { x: 200, duration: 1 })
  .to(".step2", { x: 200, duration: 1 })
  .to(".step3", { x: 200, duration: 1 });


/* ===================================
   🔟 TOGGLE ACTIONS
==================================== */
// toggleActions: "play pause resume reset"
// Format: ON_ENTER ON_LEAVE ON_ENTER_BACK ON_LEAVE_BACK

gsap.to(".toggle-box", {
  x: 200,
  scrollTrigger: {
    trigger: ".toggle-box",
    start: "top center",
    toggleActions: "play reverse restart reset",
  },
});


/* ===================================
   ✅ SCRUB + PIN + SNAP
==================================== */
gsap.to(".snap-box", {
  x: 400,
  scrollTrigger: {
    trigger: ".snap-box",
    scrub: 1,
    snap: 1,  // jumps at end
    pin: true,
  },
});
