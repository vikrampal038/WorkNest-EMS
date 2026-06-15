import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

window.Alpine = Alpine;
window.gsap = gsap;
Alpine.start();

gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {
    const marqueeInner = document.querySelector('.logo-marquee-inner');
    if (marqueeInner) {
        // Continuous horizontal scroll tween
        const roll = gsap.to(marqueeInner, {
            xPercent: -50,
            ease: 'none',
            duration: 25, // elegant speed
            repeat: -1
        });

        let isScrollingDown = true;

        ScrollTrigger.create({
            trigger: 'body',
            start: 'top top',
            end: 'bottom bottom',
            onUpdate: (self) => {
                const scrollDown = self.direction === 1;
                if (scrollDown !== isScrollingDown) {
                    isScrollingDown = scrollDown;
                    // Transition speed direction scale (1 for right-to-left, -1 for left-to-right)
                    gsap.to(roll, {
                        timeScale: scrollDown ? 1 : -1,
                        duration: 0.6,
                        ease: 'power2.out',
                        overwrite: 'auto'
                    });
                }
            }
        });
    }

    // Timeline scroll-bound progress bar animation (optimized with scaleY transforms for compositor-only thread performance)
    const timelineBar = document.querySelector('.timeline-progress-bar');
    const timelineWrapper = document.querySelector('.timeline-wrapper');
    if (timelineBar && timelineWrapper) {
        gsap.to(timelineBar, {
            scaleY: 1,
            ease: 'none',
            scrollTrigger: {
                trigger: timelineWrapper,
                start: 'top 55%',
                end: 'bottom 65%',
                scrub: true
            }
        });
    }

    // Helper function for premium, zero-stutter smooth scrolling
    const smoothScrollTo = (targetSelector, offset = 96) => {
        const target = document.querySelector(targetSelector);
        if (!target) return;
        
        const targetY = target.getBoundingClientRect().top + window.scrollY - offset;
        const obj = { y: window.scrollY };
        
        if (window.activeScrollTween) {
            window.activeScrollTween.kill();
        }
        
        window.activeScrollTween = gsap.to(obj, {
            y: targetY,
            duration: 1.3, // elegant, premium pace
            ease: 'power3.inOut', // zero initial velocity to guarantee zero frame drops
            onUpdate: () => window.scrollTo(0, obj.y),
            onComplete: () => {
                window.activeScrollTween = null;
            }
        });
    };

    // Listen to custom tab-switch events (footer module navigation)
    window.addEventListener('switch-demo-tab', (e) => {
        smoothScrollTo('#dashboard-preview');
    });

    // Intercept standard anchor clicks for a unified premium feel across the site
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        if (!link) return;
        
        const href = link.getAttribute('href');
        if (href && href.startsWith('#') && href.length > 1) {
            e.preventDefault();
            smoothScrollTo(href);
            history.pushState(null, null, href);
        }
    });

    // --- Premium GSAP Scroll Reveal Animations with Lenis ---
    
    // Initialize Lenis for buttery smooth scrolling
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        smoothWheel: true,
        wheelMultiplier: 1,
    });

    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => {
        lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);

    // 1. Fade Up (Direction-Aware Bounce)
    gsap.utils.toArray('.gsap-fade-up').forEach((elem) => {
        // Ensure element starts invisible before ScrollTrigger takes over
        gsap.set(elem, { opacity: 0 });
        
        ScrollTrigger.create({
            trigger: elem,
            start: 'top 85%',
            end: 'bottom 15%',
            onEnter: () => {
                gsap.fromTo(elem, 
                    { y: 80, opacity: 0 },
                    { y: 0, opacity: 1, duration: 1.2, ease: 'back.out(1.5)', overwrite: 'auto' }
                );
            },
            onEnterBack: () => {
                gsap.fromTo(elem, 
                    { y: -80, opacity: 0 },
                    { y: 0, opacity: 1, duration: 1.2, ease: 'back.out(1.5)', overwrite: 'auto' }
                );
            },
            onLeave: () => gsap.to(elem, { y: -50, opacity: 0, duration: 0.5, overwrite: 'auto' }),
            onLeaveBack: () => gsap.to(elem, { y: 50, opacity: 0, duration: 0.5, overwrite: 'auto' })
        });
    });

    // 2. Simple Fade In
    gsap.utils.toArray('.gsap-fade-in').forEach((elem) => {
        gsap.set(elem, { opacity: 0 });
        ScrollTrigger.create({
            trigger: elem,
            start: 'top 85%',
            end: 'bottom 15%',
            onEnter: () => gsap.to(elem, { opacity: 1, duration: 1.5, ease: 'power2.out', overwrite: 'auto' }),
            onEnterBack: () => gsap.to(elem, { opacity: 1, duration: 1.5, ease: 'power2.out', overwrite: 'auto' }),
            onLeave: () => gsap.to(elem, { opacity: 0, duration: 0.5, overwrite: 'auto' }),
            onLeaveBack: () => gsap.to(elem, { opacity: 0, duration: 0.5, overwrite: 'auto' })
        });
    });

    // 3. Staggered Items (Direction-Aware Bounce)
    gsap.utils.toArray('.gsap-stagger-container').forEach((container) => {
        const children = container.querySelectorAll('.gsap-stagger-item');
        if(children.length === 0) return;
        
        gsap.set(children, { opacity: 0 });
        
        ScrollTrigger.create({
            trigger: container,
            start: 'top 85%',
            end: 'bottom 15%',
            onEnter: () => {
                gsap.fromTo(children,
                    { y: 80, opacity: 0 },
                    { y: 0, opacity: 1, duration: 1, stagger: 0.1, ease: 'back.out(1.5)', overwrite: 'auto' }
                );
            },
            onEnterBack: () => {
                gsap.fromTo(children,
                    { y: -80, opacity: 0 },
                    { y: 0, opacity: 1, duration: 1, stagger: -0.1, ease: 'back.out(1.5)', overwrite: 'auto' }
                );
            },
            onLeave: () => gsap.to(children, { y: -50, opacity: 0, duration: 0.5, overwrite: 'auto' }),
            onLeaveBack: () => gsap.to(children, { y: 50, opacity: 0, duration: 0.5, overwrite: 'auto' })
        });
    });
});
