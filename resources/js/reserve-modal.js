window.showGlobalToast = function (message, type = 'success', customTitle = null) {
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

    const t = (type || 'success').toLowerCase();
    
    const variant = {
        success: {
            border: 'border-emerald-100',
            iconBg: 'bg-emerald-100 text-emerald-600',
            progressBg: 'bg-emerald-500',
            title: customTitle || 'Saved list updated',
            iconHtml: '<svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>'
        },
        error: {
            border: 'border-red-100',
            iconBg: 'bg-red-100 text-red-600',
            progressBg: 'bg-red-500',
            title: customTitle || 'Reservation failed',
            iconHtml: '<svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>'
        },
        warning: {
            border: 'border-amber-100',
            iconBg: 'bg-amber-100 text-amber-600',
            progressBg: 'bg-amber-500',
            title: customTitle || 'Book due tomorrow',
            iconHtml: '<svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>'
        },
        info: {
            border: 'border-blue-100',
            iconBg: 'bg-blue-100 text-blue-600',
            progressBg: 'bg-blue-500',
            title: customTitle || 'Verification code sent',
            iconHtml: '<svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
        }
    }[t] || {
        border: 'border-emerald-100',
        iconBg: 'bg-emerald-100 text-emerald-600',
        progressBg: 'bg-emerald-500',
        title: customTitle || 'Saved list updated',
        iconHtml: '<svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>'
    };

    const toast = document.createElement('div');
    toast.className = `pointer-events-auto relative flex w-full translate-y-[-0.75rem] items-start gap-3.5 overflow-hidden rounded-2xl border ${variant.border} bg-white p-4 opacity-0 shadow-xl transition-all duration-300 font-sans`;
    toast.setAttribute('role', t === 'error' ? 'alert' : 'status');

    const icon = document.createElement('div');
    icon.className = `grid h-10 w-10 shrink-0 place-items-center rounded-full ${variant.iconBg} shadow-2xs`;
    icon.innerHTML = variant.iconHtml;

    const copy = document.createElement('div');
    copy.className = 'min-w-0 flex-1 pt-0.5';

    const title = document.createElement('p');
    title.className = 'text-sm font-extrabold text-slate-900 leading-tight';
    title.textContent = variant.title;

    const description = document.createElement('p');
    description.className = 'mt-0.5 text-xs sm:text-sm font-medium text-slate-500 leading-snug';
    description.textContent = message;

    const close = document.createElement('button');
    close.type = 'button';
    close.className = 'grid h-7 w-7 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700';
    close.setAttribute('aria-label', 'Dismiss notification');
    close.innerHTML = '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" /></svg>';

    const progress = document.createElement('div');
    progress.className = `absolute inset-x-0 bottom-0 h-1 origin-left ${variant.progressBg} rounded-b-2xl`;
    progress.style.transition = 'transform 4s linear';

    copy.append(title, description);
    toast.append(icon, copy, close, progress);
    container.appendChild(toast);

    const dismiss = () => {
        toast.classList.add('translate-x-4', 'opacity-0');
        window.setTimeout(() => toast.remove(), 300);
    };

    close.addEventListener('click', dismiss);

    window.requestAnimationFrame(() => {
        toast.classList.remove('translate-y-[-0.75rem]', 'opacity-0');
        progress.style.transform = 'scaleX(0)';
    });

    window.setTimeout(dismiss, 4000);
};

