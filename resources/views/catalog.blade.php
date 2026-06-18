@extends('layouts.app')
@section('title', 'Catalog')
@section('content')
<form action="/books/add" method="POST">
    @csrf
    <div class="container">
        <div class="row mt-3">
            <div class="col-sm-3">
                <label for="bookid">BookID<i class="text-danger">*</i></label>
                <input type="text" class="form-control " name="bookid" required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-2">
                <label for="isbn">ISBN<i class="text-danger">*</i></label>
                <input type="text" class="form-control" name="isbn" required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-7">
                <label for="booktitle">Book Title<i class="text-danger">*</i></label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="col-sm-3">
                <label for="author">Author<i class="text-danger">*</i></label>
                <select class="form-control " name="author" id="author" required>
                    <option value="" selected disabled>-Select Author-</option>
                    <option value="1">1</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-3">
                <label for="datepublished">Date Published<i class="text-danger">*</i></label>
                <input type="date" class="form-control" name="datepublished">
            </div>
            <div class="col-sm-3">
                <label for="publisher">Publisher<i class="text-danger">*</i></label>
                 <select class="form-control " name="publisher" id="publisher" required>
                    <option value="" selected disabled>-Select Publisher-</option>
                    <option value="1">1</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="category">Category<i class="text-danger">*</i></label>
                 <select class="form-control " name="category" id="category" required>
                    <option value="" selected disabled>-Select Category-</option>
                    <option value="1">1</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="subcategory">Sub-Category<i class="text-danger">*</i></label>
                 <select class="form-control " name="subcategory" id="subcategory" required>
                    <option value="" selected disabled>-Select Sub-Category-</option>
                    <option value="1">1</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-2">
                <button class="form-control btn btn-primary rounded-pill"><i class="fa-solid fa-floppy-disk"></i> Add to Catalog</button>
            </div>
        </div>
    </div>
</form>
<div class="container">
    <hr>

    <h4>Book List</h4>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>BookID</th>
                <th>ISBN</th>
                <th>Title</th>
                <th>Date Published</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Category</th>
                <th>SubCategory</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book->BookID }}</td>
                <td>{{ $book->ISBN }}</td>
                <td>{{ $book->BookTitle }}</td>
                <td>{{ $book->DatePublished }}</td>
                <td>{{ $book->Author }}</td>
                <td>{{ $book->Publisher }}</td>
                <td>{{ $book->Category }}</td>
                <td>{{ $book->SubCategory }}</td>
                <td>{{ $book->Status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
@if(session('success'))
    <script>
        $(document).ready(function(){
            Swal.fire({
                icon: 'success',
                title: 'Add Book',
                text: "{{ session('success') }}",
                showConfirmButton: true
            });
        });
    </script>
    @endif
@endsection