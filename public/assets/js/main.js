/**
 * Minimal JS — enhancement only. The site works without it.
 *  - mobile nav toggle
 *  - footer year
 *  - submit lock (prevents double POST)
 *  - scroll reveals (guarded by prefers-reduced-motion)
 *  - pointer spotlight + 3D tilt on project rows
 *  - gentle 3D tilt on focus cards and the portrait avatar
 *  - background parallax + floor drift (CSS-var driven)
 */

(function () {
  'use strict';

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  var toggle = document.querySelector('.nav-toggle');
  var links = document.querySelector('.nav-links');

  if (toggle && links) {
    toggle.addEventListener('click', function () {
      var open = links.classList.toggle('open');
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    });

    links.addEventListener('click', function (event) {
      if (event.target.closest('a')) {
        links.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  var year = document.querySelector('[data-year]');
  if (year) {
    year.textContent = String(new Date().getFullYear());
  }

  // Accent theme toggle — green (default) ↔ amber, persisted in localStorage.
  // The head script applies the stored theme pre-paint; this keeps the button
  // in sync and handles the flip from this point on.
  var themeBtn = document.querySelector('.theme-toggle');
  if (themeBtn) {
    function applyTheme(theme) {
      var amber = theme === 'amber';
      document.documentElement.setAttribute('data-theme', amber ? 'amber' : '');
      themeBtn.setAttribute('aria-pressed', String(amber));
    }
    applyTheme(localStorage.getItem('accent-theme') === 'amber-v2' ? 'amber' : 'green');
    themeBtn.addEventListener('click', function () {
      var current = document.documentElement.getAttribute('data-theme') === 'amber';
      var next = current ? 'green' : 'amber';
      try { localStorage.setItem('accent-theme', next === 'amber' ? 'amber-v2' : ''); } catch (e) {}
      applyTheme(next);
    });
  }

  var form = document.querySelector('form[data-ajax-lock]');
  if (form) {
    form.addEventListener('submit', function () {
      var button = form.querySelector('[type="submit"]');
      if (button) {
        button.disabled = true;
        button.textContent = 'Sending…';
      }
    });
  }

  // Terminal status line — cycles through the messages in data-cycle.
  var cycleEl = document.querySelector('[data-cycle]');
  if (cycleEl && !reduceMotion) {
    var messages = [];
    try { messages = JSON.parse(cycleEl.getAttribute('data-cycle') || '[]'); } catch (e) {}
    if (messages.length > 1) {
      var cycleIdx = 0;
      setInterval(function () {
        cycleIdx = (cycleIdx + 1) % messages.length;
        cycleEl.textContent = messages[cycleIdx];
        cycleEl.style.opacity = '0';
        requestAnimationFrame(function () {
          cycleEl.style.transition = 'opacity 0.25s ease-out';
          cycleEl.style.opacity = '1';
        });
      }, 3200);
    }
  }

  // Typed hero headline — types the name char by char, keeps the block
  // caret blinking. Skipped entirely under prefers-reduced-motion.
  var typeEl = document.querySelector('.hero h1[data-type]');
  if (typeEl && !reduceMotion) {
    var full = typeEl.textContent.trim();
    var caretHtml = '<span class="type-caret" aria-hidden="true"></span>';
    var typed = '';
    var idx = 0;
    typeEl.innerHTML = caretHtml;
    var typeTimer = setInterval(function () {
      idx += 1;
      typed = full.slice(0, idx);
      typeEl.innerHTML = typed + caretHtml;
      if (idx >= full.length) { clearInterval(typeTimer); }
    }, 55);
  }

  // Scroll reveals — only activate the entrance state when JS is on
  // and the user has not asked for reduced motion.
  var revealRoots = document.querySelectorAll('[data-reveal]');
  if (!reduceMotion && 'IntersectionObserver' in window && revealRoots.length > 0) {
    document.body.classList.add('js-reveal');

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-in');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });

    revealRoots.forEach(function (el) { observer.observe(el); });
  }

  // Everything below is spatial depth: parallax, card tilt, floor drift.
  // Purely ornamental — skipped for reduced motion, touch-only devices,
  // and coarse pointers.
  if (reduceMotion ||
      !window.matchMedia('(hover: hover)').matches ||
      !window.matchMedia('(pointer: fine)').matches) {
    return;
  }

  // Pointer spotlight + 3D tilt on project rows. The cursor drives the
  // accent glow (--mx/--my) and a subtle card tilt (--rx/--ry/--lift).
  var projectRows = document.querySelectorAll('.project');
  projectRows.forEach(function (el) {
    el.addEventListener('pointerenter', function () {
      el.style.setProperty('--lift', '1.02');
    });
    el.addEventListener('pointermove', function (event) {
      var rect = el.getBoundingClientRect();
      var px = event.clientX - rect.left;
      var py = event.clientY - rect.top;
      el.style.setProperty('--mx', px + 'px');
      el.style.setProperty('--my', py + 'px');
      el.style.setProperty('--rx', ((py / rect.height - 0.5) * -5).toFixed(3) + 'deg');
      el.style.setProperty('--ry', ((px / rect.width - 0.5) * 5).toFixed(3) + 'deg');
    });
    el.addEventListener('pointerleave', function () {
      el.style.setProperty('--rx', '0deg');
      el.style.setProperty('--ry', '0deg');
      el.style.setProperty('--lift', '1');
    });
  });

  // Gentler 3D tilt on focus cards and the portrait avatar (max ±3deg).
  ['.focus-item', '.img-slot--portrait'].forEach(function (selector) {
    document.querySelectorAll(selector).forEach(function (el) {
      el.addEventListener('pointermove', function (event) {
        var rect = el.getBoundingClientRect();
        var px = event.clientX - rect.left;
        var py = event.clientY - rect.top;
        el.style.setProperty('--rx', ((py / rect.height - 0.5) * -6).toFixed(3) + 'deg');
        el.style.setProperty('--ry', ((px / rect.width - 0.5) * 6).toFixed(3) + 'deg');
      });
      el.addEventListener('pointerleave', function () {
        el.style.setProperty('--rx', '0deg');
        el.style.setProperty('--ry', '0deg');
      });
    });
  });

  // Background parallax + floor drift. Cursor offset from the viewport
  // center and scroll progress are written to .bg as CSS vars, batched into
  // a single rAF frame (no layout thrash, passive listeners only).
  var bgEl = document.querySelector('.bg');
  if (bgEl) {
    var framePending = false;
    var hasCursor = false;
    var curX = 0;
    var curY = 0;
    var scrollDepth = 0;

    function applyBgVars() {
      framePending = false;
      if (hasCursor) {
        bgEl.style.setProperty('--parallax-x', (curX * 60).toFixed(2) + 'px');
        bgEl.style.setProperty('--parallax-y', (curY * 60).toFixed(2) + 'px');
      }
      bgEl.style.setProperty('--scroll-y', (scrollDepth * 40).toFixed(1) + 'px');
    }

    function scheduleBgFrame() {
      if (!framePending) {
        framePending = true;
        requestAnimationFrame(applyBgVars);
      }
    }

    window.addEventListener('pointermove', function (event) {
      curX = event.clientX / window.innerWidth - 0.5;
      curY = event.clientY / window.innerHeight - 0.5;
      hasCursor = true;
      scheduleBgFrame();
    }, { passive: true });

    var readScroll = function () {
      scrollDepth = Math.min(window.scrollY / window.innerHeight, 1);
      scheduleBgFrame();
    };
    window.addEventListener('scroll', readScroll, { passive: true });
    readScroll();
  }
})();
