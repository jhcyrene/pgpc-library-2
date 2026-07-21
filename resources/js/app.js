import '../css/welcome.css';
import './reserve-modal.js';

import.meta.glob([
    '../images/**',
]);

window.openDetailModal = async function(url, modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) {
        console.error('Modal not found:', modalId);
        return;
    }
    
    const contentContainer = document.getElementById(modalId + 'Content');
    if (!contentContainer) {
        console.error('Content container not found for modal:', modalId);
        return;
    }

    // Inject skeleton loader matching the Member Profile layout
    contentContainer.innerHTML = `
        <div class="animate-pulse">
            <!-- Header Skeleton -->
            <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4 mb-6">
                <div>
                    <div class="h-8 bg-gray-200 rounded w-48 mb-2"></div>
                    <div class="h-4 bg-gray-200 rounded w-32"></div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-8 bg-gray-200 rounded w-24"></div>
                    <div class="h-8 bg-gray-200 rounded w-20 mr-10"></div>
                </div>
            </div>
            
            <!-- Grid Skeleton -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between">
                            <div class="h-6 bg-gray-200 rounded w-32"></div>
                            <div class="h-6 bg-gray-200 rounded w-20"></div>
                        </div>
                        <div class="p-6 flex flex-col sm:flex-row gap-6 items-start">
                            <div class="w-24 h-24 bg-gray-200 rounded-full shrink-0"></div>
                            <div class="flex-1 space-y-4 w-full">
                                <div class="h-5 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-5 bg-gray-200 rounded w-1/2"></div>
                                <div class="h-5 bg-gray-200 rounded w-5/6"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                        <div class="h-6 bg-gray-200 rounded w-24"></div>
                        <div class="h-20 bg-gray-200 rounded w-full"></div>
                        <div class="h-10 bg-gray-200 rounded w-full"></div>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Make sure the modal content fades in nicely when data loads
    contentContainer.style.opacity = '1';
    modal.showModal();

    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        });

        if (!response.ok) throw new Error('Network response was not ok');
        const html = await response.text();

        // Fade out slightly
        contentContainer.style.opacity = '0.5';
        
        setTimeout(() => {
            contentContainer.innerHTML = html;
            contentContainer.style.opacity = '1';
        }, 150);

    } catch (error) {
        console.error('Error loading details:', error);
        contentContainer.innerHTML = `
            <div class="flex flex-col items-center justify-center p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Failed to load details</h3>
                <p class="text-gray-500 mb-4">There was a problem fetching the data.</p>
                <button type="button" class="btn btn-sm btn-outline" onclick="window.openDetailModal('${url}', '${modalId}')">Try Again</button>
            </div>
        `;
        contentContainer.style.opacity = '1';
    }
};
