@extends('layouts.app')
@section('title', 'Catalog')
@section('content')
<form action="/books/add" method="POST">
    @csrf
    <div class="container">
        <div class="row mt-3 justify-content-center">
            <div class="col-md-10">
                <div class="col-md-12">
                    <h5>Add Book to Catalog</h5>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-3">
                        <label for="bookid">BookID<i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm" name="bookid" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-4">
                        <label for="isbn">ISBN<i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm" name="isbn" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-7">
                        <label for="booktitle">Book Title<i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm" name="title" required>
                    </div>
                    <div class="col-sm-3">
                        <label for="author">Author<i class="text-danger">*</i></label>
                        <select class="form-control form-control-sm" name="author" id="author" required>
                            <option value="" selected disabled>-Select Author-</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-3">
                        <label for="datepublished">Date Published<i class="text-danger">*</i></label>
                        <input type="date" class="form-control form-control-sm" name="datepublished">
                    </div>
                    <div class="col-sm-3">
                        <label for="publisher">Publisher<i class="text-danger">*</i></label>
                        <select class="form-control form-control-sm" name="publisher" id="publisher" required>
                            <option value="" selected disabled>-Select Publisher-</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-5">
                        <label for="category">Category<i class="text-danger">*</i></label>
                        <select class="form-control form-control-sm" name="category" id="category" required>
                            <option value="" selected disabled>-Select Category-</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <label for="subcategory">Sub-Category<i class="text-danger">*</i></label>
                        <select class="form-control form-control-sm" name="subcategory" id="subcategory" required>
                            <option value="" selected disabled>-Select Sub-Category-</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-3">
                        <button class="form-control btn btn-blue rounded-pill"><i class="fa-solid fa-floppy-disk"></i> Add to Catalog</button>
                    </div>
                </div>
         </div>
        </div>
    </div>
</form>
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