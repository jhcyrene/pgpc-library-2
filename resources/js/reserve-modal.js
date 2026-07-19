window.showGlobalToast = function (message, type = 'success') {
    // A native dialog is rendered in the browser's top layer. Mount the toast
    // inside it when open so feedback remains visible above the modal backdrop.
    const toastHost = document.querySelector('dialog[open]') || document.body;
    let container = document.getElementById('global-toast-container');

    if (!container) {
        container = document.createElement('div');
        container.id = 'global-toast-container';
        container.className = 'pointer-events-none fixed inset-x-4 top-4 z-[10000] flex flex-col items-center gap-3 sm:inset-x-auto sm:right-5 sm:top-5 sm:w-full sm:max-w-sm';
        container.setAttribute('aria-live', 'polite');
        container.setAttribute('aria-atomic', 'true');
        toastHost.appendChild(container);
    } else if (container.parentElement !== toastHost) {
        toastHost.appendChild(container);
    }

    const isSuccess = type === 'success';
    const toast = document.createElement('div');
    toast.className = `pointer-events-auto relative flex w-full translate-y-[-0.75rem] items-start gap-3 overflow-hidden rounded-2xl border bg-white p-4 opacity-0 shadow-2xl transition-all duration-300 ${isSuccess ? 'border-emerald-200' : 'border-red-200'}`;
    toast.setAttribute('role', isSuccess ? 'status' : 'alert');

    const icon = document.createElement('div');
    icon.className = `grid h-10 w-10 shrink-0 place-items-center rounded-xl ${isSuccess ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'}`;
    icon.innerHTML = isSuccess
        ? '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6" /></svg>'
        : '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>';

    const copy = document.createElement('div');
    copy.className = 'min-w-0 flex-1 pt-0.5';

    const title = document.createElement('p');
    title.className = `text-sm font-extrabold ${isSuccess ? 'text-emerald-800' : 'text-red-800'}`;
    title.textContent = isSuccess ? 'Saved list updated' : 'Action unsuccessful';

    const description = document.createElement('p');
    description.className = 'mt-0.5 text-sm leading-5 text-slate-600';
    description.textContent = message;

    const close = document.createElement('button');
    close.type = 'button';
    close.className = 'grid h-8 w-8 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700';
    close.setAttribute('aria-label', 'Dismiss notification');
    close.innerHTML = '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" /></svg>';

    const progress = document.createElement('div');
    progress.className = `absolute inset-x-0 bottom-0 h-1 origin-left ${isSuccess ? 'bg-emerald-500' : 'bg-red-500'}`;
    progress.style.transition = 'transform 4s linear';

    copy.append(title, description);
    toast.append(icon, copy, close, progress);
    container.appendChild(toast);

    const dismiss = () => {
        toast.classList.add('translate-x-4', 'opacity-0');
        window.setTimeout(() => toast.remove(), 300);
    };

    close.addEventListener('click', dismiss);

    requestAnimationFrame(() => {
        toast.classList.remove('translate-y-[-0.75rem]', 'opacity-0');
        requestAnimationFrame(() => {
            progress.style.transform = 'scaleX(0)';
        });
    });

    window.setTimeout(dismiss, 4000);
};

function updateSavedForm(form, isSaved) {
    const button = form.querySelector('button[type="submit"]');
    if (!button) return;

    form.dataset.saved = isSaved ? 'true' : 'false';
    button.disabled = false;
    button.setAttribute('aria-pressed', isSaved ? 'true' : 'false');

    let methodInput = form.querySelector('input[name="_method"]');
    if (isSaved && !methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
    } else if (!isSaved && methodInput) {
        methodInput.remove();
    }

    const variant = form.dataset.saveVariant;
    const stateClasses = [
        'border-red-200', 'border-brand-navy/20', 'border-slate-200',
        'bg-white', 'bg-red-50',
        'text-red-600', 'text-brand-navy', 'text-slate-500',
        'hover:bg-red-50', 'hover:bg-red-100', 'hover:bg-brand-navy/5', 'hover:bg-slate-50',
        'hover:border-primary', 'hover:text-primary'
    ];

    button.classList.remove(...stateClasses);

    if (isSaved) {
        button.classList.add('border-red-200', 'text-red-600');
        button.classList.add(...(variant === 'icon' ? ['bg-red-50', 'hover:bg-red-100'] : ['bg-white', 'hover:bg-red-50']));
        button.title = 'Remove from saved';
        button.setAttribute('aria-label', 'Remove from saved');
        button.innerHTML = `<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16l-7-3.5L5 21V5Z"/></svg>${variant === 'button' ? '<span>Saved</span>' : ''}`;
    } else {
        button.classList.add('bg-white');
        button.classList.add(...(variant === 'icon'
            ? ['border-slate-200', 'text-slate-500', 'hover:bg-slate-50', 'hover:border-primary', 'hover:text-primary']
            : ['border-brand-navy/20', 'text-brand-navy', 'hover:bg-brand-navy/5']));
        button.title = 'Save to your list';
        button.setAttribute('aria-label', 'Save to your list');
        button.innerHTML = `<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16l-7-3.5L5 21V5Z"/></svg>${variant === 'button' ? '<span>Save</span>' : ''}`;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Save and remove saved titles without leaving the OPAC page.
    document.body.addEventListener('submit', async function (e) {
        const form = e.target.closest('.ajax-save-form');
        if (!form) return;

        e.preventDefault();
        e.stopPropagation();

        const button = form.querySelector('button[type="submit"]');
        if (!button || button.disabled) return;

        const originalContent = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<span class="loading loading-spinner loading-sm" aria-hidden="true"></span><span class="sr-only">Updating saved list</span>';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json().catch(() => ({}));

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Your saved list could not be updated.');
            }

            document.querySelectorAll('.ajax-save-form').forEach(candidate => {
                if (candidate.dataset.bookId === form.dataset.bookId) {
                    updateSavedForm(candidate, Boolean(result.saved));
                }
            });

            window.showGlobalToast(result.message || 'Your saved list was updated.', 'success');
        } catch (error) {
            button.innerHTML = originalContent;
            button.disabled = false;
            window.showGlobalToast(error.message || 'Your saved list could not be updated.', 'error');
        }
    });

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
