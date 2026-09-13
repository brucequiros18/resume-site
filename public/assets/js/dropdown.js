/**
 * Navbar dropdown — vanilla JavaScript only.
 * Concepts demonstrated: querySelector, addEventListener, classList.toggle.
 * Bonuses: click-outside close, arrow indicator, keyboard support.
 */
(function () {
  "use strict";

  const btn  = document.querySelector("#dropdownBtn");
  const menu = document.querySelector("#dropdownMenu");

  if (!btn || !menu) return;

  // Toggle dropdown on button click
  btn.addEventListener("click", function (e) {
    e.stopPropagation();
    const open = menu.classList.toggle("active");
    btn.setAttribute("aria-expanded", String(open));
  });

  // Close when clicking outside
  document.addEventListener("click", function () {
    menu.classList.remove("active");
    btn.setAttribute("aria-expanded", "false");
  });

  // Keep dropdown open when clicking inside the menu
  menu.addEventListener("click", function (e) {
    e.stopPropagation();
  });

  // Close on Escape key
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && menu.classList.contains("active")) {
      menu.classList.remove("active");
      btn.setAttribute("aria-expanded", "false");
      btn.focus();
    }
  });

  // Close dropdown after a link is clicked (mobile convenience)
  menu.querySelectorAll("a").forEach(function (link) {
    link.addEventListener("click", function () {
      menu.classList.remove("active");
      btn.setAttribute("aria-expanded", "false");
    });
  });
})();
