@extends('layouts.web.app')
@section('main')

  <main class="main">
    @include('layouts.web.customer-breadcrumbs')

    <div class="container mb-5">
      <div class="row">
        <div class="col-lg-9 order-lg-last dashboard-content">
          <h2>Edit Account Information</h2>

          <form action="#">
            <div class="row">
              <div class="col-sm-11">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group required-field">
                      <label for="acc-name">First Name</label>
                      <input type="text" class="form-control" id="acc-name" name="acc-name" required>
                    </div><!-- End .form-group -->
                  </div><!-- End .col-md-4 -->

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="acc-mname">First Name</label>
                      <input type="text" class="form-control" id="acc-mname" name="acc-mname">
                    </div><!-- End .form-group -->
                  </div><!-- End .col-md-4 -->

                  <div class="col-md-4">
                    <div class="form-group required-field">
                      <label for="acc-lastname">Last Name</label>
                      <input type="text" class="form-control" id="acc-lastname" name="acc-lastname" required>
                    </div><!-- End .form-group -->
                  </div><!-- End .col-md-4 -->
                </div><!-- End .row -->
              </div><!-- End .col-sm-11 -->
            </div><!-- End .row -->

            <div class="form-group required-field">
              <label for="acc-email">Email</label>
              <input type="email" class="form-control" id="acc-email" name="acc-email" required>
            </div><!-- End .form-group -->

            <div class="form-group required-field">
              <label for="acc-password">Password</label>
              <input type="password" class="form-control" id="acc-password" name="acc-password" required>
            </div><!-- End .form-group -->

            <div class="mb-2"></div><!-- margin -->

            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="change-pass-checkbox" value="1">
              <label class="custom-control-label" for="change-pass-checkbox">Change Password</label>
            </div><!-- End .custom-checkbox -->

            <div id="account-chage-pass">
              <h3 class="mb-2">Change Password</h3>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group required-field">
                    <label for="acc-pass2">Password</label>
                    <input type="password" class="form-control" id="acc-pass2" name="acc-pass2">
                  </div><!-- End .form-group -->
                </div><!-- End .col-md-6 -->

                <div class="col-md-6">
                  <div class="form-group required-field">
                    <label for="acc-pass3">Confirm Password</label>
                    <input type="password" class="form-control" id="acc-pass3" name="acc-pass3">
                  </div><!-- End .form-group -->
                </div><!-- End .col-md-6 -->
              </div><!-- End .row -->
            </div><!-- End #account-chage-pass -->

            <div class="required text-right">* Required Field</div>
            <div class="form-footer">
              <a href="#"><i class="icon-angle-double-left"></i>Back</a>

              <div class="form-footer-right">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div><!-- End .form-footer -->
          </form>
        </div><!-- End .col-lg-9 -->

        @include('layouts.web.customer-sidebar')
      </div><!-- End .row -->
    </div><!-- End .container -->
  </main><!-- End .main --> 
@endsection