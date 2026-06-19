@extends('layouts.app')
@section('title', 'Book List')
@section('content')
<div class="container">
    <h4>Book List</h4>

    <table class="table table-sm mt-3">
        <thead class="bg-blue text-white">
            <tr class="small">
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Category</th>
                <th>SubCategory</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($books as $book)
            <tr class="small">
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>
                    <div class="fw-bold">{{ $book->BookTitle }}</div>
                    <div class="small mt-n5">Book ID: {{ $book->BookID }}</div>
                    <div class="small mt-n5 fst-italic">ISBN: {{ $book->ISBN }}</div>
                </td>
                <td>{{ $book->Author }}</td>
                <td>
                    <div class="fw-bold">{{ $book->Publisher }}</div>    
                    <div class="small mt-n5">{{ $book->DatePublished->format('M d, Y') }}</div>    
                </td>
                <td>{{ $book->Category }}</td>
                <td>{{ $book->SubCategory }}</td>
                <td>{{ $book->Status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
