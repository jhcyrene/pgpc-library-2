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
