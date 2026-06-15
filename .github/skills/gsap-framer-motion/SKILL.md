---
name: gsap-framer-motion
description: 'Workflow for adding animations to React components using GSAP and Framer Motion. Use when implementing page transitions, scroll animations, hero reveals, or complex timelines.'
argument-hint: 'Describe the element and the desired animation effect'
user-invocable: true
---

# GSAP & Framer Motion Animation Workflow

This skill provides a standardized approach to implementing smooth, performant animations in our React application using either Framer Motion or GSAP.

## 1. Choose the Right Tool

**Use Framer Motion for:**
- Page transitions or route changes (`AnimatePresence`)
- Layout animations (automatic shared layout transitions)
- Mount/Unmount animations
- Simple hover/tap interactions
- State-driven animations (e.g., tied to React `useState`)

**Use GSAP for:**
- Complex, multi-step timelines (`gsap.timeline()`)
- Heavy scroll-driven animations with pinning (`ScrollTrigger`)
- Animating SVG paths or complex SVG manipulations
- High-performance animations involving lots of DOM nodes

## 2. Framer Motion Implementation Steps

1. Import required components: `import { motion, AnimatePresence } from 'framer-motion';`
2. Replace standard HTML tags with `motion` tags (e.g., `<motion.div>`).
3. Define the animation using `initial`, `animate`, and `exit` props.
4. Use `transition` to control timing, easing, and delay.
5. Extract reusable variants into separate objects if the animation is complex or shared.

## 3. GSAP Implementation Steps (React)

1. Use the `@gsap/react` package and its `useGSAP` hook for proper cleanup and scoping.
2. Import required modules: `import gsap from 'gsap';`, `import { useGSAP } from '@gsap/react';`
3. (If using ScrollTrigger): Register the plugin: `gsap.registerPlugin(ScrollTrigger);`
4. Set up a `useRef` for the container or specific elements.
5. Implement the animation inside `useGSAP()` to ensure it cleans up correctly on component unmount.

```javascript
import { useRef } from 'react';
import gsap from 'gsap';
import { useGSAP } from '@gsap/react';

function AnimatedComponent() {
  const container = useRef();
  
  useGSAP(() => {
    gsap.from('.box', { opacity: 0, y: 50, stagger: 0.1 });
  }, { scope: container });

  return (
    <div ref={container}>
      <div className="box">Box 1</div>
      <div className="box">Box 2</div>
    </div>
  );
}
```

## 4. Quality & Performance Checks

- **Cleanup:** Ensure GSAP animations are cleaned up (handled automatically by `useGSAP`, but manual timelines must be killed if implemented differently).
- **Accessibility:** Respect `prefers-reduced-motion`. In Framer Motion, use the `useReducedMotion` hook. In GSAP, check `window.matchMedia('(prefers-reduced-motion: reduce)')`.
- **Layout Thrashing:** Animate `transform` (like `x`, `y`, `scale`) and `opacity` rather than `width`, `height`, `top`, or `left` whenever possible.