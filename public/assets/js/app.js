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
