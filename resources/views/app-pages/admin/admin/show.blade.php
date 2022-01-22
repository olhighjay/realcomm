@extends('layouts.app.app')

@section('main')
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-12">
          <div class="card card-default">
            <div class="card-body">
              <div class="row no-gutters justify-content-center">
                <div class="col-lg-7 col-xl-7">
                  <div class="profile-content-center pt-5 pb-3 px-3 px-xl-5">
                    <div class="card text-center widget-profile px-0 border-0">
                      <div class="card-img mx-auto rounded-circle ">
                        @if($admin->profile_picture)
                          <img src="{{ asset('/images/admin_profile_picture/thumbnail/'.$admin->profile_picture) }}" width="100px" height="100px"  alt="user image">
                        @else
                          <img src="{{ asset('assets/app/img/user/dummydp.jpg') }}" width="100px" height="100px"  alt="user image">
                        @endif
                      </div>
                      <div class="card-body">
                        <h4 class="py-2 text-dark"><p>{{ $admin->first_name }} <p>{{ $admin->last_name }}</p></p></h4>
                        <p><p>{{ $admin->email }}</p></p>
                      </div>
                    </div>
                    <div class=" row d-flex justify-content-center ">
                      <div class="text-center pb-4 mx-2">
                        <button class="btn btn-info" style="padding-top:4px; padding-bottom:4px"><a style="color: white" href="/admins/{{ $admin->id }}/edit">edit</a></button>
                      </div>
                      <div class="text-center pb-4 mx-2">
                        <button class="btn btn-warning" style="padding-top:4px; padding-bottom:4px">deactivate</button>
                      </div>
                      <div class="text-center pb-4 mx-2">
                        <button class="btn btn-danger" style="padding-top:4px; padding-bottom:4px">Delete</button>
                      </div>
                    </div>
                    <hr class="w-100">
                    <div class="contact-info pt-4">
                      <h5 class="text-dark mb-1">Contact Information</h5>
                      <p class="text-dark font-weight-medium pt-4 mb-2">First name</p>
                      <p>{{ $admin->first_name }}</p>
                      <p class="text-dark font-weight-medium pt-4 mb-2">Last name</p>
                      <p>{{ $admin->last_name }}</p>
                      <p class="text-dark font-weight-medium pt-4 mb-2">Email address</p>
                      <p>{{ $admin->email }}</p>
                      <p class="text-dark font-weight-medium pt-4 mb-2">Created on</p>
                      <p>{{ $admin->created_at }}</p>
                      <p class="text-dark font-weight-medium pt-4 mb-2">Last updated on</p>
                      <p>{{ $admin->updated_at }}</p>
                      {{--<p class="text-dark font-weight-medium pt-4 mb-2">Social Profile</p>
                      <p class="pb-3 social-button">
                        <a href="#" class="mb-1 btn btn-outline btn-twitter rounded-circle">
                          <i class="mdi mdi-twitter"></i>
                        </a>
                        <a href="#" class="mb-1 btn btn-outline btn-linkedin rounded-circle">
                          <i class="mdi mdi-linkedin"></i>
                        </a>
                        <a href="#" class="mb-1 btn btn-outline btn-facebook rounded-circle">
                          <i class="mdi mdi-facebook"></i>
                        </a>
                      {{-- <p class="text-dark font-weight-medium pt-4 mb-2">Social Profile</p>
                      <p class="pb-3 social-button">
                        <a href="#" class="mb-1 btn btn-outline btn-twitter rounded-circle">
                          <i class="mdi mdi-twitter"></i>
                        </a>
                        <a href="#" class="mb-1 btn btn-outline btn-linkedin rounded-circle">
                          <i class="mdi mdi-linkedin"></i>
                        </a>
                        <a href="#" class="mb-1 btn btn-outline btn-facebook rounded-circle">
                          <i class="mdi mdi-facebook"></i>
                        </a>
                        <a href="#" class="mb-1 btn btn-outline btn-skype rounded-circle">
                          <i class="mdi mdi-skype"></i>
                        </a>
                      </p> --}}
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
