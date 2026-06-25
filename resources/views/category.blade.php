@extends('layouts.app')
@section('title', 'Category')
@section('content')
<form action="/category/add" method="POST">
    @csrf
    <div class="container">
        <div class="row">
            <h5>Category</h5>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-9">
                        <label for="category">Category<i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm" id="category" name="category" placeholder="Enter Book Category..." required>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-blue btn-sm mt-4 form-control">Add</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mt-4">
                <table class="table table-sm table-hover">
                    <thead class="bg-blue text-white">
                        <tr class="small">
                            <th>#</th>
                            <th>Category</th>
                            <th class="text-end pe-2"><i class="fa-solid fa-bars"></i></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categories as $category)
                        <tr class="small">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="categoryrow cursor-pointer" value="{{ $category->id }}">{{ $category->CategoryName }}</td>
                            <td class="text-end"><button type="button" class="btn btn-sm text-blue shadow-none cat" value="{{ $category->id }}" data-bs-toggle="modal" data-bs-target="#category-modal"><i class="fa-solid fa-circle-plus"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-sm-4 mt-4">
                <table class="table table-sm">
                    <thead class="bg-blue text-white">
                        <tr class="small">
                            <th>#</th>
                            <th>SubCategory</th>
                        </tr>
                    </thead>
                    <tbody id="subcategory-table">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<form action="/category/sub" method="post">
    @csrf
    <div class="modal" id="category-modal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-blue text-white">
                <h4 class="modal-title">Add Sub-Category</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 id="cat">-Category-</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control form-control-sm" id="catid" name="category_id">
                            <div class="form-group">
                                <label for="subCategoryName">Sub-Category Name</label>
                                <input type="text" class="form-control" id="subCategoryName" name="subcategory" placeholder="Enter sub-category name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-blue">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
                title: 'Add Category',
                text: "{{ session('success') }}",
                showConfirmButton: true
            });
        });

    </script>
    @endif
    <script>
        $(document).ready(function(){
            $('.cat').click(function(){
                var catid = $(this).val();
                $('#catid').val(catid);
                $.ajax({
                    url: '/category/' + catid,
                    type: 'GET',
                    success: function(response){
                        $('#cat').text(response.CategoryName);
                    },
                    error: function(xhr){
                        console.log(xhr.responseText);
                    }
                });
            });
        });
        $(document).on('click', '.categoryrow', function(){
            var catid = $(this).attr('value');
            $.ajax({
                url: '/category/subcategory/' + catid,
                type: 'GET',
                success: function(response){
                    var subcategories = response;
                    var tbody = '';
                    for(var i=0; i<subcategories.length; i++){
                        tbody += '<tr class="small"><td class="text-center">'+(i+1)+'</td><td>'+subcategories[i].SubCategoryName+'</td></tr>';
                    }
                    $('#subcategory-table').html(tbody);
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
    