document.addEventListener('DOMContentLoaded', () => {
    const ajaxForms = document.querySelectorAll('form[data-ajax-form]');

    ajaxForms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // 1. Show the Preloader & Button Loading State
            const preloader = document.getElementById('site-preloader');
            if (preloader) {
                preloader.style.display = 'flex';
                preloader.style.opacity = '1';
                preloader.style.visibility = 'visible';
                preloader.style.pointerEvents = 'auto';
                preloader.classList.remove('is-finished');
                preloader.removeAttribute('aria-hidden');
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            let originalBtnHtml = '';
            if (submitBtn) {
                originalBtnHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                submitBtn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Please wait...`;
            }

            // 2. Clear existing errors
            const errorHolders = form.querySelectorAll('[data-error-for]');
            errorHolders.forEach(el => {
                el.textContent = '';
                el.classList.add('hidden'); // Hide the element if there is no error
            });

            // 3. Clear general alert
            const generalAlert = document.getElementById('ajax-general-error');
            if (generalAlert) {
                generalAlert.classList.add('hidden');
            }

            // Try to gather form data
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {
                // 4. Send request
                const response = await fetch(form.action, {
                    method: form.method || 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                });

                const contentType = response.headers.get('content-type');
                const isJson = contentType && contentType.includes('application/json');

                let result = {};
                let responseText = await response.text();

                if (isJson) {
                    try {
                        result = JSON.parse(responseText);
                    } catch (e) {
                        console.error('Failed to parse JSON. Server returned:', responseText.substring(0, 500));
                        throw e;
                    }
                } else if (!response.ok) {
                    console.error('Expected JSON but received HTML/text. Status:', response.status);
                    result = { message: 'Server returned an invalid response. Please try again.' };
                }

                if (response.ok) {
                    if (isJson && result.redirect) {
                        window.location.href = result.redirect;
                        // Preloader will stay visible while the browser navigates
                    } else if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        // Fallback reload just in case
                        window.location.reload();
                    }
                } else if (response.status === 422 && isJson) {
                    // Validation Errors
                    hidePreloader(preloader);
                    restoreButton();

                    const errors = result.errors || {};
                    let firstErrorField = null;

                    // Display general error alert if present
                    if (generalAlert) {
                        generalAlert.classList.remove('hidden');
                        const msgEl = generalAlert.querySelector('[data-alert-message]');
                        if (msgEl) {
                            // Find the first error message, or fallback
                            let firstMessage = 'Please review your information.';
                            if (Object.values(errors).length > 0) {
                                firstMessage = Object.values(errors)[0][0];
                            }
                            msgEl.textContent = firstMessage;
                        }
                    }

                    // Map specific field errors
                    for (const [field, messages] of Object.entries(errors)) {
                        const errorEl = form.querySelector(`[data-error-for="${field}"]`);
                        if (errorEl) {
                            errorEl.textContent = messages[0];
                            errorEl.classList.remove('hidden');
                        }

                        if (!firstErrorField) {
                            const inputEl = form.querySelector(`[name="${field}"]`);
                            if (inputEl) {
                                firstErrorField = inputEl;
                            }
                        }
                    }

                    // Focus on the first invalid field
                    if (firstErrorField) {
                        firstErrorField.focus();
                    }

                } else {
                    // Other server errors (500, etc)
                    hidePreloader(preloader);
                    restoreButton();
                    alert(result.message || 'An unexpected error occurred. Please try again.');
                }
            } catch (error) {
                hidePreloader(preloader);
                restoreButton();
                alert('A network error occurred. Please check your connection and try again.');
                console.error('AJAX Form Error:', error);
            }

            function restoreButton() {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML = originalBtnHtml;
                }
            }
        });
    });

    function hidePreloader(preloader) {
        if (preloader) {
            preloader.classList.add('is-finished');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    }
});