// --- AJAX Bookmark / Save Item Form Handler ---
document.addEventListener('submit', async function (e) {
    const form = e.target.closest('.ajax-save-form');
    if (!form) return;

    e.preventDefault();
    e.stopPropagation();

    const submitBtn = form.querySelector('button[type="submit"]');
    if (!submitBtn || submitBtn.dataset.loading === 'true') return;

    submitBtn.dataset.loading = 'true';
    submitBtn.disabled = true;

    const isCurrentlySaved = form.dataset.saved === 'true';
    const variant = form.dataset.saveVariant || 'button';
    const origHtml = submitBtn.innerHTML;

    // Set spinner loading state on button
    if (variant === 'icon') {
        submitBtn.innerHTML = `<svg class="animate-spin h-3.5 w-3.5 sm:h-4 sm:w-4 text-slate-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>`;
    } else {
        submitBtn.innerHTML = `<svg class="animate-spin h-4 w-4 text-current shrink-0 inline mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> <span>${isCurrentlySaved ? 'Removing...' : 'Saving...'}</span>`;
    }

    try {
        const formData = new FormData(form);
        const res = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (res.ok && data.success) {
            const nowSaved = data.saved;
            const bookId = form.dataset.bookId;
            const storeUrl = form.dataset.storeUrl || form.action;
            const destroyUrl = form.dataset.destroyUrl || form.action;

            // Sync all matching forms for this book ID on the page (cards, modals, etc.)
            document.querySelectorAll(`.ajax-save-form[data-book-id="${bookId}"]`).forEach(matchingForm => {
                matchingForm.dataset.saved = nowSaved ? 'true' : 'false';
                matchingForm.action = nowSaved ? destroyUrl : storeUrl;

                let methodInput = matchingForm.querySelector('input[name="_method"]');
                if (nowSaved) {
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        matchingForm.appendChild(methodInput);
                    }
                } else if (methodInput) {
                    methodInput.remove();
                }

                const btn = matchingForm.querySelector('button[type="submit"]');
                if (!btn) return;
                btn.disabled = false;
                delete btn.dataset.loading;

                const v = matchingForm.dataset.saveVariant || 'button';
                if (v === 'icon') {
                    if (nowSaved) {
                        btn.className = 'p-1.5 sm:p-2 rounded-xl border border-red-200 bg-red-50 text-red-600 transition hover:bg-red-100';
                        btn.title = 'Remove from saved';
                        btn.setAttribute('aria-label', 'Remove from saved');
                        btn.innerHTML = `<svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>`;
                    } else {
                        btn.className = 'p-1.5 sm:p-2 rounded-xl border border-slate-200 bg-white text-slate-500 hover:border-brand-navy hover:text-brand-navy transition-colors';
                        btn.title = 'Save to list';
                        btn.setAttribute('aria-label', 'Save to list');
                        btn.innerHTML = `<svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>`;
                    }
                } else {
                    if (nowSaved) {
                        btn.className = 'btn h-11 min-h-11 w-full rounded-xl border border-red-200 bg-white px-4 text-sm font-bold text-red-600 shadow-sm transition hover:bg-red-50 min-[420px]:w-auto';
                        btn.title = 'Remove from saved items';
                        btn.setAttribute('aria-pressed', 'true');
                        btn.innerHTML = `<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16l-7-3.5L5 21V5Z"/></svg> Saved`;
                    } else {
                        btn.className = 'btn h-11 min-h-11 w-full rounded-xl border border-brand-navy/20 bg-white px-4 text-sm font-bold text-brand-navy shadow-sm transition hover:bg-brand-navy/5 min-[420px]:w-auto';
                        btn.title = 'Save to your list';
                        btn.setAttribute('aria-pressed', 'false');
                        btn.innerHTML = `<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16l-7-3.5L5 21V5Z"/></svg> Save`;
                    }
                }
            });

            if (typeof window.showGlobalToast === 'function') {
                window.showGlobalToast(data.message || 'Saved list updated.', 'success', nowSaved ? 'Book Saved' : 'Book Removed');
            }
        } else {
            submitBtn.disabled = false;
            delete submitBtn.dataset.loading;
            submitBtn.innerHTML = origHtml;
            if (typeof window.showGlobalToast === 'function') {
                window.showGlobalToast(data.message || 'Failed to update saved list.', 'error');
            }
        }
    } catch (err) {
        console.error('AJAX save error:', err);
        submitBtn.disabled = false;
        delete submitBtn.dataset.loading;
        submitBtn.innerHTML = origHtml;
        if (typeof window.showGlobalToast === 'function') {
            window.showGlobalToast('An error occurred. Please try again.', 'error');
        }
    }
});
