@push('scripts')
<script>
    window.BorrowsConfig = {
        routes: {
            circulationIndex: '{{ route("admin.circulation.index") }}',
            borrowsPay: '{{ route("admin.api.borrows.pay") }}',
            borrowsStats: '{{ route("admin.api.borrows.stats") }}',
            borrowsList: '{{ route("admin.api.borrows.list") }}'
        },
        csrfToken: '{{ csrf_token() }}'
    };
</script>
@vite('resources/js/borrows.js')
@endpush
