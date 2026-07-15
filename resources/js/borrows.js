(function() {
    let currentPage = 1;
    let currentData = [];
    let debounceTimer;

    document.addEventListener('DOMContentLoaded', () => {
        loadStats();
        loadData();

        // Event Listeners for Filters
        document.getElementById('search-input').addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                currentPage = 1;
                loadData();
            }, 300);
        });

        document.getElementById('filter-status').addEventListener('change', () => { currentPage = 1; loadData(); });
        document.getElementById('filter-due-date').addEventListener('change', () => { currentPage = 1; loadData(); });
        document.getElementById('sort-by').addEventListener('change', () => { currentPage = 1; loadData(); });
    });

    window.resetFilters = function() {
        document.getElementById('search-input').value = '';
        document.getElementById('filter-status').value = 'all';
        document.getElementById('filter-due-date').value = 'all';
        document.getElementById('sort-by').value = 'borrow_date_desc';
        currentPage = 1;
        loadData();
    };

    window.changePage = function(page) {
        currentPage = page;
        loadData();
    };

    window.openDetails = function(groupId) {
        window.openDetailModal('/admin/borrows/' + groupId, 'borrowsDetailModal');
    };

    window.payFines = async function(groupId, event = null) {
        if (event) event.stopPropagation();
        
        if (!confirm('Are you sure you want to mark all fines for this loan as paid?')) {
            return;
        }

        const item = currentData.find(d => d.group_id === groupId);
        if (!item || item.total_fine <= 0) return;

        showLoading(true);
        try {
            const response = await fetch(window.BorrowsConfig.routes.borrowsPay, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.BorrowsConfig.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ borrow_ids: item.borrow_ids })
            });

            const result = await response.json();
            if (result.success) {
                // Close modal if open
                const modal = document.getElementById('loan-details-modal');
                if (modal.hasAttribute('open')) {
                    modal.close();
                }
                showAlert(result.message || 'Fines marked as paid successfully!', 'success');
                loadStats();
                loadData();
            } else {
                showAlert('Error processing payment.', 'error');
            }
        } catch (error) {
            console.error('Error paying fine:', error);
            showAlert('An network error occurred.', 'error');
        } finally {
            showLoading(false);
        }
    };

    function showAlert(message, type = 'success') {
        const container = document.getElementById('borrows-alert-container');
        if (!container) return;
        const alertDiv = document.createElement('div');
        
        let colorClass, icon;
        if (type === 'success') {
            colorClass = 'bg-white border-l-4 border-green-500 text-gray-800';
            icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" class="text-green-500" />';
        } else if (type === 'warning') {
            colorClass = 'bg-white border-l-4 border-orange-500 text-gray-800';
            icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke="currentColor" class="text-orange-500" />';
        } else {
            colorClass = 'bg-white border-l-4 border-red-500 text-gray-800';
            icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" class="text-red-500" />';
        }

        alertDiv.className = `p-4 rounded-lg shadow-xl border-y border-r border-gray-100 text-sm font-medium flex items-center gap-3 transition-all duration-300 transform translate-x-full ${colorClass}`;
        alertDiv.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24">
                ${icon}
            </svg>
            <span>${message}</span>
        `;
        
        container.appendChild(alertDiv);
        
        setTimeout(() => { alertDiv.classList.remove('translate-x-full'); }, 10);
        
        setTimeout(() => {
            alertDiv.classList.add('opacity-0', 'translate-x-full');
            setTimeout(() => alertDiv.remove(), 300);
        }, 4000);
    }

    async function loadStats() {
        try {
            const response = await fetch(window.BorrowsConfig.routes.borrowsStats, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            
            document.getElementById('stat-active').textContent = data.active_loans;
            document.getElementById('stat-overdue').textContent = data.overdue_loans;
            document.getElementById('stat-returned').textContent = data.returned_today;
            document.getElementById('stat-fines').textContent = '₱' + parseFloat(data.outstanding_fines).toFixed(2);
        } catch (error) {
            console.error('Error fetching stats:', error);
        }
    }

    async function loadData() {
        showLoading(true);

        const search = document.getElementById('search-input').value;
        const status = document.getElementById('filter-status').value;
        const dueDate = document.getElementById('filter-due-date').value;
        const sortVal = document.getElementById('sort-by').value;
        
        let sort = 'borrow_date';
        let dir = 'desc';

        if (sortVal === 'borrow_date_asc') { dir = 'asc'; }
        if (sortVal === 'due_date_asc') { sort = 'due_date'; dir = 'asc'; }
        if (sortVal === 'due_date_desc') { sort = 'due_date'; dir = 'desc'; }
        if (sortVal === 'student_name_asc') { sort = 'student_name'; dir = 'asc'; }

        const url = new URL(window.BorrowsConfig.routes.borrowsList);
        url.searchParams.append('page', currentPage);
        if (search) url.searchParams.append('search', search);
        if (status !== 'all') url.searchParams.append('status', status);
        if (dueDate !== 'all') url.searchParams.append('due_date_filter', dueDate);
        url.searchParams.append('sort', sort);
        url.searchParams.append('dir', dir);

        try {
            const response = await fetch(url.toString(), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const result = await response.json();
            
            currentData = result.data;
            renderTable(result.data);
            renderMobile(result.data);
            renderPagination(result);
            
            const total = result.total;
            const emptyState = document.getElementById('empty-state');
            if (total === 0) {
                emptyState.classList.remove('hidden');
                emptyState.classList.add('flex');
            } else {
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');
            }

        } catch (error) {
            console.error('Error loading data:', error);
        } finally {
            showLoading(false);
        }
    }

    function showLoading(show) {
        const overlay = document.getElementById('loading-overlay');
        if (show) {
            overlay.classList.remove('hidden');
        } else {
            overlay.classList.add('hidden');
        }
    }

    function renderTable(data) {
        const tbody = document.getElementById('desktop-tbody');
        tbody.innerHTML = '';

        data.forEach(item => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-blue-50/30 transition-colors group cursor-pointer';
            tr.onclick = (e) => {
                if(!e.target.closest('button')) {
                    window.openDetails(item.group_id);
                }
            };

            const bookBadge = item.book_count > 1 
                ? `<span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold">+${item.book_count - 1} more</span>` 
                : '';

            let statusBadge = '';
            if (item.status === 'Active') statusBadge = '<span class="px-2.5 py-1 rounded-md bg-blue-100 text-blue-700 text-[11px] font-bold">Active</span>';
            else if (item.status === 'Overdue') statusBadge = '<span class="px-2.5 py-1 rounded-md bg-red-100 text-red-700 text-[11px] font-bold">Overdue</span>';
            else if (item.status === 'Returned') statusBadge = '<span class="px-2.5 py-1 rounded-md bg-green-100 text-green-700 text-[11px] font-bold">Returned</span>';

            let dueClass = 'text-gray-900';
            let dueSubtext = '';
            if (item.due_state === 'overdue') { dueClass = 'text-red-600'; dueSubtext = `<span class="text-xs text-red-500">${item.days_diff} days late</span>`; }
            else if (item.due_state === 'today') { dueClass = 'text-orange-600'; dueSubtext = `<span class="text-xs text-orange-500">Due today</span>`; }
            else if (item.status !== 'Returned') { dueSubtext = `<span class="text-xs text-gray-500">in ${item.days_diff} days</span>`; }

            const avatarHtml = item.member.avatar 
                ? `<img src="${item.member.avatar}" class="w-full h-full object-cover">`
                : item.member.initial;

            tr.innerHTML = `
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-600 font-bold overflow-hidden shrink-0">
                            ${avatarHtml}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 leading-tight">${item.member.name}</p>
                            <p class="text-xs text-gray-500">ID: ${item.member.student_id}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <p class="font-medium text-gray-900 truncate max-w-[200px]" title="${item.first_book.title}">${item.first_book.title}</p>
                        ${bookBadge}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-medium text-gray-900">${item.issue_date}</p>
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-bold ${dueClass}">${item.due_date}</p>
                    ${dueSubtext}
                </td>
                <td class="px-6 py-4">
                    ${statusBadge}
                </td>
                <td class="px-6 py-4">
                    ${item.total_fine > 0 
                        ? `<span class="font-bold text-red-600">₱${parseFloat(item.total_fine).toFixed(2)}</span>` 
                        : `<span class="text-gray-400">-</span>`}
                </td>
                <td class="px-6 py-4 text-right">
                    ${item.total_fine > 0 
                        ? `<button class="btn btn-sm bg-green-50 text-green-600 hover:bg-green-100 border-none mr-2" onclick="window.payFines('${item.group_id}', event)">Mark Paid</button>`
                        : ''}
                    <button class="btn btn-sm btn-ghost text-gray-500 hover:text-blue-600 hover:bg-blue-50" onclick="window.openDetails('${item.group_id}')">
                        View Details
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function renderMobile(data) {
        const container = document.getElementById('mobile-list');
        container.innerHTML = '';

        data.forEach(item => {
            let statusBadge = '';
            if (item.status === 'Active') statusBadge = '<span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold">Active</span>';
            else if (item.status === 'Overdue') statusBadge = '<span class="px-2 py-0.5 rounded-md bg-red-100 text-red-700 text-[10px] font-bold">Overdue</span>';
            else if (item.status === 'Returned') statusBadge = '<span class="px-2 py-0.5 rounded-md bg-green-100 text-green-700 text-[10px] font-bold">Returned</span>';

            const bookBadge = item.book_count > 1 
                ? `<span class="inline-flex px-1.5 py-0.5 rounded bg-blue-50 text-blue-600 text-[10px] font-bold border border-blue-100">+${item.book_count - 1} more</span>` 
                : '';

            const card = document.createElement('div');
            card.className = 'bg-white border border-gray-200 rounded-xl p-4 shadow-sm active:bg-gray-50 transition-colors';
            card.onclick = () => window.openDetails(item.group_id);

            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-600 overflow-hidden text-sm">
                            ${item.member.avatar ? `<img src="${item.member.avatar}" class="w-full h-full object-cover">` : item.member.initial}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm leading-tight">${item.member.name}</p>
                            <p class="text-[11px] text-gray-500">${item.member.student_id}</p>
                        </div>
                    </div>
                    ${statusBadge}
                </div>
                
                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 mb-3">
                    <p class="text-sm font-medium text-gray-900 leading-tight mb-1 truncate">${item.first_book.title}</p>
                    ${bookBadge}
                </div>

                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Due Date</p>
                        <p class="text-sm font-bold ${item.due_state === 'overdue' ? 'text-red-600' : 'text-gray-900'}">${item.due_date}</p>
                    </div>
                    ${item.total_fine > 0 ? `
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Fine</p>
                        <p class="text-sm font-bold text-red-600 mb-1">₱${parseFloat(item.total_fine).toFixed(2)}</p>
                        <button class="btn btn-xs bg-green-50 text-green-600 hover:bg-green-100 border-none" onclick="window.payFines('${item.group_id}', event)">Mark Paid</button>
                    </div>
                    ` : ''}
                </div>
            `;
            container.appendChild(card);
        });
    }

    function renderPagination(result) {
        const info = document.getElementById('pagination-info');
        const controls = document.getElementById('pagination-controls');
        
        if (result.total === 0) {
            info.innerHTML = `No entries found`;
            controls.innerHTML = '';
            return;
        }

        const start = ((result.current_page - 1) * 10) + 1;
        const end = Math.min(result.current_page * 10, result.total);
        info.innerHTML = `Showing <span class="font-bold text-gray-900">${start}</span> to <span class="font-bold text-gray-900">${end}</span> of <span class="font-bold text-gray-900">${result.total}</span> entries`;

        let html = '';
        html += `<button class="join-item btn btn-sm bg-white border-gray-200 hover:bg-gray-50 text-gray-600" ${result.current_page === 1 ? 'disabled' : ''} onclick="window.changePage(${result.current_page - 1})">Prev</button>`;
        
        // Simple page numbers
        for (let i = 1; i <= result.last_page; i++) {
            if (i === 1 || i === result.last_page || (i >= result.current_page - 1 && i <= result.current_page + 1)) {
                html += `<button class="join-item btn btn-sm ${i === result.current_page ? 'bg-blue-50 text-blue-600 border-blue-200 pointer-events-none font-bold' : 'bg-white border-gray-200 hover:bg-gray-50 text-gray-600'}" onclick="window.changePage(${i})">${i}</button>`;
            } else if (i === result.current_page - 2 || i === result.current_page + 2) {
                html += `<button class="join-item btn btn-sm bg-white border-gray-200 pointer-events-none text-gray-400">...</button>`;
            }
        }

        html += `<button class="join-item btn btn-sm bg-white border-gray-200 hover:bg-gray-50 text-gray-600" ${result.current_page === result.last_page ? 'disabled' : ''} onclick="window.changePage(${result.current_page + 1})">Next</button>`;
        
        controls.innerHTML = html;
    }
})();
