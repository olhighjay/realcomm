@extends('layouts.app.app')

@section('main')
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-12">
          <div class="card card-default">
            <div class="card-body">
              <buyer-table-component></buyer-table-component>
            </div>
          </div>
        </div>
    </div>
</div>


{{-- <script type="application/javascript" src="{{ asset('assets/app/js/my-script.js') }}"></script> --}}
@endsection