@extends('layouts.app')
@section('title', 'Publishers')
@section('content')
<div class="container">
    <div class="row mt-3">
        <div class="col-sm-6">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-10">
                        <label for="publisher">Publisher Name<i class="text-danger">*</i></label>
                        <input type="text" class="form-control form-control-sm" name="publisher" id="publisher" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection