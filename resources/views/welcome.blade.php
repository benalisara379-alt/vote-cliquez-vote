<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Polaris Vote — Make Your Voice Count</title>
  <meta name="description" content="Polaris Vote is the official voting platform for the 2026 Polaris Awards. Cast your vote securely in seconds." />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Styles -->
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

  <!-- ============ HEADER / NAV ============ -->
  <header class="site-header" id="siteHeader">
    <div class="container header-inner">
      <a href="index.html" class="logo">
        <span class="logo-mark" aria-hidden="true">
          <svg viewBox="0 0 32 32" width="28" height="28">
            <circle cx="16" cy="16" r="14" fill="none" stroke="currentColor" stroke-width="2.5"/>
            <path d="M16 7 L18.2 13.8 L25.4 13.8 L19.6 18 L21.8 24.8 L16 20.6 L10.2 24.8 L12.4 18 L6.6 13.8 L13.8 13.8 Z" fill="currentColor"/>
          </svg>
        </span>
        Polaris<span class="logo-accent">Vote</span>
      </a>

      <nav class="main-nav" id="mainNav" aria-label="Primary">
        <a href="#about">About</a>
        <a href="#stats">Results</a>
        <a href="#features">Why Polaris</a>
        <a href="#faq">FAQ</a>
      </nav>

      <div class="header-actions">
        <a href="vote.html" class="btn btn-primary btn-pulse">Vote Now</a>
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation menu" aria-expanded="false">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </header>

  <main>
    <!-- ============ HERO ============ -->
    <section class="hero" id="about">
      <div class="hero-glow" aria-hidden="true"></div>
      <div class="container hero-grid">
        <div class="hero-copy">
          <p class="eyebrow">2026 Polaris Awards · Voting is open</p>
          <h1>Every vote steers <span class="text-gradient">the outcome.</span></h1>
          <p class="hero-sub">
            Polaris Vote is the official platform for this year's Polaris Awards. Verified, transparent,
            and built so your vote is counted the moment you cast it.
          </p>
          <div class="hero-cta-row">
           <a href="/vote" class="btn btn-primary btn-lg btn-pulse">
    Vote

              <svg class="btn-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <a href="#features" class="btn btn-ghost btn-lg">How it works</a>
          </div>
          <p class="hero-meta">Voting closes in <strong id="countdownText">--:--:--</strong> &middot; no account fees, ever.</p>
        </div>

        <!-- Signature element: live tally card -->
        <div class="hero-visual">
          <div class="tally-card glass-card">
            <div class="tally-card-head">
              <span class="live-dot" aria-hidden="true"></span>
              Live tally
            </div>
            <div class="tally-ring-wrap">
              <svg class="tally-ring" viewBox="0 0 160 160" width="160" height="160" aria-hidden="true">
                <circle class="tally-ring-track" cx="80" cy="80" r="68" />
                <circle class="tally-ring-progress" id="tallyRingProgress" cx="80" cy="80" r="68" />
              </svg>
              <div class="tally-ring-center">
                <span class="tally-count" id="tallyCount">0</span>
                <span class="tally-label">votes today</span>
              </div>
            </div>
            <ul class="tally-breakdown">
              <li><span class="dot dot-a"></span>Aria Chen <strong>42%</strong></li>
              <li><span class="dot dot-b"></span>Marcus Reed <strong>35%</strong></li>
              <li><span class="dot dot-c"></span>Lina Torres <strong>23%</strong></li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ STATS ============ -->
    <section class="stats" id="stats">
      <div class="container">
        <div class="stats-grid">
          <div class="stat-card glass-card">
            <span class="stat-number" data-count="128430">0</span>
            <span class="stat-label">Votes cast</span>
          </div>
          <div class="stat-card glass-card">
            <span class="stat-number" data-count="24">0</span>
            <span class="stat-label">Finalists</span>
          </div>
          <div class="stat-card glass-card">
            <span class="stat-number" data-count="61">0</span>
            <span class="stat-label">Countries voting</span>
          </div>
          <div class="stat-card glass-card">
            <span class="stat-number" data-count="99" data-suffix="%">0</span>
            <span class="stat-label">Votes verified instantly</span>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ FEATURES ============ -->
    <section class="features" id="features">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow">Why Polaris</p>
          <h2>Built so trust isn't optional.</h2>
          <p class="section-sub">A voting platform should be boring in the best way: fast, secure, and clear about
            what happens to your vote.</p>
        </div>

        <div class="features-grid">
          <article class="feature-card glass-card">
            <div class="feature-icon" aria-hidden="true">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M12 2l8 3.5v5c0 5.2-3.4 9.7-8 11-4.6-1.3-8-5.8-8-11v-5L12 2z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 12.5l2 2 4-4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <h3>One vote, verified</h3>
            <p>Each voter is matched to a single phone number, so results reflect real people, not bots or duplicate entries.</p>
          </article>

          <article class="feature-card glass-card">
            <div class="feature-icon" aria-hidden="true">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M4 19V10M11 19V5M18 19v-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </div>
            <h3>Results, live</h3>
            <p>Tallies update in real time, so you always see where the race stands &mdash; no waiting for a reveal.</p>
          </article>

          <article class="feature-card glass-card">
            <div class="feature-icon" aria-hidden="true">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><rect x="6" y="2.5" width="12" height="19" rx="2.4" stroke="currentColor" stroke-width="1.8"/><path d="M11 18.2h2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </div>
            <h3>Made for your phone</h3>
            <p>Vote from any device in under a minute. No app download, no desktop required.</p>
          </article>

          <article class="feature-card glass-card">
            <div class="feature-icon" aria-hidden="true">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M12 7v5l3.5 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <h3>Open audit log</h3>
            <p>Every vote is timestamped and reflected in a public count, so the process stays transparent end to end.</p>
          </article>
        </div>
      </div>
    </section>

    <!-- ============ FAQ ============ -->
    <section class="faq" id="faq">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow">Questions</p>
          <h2>Frequently asked questions</h2>
        </div>

        <div class="faq-list">
          <div class="faq-item glass-card">
            <button class="faq-question" aria-expanded="false">
              Who can vote in the Polaris Awards?
              <span class="faq-toggle" aria-hidden="true"></span>
            </button>
            <div class="faq-answer">
              <p>Anyone with a valid phone number can vote, once per number, per category. There's no entry fee and no purchase required.</p>
            </div>
          </div>

          <div class="faq-item glass-card">
            <button class="faq-question" aria-expanded="false">
              How many times can I vote?
              <span class="faq-toggle" aria-hidden="true"></span>
            </button>
            <div class="faq-answer">
              <p>One vote per phone number for the duration of the contest. This keeps the results an accurate reflection of individual support.</p>
            </div>
          </div>

          <div class="faq-item glass-card">
            <button class="faq-question" aria-expanded="false">
              Is my phone number kept private?
              <span class="faq-toggle" aria-hidden="true"></span>
            </button>
            <div class="faq-answer">
              <p>Yes. Your number is only used to verify your identity and is never shown publicly or shared with finalists.</p>
            </div>
          </div>

          <div class="faq-item glass-card">
            <button class="faq-question" aria-expanded="false">
              When do results get announced?
              <span class="faq-toggle" aria-hidden="true"></span>
            </button>
            <div class="faq-answer">
              <p>Live tallies are visible throughout voting. Final, certified results are announced immediately after the polls close.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ============ FINAL CTA ============ -->
    <section class="final-cta">
      <div class="container final-cta-inner glass-card">
        <h2>Ready to cast your vote?</h2>
        <p>It takes less than a minute, and your voice helps decide the winners.</p>
      <a href="/vote" class="btn btn-primary btn-lg btn-pulse">
      </div>
    </section>
  </main>

  <!-- ============ FOOTER ============ -->
  <footer class="site-footer">
    <div class="container footer-inner">
      <div class="footer-brand">
        <a href="index.html" class="logo">
          <span class="logo-mark" aria-hidden="true">
            <svg viewBox="0 0 32 32" width="24" height="24">
              <circle cx="16" cy="16" r="14" fill="none" stroke="currentColor" stroke-width="2.5"/>
              <path d="M16 7 L18.2 13.8 L25.4 13.8 L19.6 18 L21.8 24.8 L16 20.6 L10.2 24.8 L12.4 18 L6.6 13.8 L13.8 13.8 Z" fill="currentColor"/>
            </svg>
          </span>
          Polaris<span class="logo-accent">Vote</span>
        </a>
        <p>The official voting platform of the Polaris Awards.</p>
      </div>

      <div class="footer-links">
        <div class="footer-col">
          <h4>Site</h4>
          <a href="#about">About</a>
          <a href="#stats">Results</a>
          <a href="#features">Why Polaris</a>
          <a href="#faq">FAQ</a>
        </div>
        <div class="footer-col">
          <h4>Voting</h4>
          <a href="vote.html">Vote Now</a>
          <a href="vote.html">Create account</a>
        </div>
        <div class="footer-col">
          <h4>Legal</h4>
          <a href="#">Terms</a>
          <a href="#">Privacy</a>
        </div>
      </div>
    </div>
    <div class="container footer-bottom">
      <p>&copy; 2026 Polaris Vote. All rights reserved.</p>
    </div>
  </footer>

  <script src="js/script.js"></script>
</body>
</html>
