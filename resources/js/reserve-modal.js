document.addEventListener('DOMContentLoaded', function () {
    // ── AJAX Reserve Modal Handler (existing behavior) ──
    document.body.addEventListener('click', async function (e) {
        const reserveBtn = e.target.closest('.ajax-reserve-btn');
        if (!reserveBtn) return;

        e.preventDefault();
        const originalText = reserveBtn.innerHTML;
        reserveBtn.classList.add('opacity-75', 'cursor-not-allowed');

        try {
            const response = await fetch(reserveBtn.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success && data.html) {
                const container = document.getElementById('modal-container');
                container.innerHTML = data.html;

                const modal = container.querySelector('dialog');
                if (modal) {
                    modal.showModal();

                    const scripts = container.getElementsByTagName('script');
                    for (let i = 0; i < scripts.length; i++) {
                        const newScript = document.createElement('script');
                        if (scripts[i].src) {
                            newScript.src = scripts[i].src;
                            if (scripts[i].src.includes('flatpickr')) {
                                if (window.flatpickr) continue;
                                await new Promise(resolve => {
                                    newScript.onload = resolve;
                                    newScript.onerror = resolve;
                                    document.body.appendChild(newScript);
                                });
                                continue;
                            }
                        } else {
                            newScript.textContent = scripts[i].textContent;
                        }
                        document.body.appendChild(newScript);
                    }
                }
            } else {
                alert('Could not load details.');
            }
        } catch (err) {
            console.error(err);
            alert('Network error while loading modal.');
        } finally {
            reserveBtn.innerHTML = originalText;
            reserveBtn.classList.remove('opacity-75', 'cursor-not-allowed');
        }
    });

    // ── AJAX Book Detail Modal Handler (new) ──
    document.body.addEventListener('click', async function (e) {
        const card = e.target.closest('[data-book-url]');
        if (!card) return;

        // Don't open modal if a button, link, or form inside the card was clicked
        if (e.target.closest('a, button, form')) return;

        e.preventDefault();

        const modal = document.getElementById('opac-book-detail-modal');
        const skeleton = document.getElementById('opac-modal-skeleton');
        const content = document.getElementById('opac-modal-content');

        if (!modal) return;

        // Show skeleton, hide content, open modal
        skeleton.classList.remove('hidden');
        content.classList.add('hidden');
        content.innerHTML = '';
        modal.showModal();

        try {
            const response = await fetch(card.dataset.bookUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success && data.html) {
                content.innerHTML = data.html;
                skeleton.classList.add('hidden');
                content.classList.remove('hidden');
            } else {
                modal.close();
                alert('Could not load book details.');
            }
        } catch (err) {
            console.error(err);
            modal.close();
            alert('Network error while loading book details.');
        }
    });
});
