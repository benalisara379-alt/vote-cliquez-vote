/* =========================================================
   POLARIS VOTE — SCRIPT.JS
   Vanilla JS, no dependencies. Organized into small modules
   that each check for the DOM elements they need before
   running, so this single file can safely be shared by
   index.html, vote.html, and success.html.
   ========================================================= */

(function () {
  "use strict";

  /* ---------------------------------------------------------
     Module: Mobile navigation toggle
  --------------------------------------------------------- */
  function initMobileNav() {
    const toggle = document.getElementById("navToggle");
    const nav = document.getElementById("mainNav");
    if (!toggle || !nav) return;

    toggle.addEventListener("click", () => {
      const isOpen = nav.classList.toggle("is-open");
      toggle.classList.toggle("is-active", isOpen);
      toggle.setAttribute("aria-expanded", String(isOpen));
    });

    // Close the menu after a nav link is tapped
    nav.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        nav.classList.remove("is-open");
        toggle.classList.remove("is-active");
        toggle.setAttribute("aria-expanded", "false");
      });
    });
  }

  /* ---------------------------------------------------------
     Module: Animated stat counters
     Counts each [data-count] number up from 0 once it
     scrolls into view.
  --------------------------------------------------------- */
  function initStatCounters() {
    const counters = document.querySelectorAll(".stat-number[data-count]");
    if (!counters.length) return;

    const animateCounter = (el) => {
      const target = parseInt(el.dataset.count, 10) || 0;
      const suffix = el.dataset.suffix || "";
      const duration = 1400;
      const start = performance.now();

      function tick(now) {
        const progress = Math.min((now - start) / duration, 1);
        // Ease-out for a natural "settling" feel
        const eased = 1 - Math.pow(1 - progress, 3);
        const value = Math.round(target * eased);
        el.textContent = value.toLocaleString() + suffix;
        if (progress < 1) requestAnimationFrame(tick);
      }
      requestAnimationFrame(tick);
    };

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.4 }
    );

    counters.forEach((counter) => observer.observe(counter));
  }

  /* ---------------------------------------------------------
     Module: Live tally ring (hero signature element)
     Fills the SVG ring and ticks the vote count up, purely
     as a presentational preview of "live" results.
  --------------------------------------------------------- */
  function initTallyRing() {
    const ring = document.getElementById("tallyRingProgress");
    const countEl = document.getElementById("tallyCount");
    if (!ring || !countEl) return;

    const circumference = 2 * Math.PI * 68; // r = 68
    const percent = 0.62; // demo fill amount

    requestAnimationFrame(() => {
      ring.style.strokeDashoffset = String(circumference * (1 - percent));
    });

    // Tick the count up to a demo number
    const target = 3482;
    const duration = 1600;
    const start = performance.now();

    function tick(now) {
      const progress = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      countEl.textContent = Math.round(target * eased).toLocaleString();
      if (progress < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }

  /* ---------------------------------------------------------
     Module: Countdown timer (hero meta line)
     Counts down to a fixed demo deadline.
  --------------------------------------------------------- */
  function initCountdown() {
    const el = document.getElementById("countdownText");
    if (!el) return;

    // Demo deadline: 3 days from page load
    const deadline = Date.now() + 1000 * 60 * 60 * 72;

    function update() {
      const diff = Math.max(deadline - Date.now(), 0);
      const hours = Math.floor(diff / (1000 * 60 * 60));
      const minutes = Math.floor((diff / (1000 * 60)) % 60);
      const seconds = Math.floor((diff / 1000) % 60);
      el.textContent = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
    }

    function pad(num) {
      return String(num).padStart(2, "0");
    }

    update();
    setInterval(update, 1000);
  }

  /* ---------------------------------------------------------
     Module: FAQ accordion
  --------------------------------------------------------- */
  function initFaqAccordion() {
    const items = document.querySelectorAll(".faq-item");
    if (!items.length) return;

    items.forEach((item) => {
      const question = item.querySelector(".faq-question");
      if (!question) return;

      question.addEventListener("click", () => {
        const isOpen = item.classList.contains("is-open");

        // Close every other item (single-open accordion)
        items.forEach((other) => {
          other.classList.remove("is-open");
          const btn = other.querySelector(".faq-question");
          if (btn) btn.setAttribute("aria-expanded", "false");
        });

        if (!isOpen) {
          item.classList.add("is-open");
          question.setAttribute("aria-expanded", "true");
        }
      });
    });
  }

  /* ---------------------------------------------------------
     Module: Scroll reveal
     Adds a gentle fade/slide-in to key sections as they
     enter the viewport.
  --------------------------------------------------------- */
  function initScrollReveal() {
    const targets = document.querySelectorAll(
      ".stat-card, .feature-card, .faq-item, .final-cta-inner"
    );
    if (!targets.length) return;

    targets.forEach((el) => el.classList.add("reveal"));

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15 }
    );

    targets.forEach((el) => observer.observe(el));
  }

  /* ---------------------------------------------------------
     Module: Header shadow on scroll
  --------------------------------------------------------- */
  function initHeaderShadow() {
    const header = document.getElementById("siteHeader");
    if (!header) return;

    function update() {
      header.style.boxShadow =
        window.scrollY > 8 ? "0 8px 24px rgba(15, 27, 61, 0.06)" : "none";
    }

    update();
    window.addEventListener("scroll", update, { passive: true });
  }

  /* ---------------------------------------------------------
     Module: Password visibility toggle (vote.html)
  --------------------------------------------------------- */
  function initPasswordToggle() {
    const toggleBtn = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    if (!toggleBtn || !passwordInput) return;

    toggleBtn.addEventListener("click", () => {
      const isHidden = passwordInput.type === "password";
      passwordInput.type = isHidden ? "text" : "password";
      toggleBtn.setAttribute("aria-pressed", String(isHidden));
      toggleBtn.setAttribute(
        "aria-label",
        isHidden ? "Hide password" : "Show password"
      );
    });
  }

  /* ---------------------------------------------------------
     Module: Vote form validation + submit (vote.html)
  --------------------------------------------------------- */
  function initVoteForm() {
    const form = document.getElementById("voteForm");
    if (!form) return;

    const phoneInput = document.getElementById("phone");
    const passwordInput = document.getElementById("password");
    const phoneError = document.getElementById("phoneError");
    const passwordError = document.getElementById("passwordError");
    const formError = document.getElementById("formError");
    const submitBtn = document.getElementById("submitBtn");

    // Accepts numbers, spaces, dashes, parens, and an optional
    // leading "+", with 7-15 digits total — a practical,
    // forgiving phone validation for a global voter base.
    const PHONE_PATTERN = /^\+?[0-9\s\-().]{7,20}$/;

    function digitCount(value) {
      return (value.match(/\d/g) || []).length;
    }

    function setFieldError(input, errorEl, message) {
      const field = input.closest(".field");
      if (field) field.classList.toggle("has-error", Boolean(message));
      errorEl.textContent = message || "";
    }

    function validatePhone() {
      const value = phoneInput.value.trim();
      if (!value) {
        setFieldError(phoneInput, phoneError, "Enter your phone number.");
        return false;
      }
      if (!PHONE_PATTERN.test(value) || digitCount(value) < 7) {
        setFieldError(
          phoneInput,
          phoneError,
          "Enter a valid phone number (at least 7 digits)."
        );
        return false;
      }
      setFieldError(phoneInput, phoneError, "");
      return true;
    }

    function validatePassword() {
      const value = passwordInput.value;
      if (!value) {
        setFieldError(passwordInput, passwordError, "Enter your password.");
        return false;
      }
      if (value.length < 8) {
        setFieldError(
          passwordInput,
          passwordError,
          "Password must be at least 8 characters."
        );
        return false;
      }
      setFieldError(passwordInput, passwordError, "");
      return true;
    }

    // Validate as the voter types/leaves a field, for fast feedback
    phoneInput.addEventListener("blur", validatePhone);
    passwordInput.addEventListener("blur", validatePassword);
    phoneInput.addEventListener("input", () => {
      if (phoneInput.closest(".field").classList.contains("has-error")) {
        validatePhone();
      }
    });
    passwordInput.addEventListener("input", () => {
      if (passwordInput.closest(".field").classList.contains("has-error")) {
        validatePassword();
      }
    });

    form.addEventListener("submit", (event) => {
      event.preventDefault();
      formError.textContent = "";

      const isPhoneValid = validatePhone();
      const isPasswordValid = validatePassword();

      if (!isPhoneValid || !isPasswordValid) {
        formError.textContent = "Please fix the highlighted fields to continue.";
        return;
      }

      // Show loading state on the submit button
      submitBtn.classList.add("is-loading");
      submitBtn.disabled = true;

      // Simulate a network/auth call, then redirect on success.
      // Replace this timeout with a real API call when one exists.
     setTimeout(() => {
    window.location.href = "/verify";
}, 1400);
    });
  }

  /* ---------------------------------------------------------
     Module: Forgot password / Create account placeholders
     These keep the UI fully interactive even though there is
     no backend wired up yet.
  --------------------------------------------------------- */
  function initAuxButtons() {
    const forgotLink = document.getElementById("forgotLink");
    if (forgotLink) {
      forgotLink.addEventListener("click", (event) => {
        event.preventDefault();
        window.alert(
          "Password recovery isn't connected yet. This is where we'd send a reset link to your phone number."
        );
      });
    }

    const createAccountBtn = document.getElementById("createAccountBtn");
    if (createAccountBtn) {
      createAccountBtn.addEventListener("click", () => {
        window.alert(
          "Account creation isn't connected yet. This is where new voters would register."
        );
      });
    }
  }

  /* ---------------------------------------------------------
     Module: Success page entrance
     The checkmark draws itself via CSS animation; this just
     makes sure focus lands somewhere sensible for screen
     reader users.
  --------------------------------------------------------- */
  function initSuccessPage() {
    const heading = document.querySelector(".success-card h1");
    if (!heading) return;
    heading.setAttribute("tabindex", "-1");
    heading.focus({ preventScroll: true });
  }

  /* ---------------------------------------------------------
     Boot
  --------------------------------------------------------- */
  document.addEventListener("DOMContentLoaded", () => {
    initMobileNav();
    initStatCounters();
    initTallyRing();
    initCountdown();
    initFaqAccordion();
    initScrollReveal();
    initHeaderShadow();
    initPasswordToggle();
    initVoteForm();
    initAuxButtons();
    initSuccessPage();
  });
})();
