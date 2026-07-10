// 1. Create a promise that finishes when the minimum time (2500ms) is up
const minimumTimePromise = new Promise((resolve) => {
    setTimeout(resolve, 1000);
});

// 2. Create a promise that finishes when the browser says all CSS/images are loaded
const windowLoadPromise = new Promise((resolve) => {
    window.addEventListener('load', resolve);
});

// 3. Wait for BOTH promises to finish before hiding the preloader
Promise.all([minimumTimePromise, windowLoadPromise]).then(() => {
    const preloader = document.getElementById('site-preloader');

    if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});