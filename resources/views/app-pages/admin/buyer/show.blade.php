@extends('layouts.app.app')

@section('main')
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-12">
          <div class="card card-default">
            <div class="card-body">
              <div class="row no-gutters justify-content-center">
                <div class="col-lg-8 col-xl-8">
                  <div class="profile-content-center pt-5 pb-3 px-3 px-xl-5">
                    <div class="card text-center widget-profile px-0 border-0">
                      <div class="card-img mx-auto rounded-circle ">
                        @if($buyer->profile_picture)
                          <img src="{{ asset('/images/buyer_profile_picture/thumbnail/'.$buyer->profile_picture) }}" width="100px" height="100px"  alt="user image">
                        @else
                          <img src="{{ asset('assets/app/img/user/dummydp.jpg') }}" width="100px" height="100px"  alt="user image">
                        @endif
                      </div>
                      <div class="card-body">
                        <h4 class="py-2 text-dark"><p>{{ $buyer->first_name }} <p>{{ $buyer->last_name }}</p></p></h4>
                        <p><p>{{ $buyer->email }}</p></p>
                      </div>
                    </div>
                    <div class=" row d-flex justify-content-center ">
                      <div class="text-center pb-4 mx-2">
                        <button class="btn btn-info" style="padding-top:4px; padding-bottom:4px"><a style="color: white" href="/buyers/{{ $buyer->id }}/edit">edit</a></button>
                      </div>
                      <div class="text-center pb-4 mx-2">
                        <button class="btn btn-warning" style="padding-top:4px; padding-bottom:4px">deactivate</button>
                      </div>
                      <div class="text-center pb-4 mx-2">
                        <button class="btn btn-danger" style="padding-top:4px; padding-bottom:4px">Delete</button>
                      </div>
                    </div>
                    <hr class="w-100">
                    <h5 class="text-dark mb-1 pt-4 ">Contact Information</h5>
                    <div class="contact-info row d-flex  ">
                      <div class="col-lg-8 col-md-10 col-sm-12">
                        <p class="text-dark font-weight-medium pt-4 mb-2">First name</p>
                        <p>{{ $buyer->first_name }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Middle name</p>
                        <p>{{ $buyer->middle_name }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Last name</p>
                        <p>{{ $buyer->last_name }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Email address</p>
                        <p>{{ $buyer->email }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Phone number</p>
                        <p>{{ $buyer->phone_number }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Address</p>
                        <p>{{ $buyer->address }}</p>
                      </div>
                      <div class="col-lg-4 col-md-10 col-sm-12">
                        <p class="text-dark font-weight-medium pt-4 mb-2">Role</p>
                        <p>{{ $buyer->role }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Gender</p>
                        <p>{{ $buyer->gender }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">State</p>
                        <p>{{ $buyer->state }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Date of Birth</p>
                        <p>{{ $buyer->dob }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Created on</p>
                        <p>{{ $buyer->created_at }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Last updated on</p>
                        <p>{{ $buyer->updated_at }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
