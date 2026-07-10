// Shared admin JavaScript for the MovieHub admin panel.

// Global delete helper used by list/delete buttons across admin pages.
function deleteItem(url) {
    if (!confirm('Are you sure you want to delete this?')) {
        return;
    }
    const token = document.querySelector('input[name="csrf_token"]')?.value || '';
    fetch(url, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': token }
    }).then(() => location.reload());
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('home-content-form');
    if (!form) {
        return;
    }

    const typeSelect = document.getElementById('hc-type');
    const itemSelect = document.getElementById('hc-item');
    const movies = JSON.parse(document.getElementById('hc-movies-data').textContent || '[]');
    const series = JSON.parse(document.getElementById('hc-series-data').textContent || '[]');
    const media = JSON.parse(document.getElementById('hc-media-data').textContent || '[]');

    function populate() {
        let list;
        if (typeSelect.value === 'series') {
            list = series;
        } else if (typeSelect.value === 'media') {
            list = media;
        } else {
            list = movies;
        }
        itemSelect.innerHTML = '';
        list.forEach(function (item) {
            const opt = document.createElement('option');
            opt.value = item.id;
            opt.textContent = item.title;
            itemSelect.appendChild(opt);
        });
    }

    typeSelect.addEventListener('change', populate);
    populate();

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;

        const data = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: data
        })
        .then(function (r) { return r.json(); })
        .then(function (resp) {
            if (resp && resp.success) {
                location.reload();
                return;
            }
            alert((resp && resp.error) ? resp.error : 'Could not add content to the home page.');
            btn.disabled = false;
        })
        .catch(function () {
            alert('Could not add content to the home page.');
            btn.disabled = false;
        });
    });

    const mediaForm = document.getElementById('media-upload-form');
    if (mediaForm) {
        const mediaStatus = document.getElementById('media-upload-status');
        mediaForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const btn = mediaForm.querySelector('button[type="submit"]');
            btn.disabled = true;
            if (mediaStatus) {
                mediaStatus.classList.add('hidden');
                mediaStatus.textContent = '';
            }

            const data = new FormData(mediaForm);

            fetch(mediaForm.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: data
            })
            .then(function (r) { return r.json(); })
            .then(function (resp) {
                if (resp && resp.success) {
                    if (mediaStatus) {
                        mediaStatus.textContent = 'Uploaded successfully.';
                        mediaStatus.className = 'text-sm mt-3 text-green-600 dark:text-green-400';
                    }
                    setTimeout(function () { location.reload(); }, 700);
                    return;
                }
                throw new Error((resp && resp.error) ? resp.error : 'Upload failed.');
            })
            .catch(function (err) {
                if (mediaStatus) {
                    mediaStatus.textContent = err.message || 'Upload failed.';
                    mediaStatus.className = 'text-sm mt-3 text-red-600 dark:text-red-400';
                }
                btn.disabled = false;
            });
        });
    }
});
