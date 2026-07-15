<div id="users-table-container">
    <!-- Table Wrapper -->
    <x-admin.table-wrapper>
        <x-admin.users.user-table :users="$users" />
    </x-admin.table-wrapper>
    
    <!-- Pagination -->
    <div class="ajax-pagination-wrapper">
        <x-admin.pagination :paginator="$users" />
    </div>
</div>
