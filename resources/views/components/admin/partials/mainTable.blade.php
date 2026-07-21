@props(['allBooks', 'categories' => [], 'publishers' => []])


<div>
    <x-admin.partials.tableSearch :categories="$categories" :publishers="$publishers" />
    
</div>


    @include('admin.books.partials.table', ['allBooks' => $allBooks])
