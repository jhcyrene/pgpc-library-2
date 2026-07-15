document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', async function (e) {
        // Find the closest matching anchor or button
        const btn = e.target.closest('.ajax-reserve-btn, .ajax-book-details-btn');
        if (!btn) return;

        e.preventDefault();

        const originalText = btn.innerHTML;

        btn.classList.add('opacity-75', 'cursor-not-allowed');

        try {
            const response = await fetch(btn.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success && data.html) {
                const container = document.getElementById('modal-container');
                container.innerHTML = data.html;

                // Find the new modal (either reservation-modal or book-details-modal)
                const modal = container.querySelector('dialog');
                if (modal) {
                    modal.showModal();

                    // Execute scripts in the injected HTML (Flatpickr needs this to render)
                    const scripts = container.getElementsByTagName('script');
                    for (let i = 0; i < scripts.length; i++) {
                        const newScript = document.createElement('script');
                        if (scripts[i].src) {
                            newScript.src = scripts[i].src;
                            // Need to wait for Flatpickr to load before executing the inline script
                            if (scripts[i].src.includes('flatpickr')) {
                                if (window.flatpickr) continue; // Skip if already loaded
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
            btn.innerHTML = originalText;
            btn.classList.remove('opacity-75', 'cursor-not-allowed');
        }
    });
});
