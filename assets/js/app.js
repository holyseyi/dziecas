document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });
    }
});

function shareMovie(id) {
    if (navigator.share) {
        navigator.share({ title: 'Check out this movie', url: '/slider/' + id });
    } else {
        navigator.clipboard.writeText(window.location.href);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');
    if (!form) return;

    const errorBox = document.getElementById('login-error');
    const successBox = document.getElementById('login-success');
    const submitBtn = form.querySelector('button[type="submit"]');
    const label = form.querySelector('.login-label');
    const spinner = form.querySelector('.login-spinner');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        errorBox.classList.add('hidden');
        errorBox.textContent = '';
        submitBtn.disabled = true;
        if (label) label.textContent = 'Logging in...';
        if (spinner) spinner.classList.remove('hidden');

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: formData
            });

            let data = {};
            try { data = await response.json(); } catch (_) {}

            if (response.ok && data.success && data.redirect) {
                errorBox.classList.add('hidden');
                successBox.textContent = 'Login successful. Redirecting...';
                successBox.classList.remove('hidden');
                submitBtn.disabled = true;
                if (label) label.textContent = 'Success!';
                if (spinner) spinner.classList.add('hidden');
                setTimeout(function() {
                    window.location.href = data.redirect;
                }, 1000);
                return;
            }

            errorBox.textContent = data.error || 'Login failed. Please try again.';
            errorBox.classList.remove('hidden');
        } catch (err) {
            errorBox.textContent = 'Network error. Please try again.';
            errorBox.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            if (label) label.textContent = 'Login';
            if (spinner) spinner.classList.add('hidden');
        }
    });
});
