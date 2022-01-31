@extends('layouts.app.app')

@section('main')
    <div class="container pale">
        <div class="row justify-content-center" >
            <div class="col-lg-7 col-md-9 col-sm-12 mt-4 mb-4">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Edit Product </h2>
                    </div>
                    <div class="card-body">
                        <product-edit-component :id="'{{ $id }}'" :categories="{{ $categories }}" ></product-edit-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
