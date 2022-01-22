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
                        @if($business->logo)
                          <img src="{{ asset('/images/business_logo/thumbnail/'.$business->logo) }}" width="100px" height="100px"  alt="user image">
                        @else
                          <img src="{{ asset('assets/app/img/logo-word.png') }}" width="100px" height="100px"  alt="user image">
                        @endif
                      </div>
                      <div class="card-body">
                        <h4 class="py-2 text-dark">{{ $business->name }}</h4>
                        <p>Owned by: {{ $business->user->first_name . ' ' . $business->user->last_name }}</p>
                      </div>
                    </div>
                    <div class=" row d-flex justify-content-center ">
                      <div class="text-center pb-4 mx-2">
                        <button class="btn btn-info" style="padding-top:4px; padding-bottom:4px"><a style="color: white" href="/businesses/{{ $business->id }}/edit">edit</a></button>
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
                        <p class="text-dark font-weight-medium pt-4 mb-2">Business name</p>
                        <p>{{ $business->name }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Vendor</p>
                        <p><a href="/vendors/{{ $business->user_id }}">{{ $business->user->first_name . ' ' . $business->user->last_name }}</a></p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Category</p>
                        <p>{{ $business->business_category->name }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Subscribed to</p>
                        <p>{{ $business->subscription->name }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Primamry Address</p>
                        <p>{{ $business->address }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Other Addresses</p>
                        <p>{{ $business->name }}</p>
                      </div>
                      <div class="col-lg-4 col-md-10 col-sm-12">
                        <p class="text-dark font-weight-medium pt-4 mb-2">Bank</p>
                        <p>{{ $business->bank_name }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Account name</p>
                        <p>{{ $business->bank_account_name }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Account number</p>
                        <p>{{ $business->bank_account_number }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Bank verification</p>
                        <p>@if($business->bank_details_verified == false) Not verified @else Verified @endif</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Status</p>
                        <p>{{ $business->status }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Created on</p>
                        <p>{{ $business->created_at }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Last updated on</p>
                        <p>{{ $business->updated_at }}</p>
                      </div>
                    </div>
                    
                    <p class="text-dark font-weight-medium pt-4 mb-2">Description</p>
                    <p>{{ $business->description }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
