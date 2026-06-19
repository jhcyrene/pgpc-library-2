@extends('layouts.app')
@section('title', 'Publishers')

@section('content')
<div class="container">

    <div class="row mt-3">
        <div class="col-sm-12 ms-4">
            <h5>Publishers</h5>
        </div>
    </div>

    <div class="row mt-3" style="min-height: 75vh;">
        <div class="col-sm-6">
            <form action="/publisher/add" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-10">
                            <label for="publisher" class="small">
                                Publisher Name <i class="text-danger">*</i>
                            </label>
                            <input type="text" class="form-control form-control-sm" name="publisher" id="publisher" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <label for="address" class="small">
                                Address <i class="text-danger">*</i>
                            </label>
                            <textarea name="address" id="address" class="form-control" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-blue form-control rounded-pill"><i class="fa-solid fa-floppy-disk"></i> Add Publisher</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-sm-6 d-flex flex-column">
            <label class="mb-2">Publishers list</label>
            <div class="border rounded p-2 flex-grow-1 overflow-auto bg-white shadow">
                <table class="table table-sm">
                    <thead class="bg-blue text-white">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Publisher</th>
                            <th>Address</th>
                            <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($publishers as $publisher)
                            <tr class="small">
                                <td class="text-center">{{ $publisher->id }}</td>
                                <td>{{ $publisher->Name }}</td>
                                <td>{{ $publisher->Address }}</td>
                                <td class="text-center"><button class="btn btn-sm shadow-none"><i class="fa-regular fa-pen-to-square"></i></button></td>
                            </tr>
                        @endforeach
                        
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@if(session('success'))
    <script>
        $(document).ready(function(){
            Swal.fire({
                icon: 'success',
                title: 'Add Publisher',
                text: "{{ session('success') }}",
                showConfirmButton: true
            });
        });
    </script>
    @endif
@endsection