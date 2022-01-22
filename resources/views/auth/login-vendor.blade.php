@extends('layouts.app.login')

@section('main')
<div class="row justify-content-center mt-5">
    <div class="col-xl-5 col-lg-6 col-md-10">
      <div class="card">
        <div class="card-header bg-primary">
          <div class="app-brand">
            <a href="/index.html">
              <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33"
                viewBox="0 0 30 33">
                <g fill="none" fill-rule="evenodd">
                  <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                  <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                </g>
              </svg>
              <span class="brand-name">Sleek Dashboard</span>
            </a>
          </div>
        </div>
        <div class="card-body p-5">

          <h4 class="text-dark mb-5">Sign In</h4>
          <form method="POST" action="{{ route('vendor.auth') }}">
            @csrf
            <div class="row">
              <div class="form-group col-md-12 mb-4">
                <input id="email" type="email" class="form-control input-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" aria-describedby="emailHelp"  required  autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group col-md-12 ">
                <input id="password" type="password" class="form-control input-lg @error('password') is-invalid @enderror" name="password" required>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="col-md-12">
                <div class="d-flex my-2 justify-content-between">
                  <div class="d-inline-block mr-3">
                    <label class="control control-checkbox">Remember me
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      <div class="control-indicator"></div>
                    </label>
            
                  </div>
                  <p>
                    @if (Route::has('password.request'))
                      <a class="text-blue" href="{{ route('password.request') }}">
                          {{ __('Forgot Your Password?') }}
                      </a>
                    @endif
                  </p>
                </div>
                <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">Sign In</button>
                <p>Don't have an account yet ?
                  <a class="text-blue" href="sign-up.html">Sign Up</a>
                </p>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright pl-0">
    <p class="text-center">&copy; 2018 Copyright Dignitio
      <a class="text-primary" href="http://www.dignitio.com/" target="_blank">Dignitio</a>.
    </p>
  </div>
@endsection