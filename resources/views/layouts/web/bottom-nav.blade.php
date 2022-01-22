<div class="header-bottom sticky-header d-none d-lg-block" data-sticky-options="{
  'move': [
    {
      'item': '.logo',
      'position': 'start',
      'clone': false
    },
    {
      'item': '.header-search',
      'position': 'end',
      'clone': false
    },
    {
      'item': '.header-icon:not(.header-search)',
      'position': 'end',
      'clone': false
    },
    {
      'item': '.cart-dropdown',
      'position': 'end',
      'clone': false
    }
  ],
  'moveTo': '.container',
  'changes': [
    {
      'item': '.header-search',
      'removeClass': 'header-search-inline',
      'addClass': 'header-search-popup ml-auto'
    },
    {
      'item': '.main-nav li.custom',
      'removeClass': 'd-xl-block'
    }
  ]
}">
  <div class="container">
    <nav class="main-nav d-flex w-lg-max justify-content-center">
      <ul class="menu">
        <li class="active">
          <a href="index.html">Home</a>
        </li>
        <li>
          <a href="category.html">Categories</a>
          <div class="megamenu megamenu-fixed-width megamenu-3cols">
            <div class="row">
              <div class="col-lg-4">
                <a href="#" class="nolink">VARIATION 1</a>
                <ul class="submenu">
                  <li><a href="category.html">Fullwidth Banner</a></li>
                  <li><a href="category-banner-boxed-slider.html">Boxed Slider Banner</a></li>
                  <li><a href="category-banner-boxed-image.html">Boxed Image Banner</a></li>
                  <li><a href="category.html">Left Sidebar</a></li>
                  <li><a href="category-sidebar-right.html">Right Sidebar</a></li>
                  <li><a href="category-flex-grid.html">Product Flex Grid</a></li>
                  <li><a href="category-horizontal-filter1.html">Horizontal Filter1</a></li>
                  <li><a href="category-horizontal-filter2.html">Horizontal Filter2</a></li>
                </ul>
              </div>
              <div class="col-lg-4">
                <a href="#" class="nolink">VARIATION 2</a>
                <ul class="submenu">
                  <li><a href="category-list.html">List Types</a></li>
                  <li><a href="category-infinite-scroll.html">Ajax Infinite Scroll</a></li>
                  <li><a href="category.html">3 Columns Products</a></li>
                  <li><a href="category-4col.html">4 Columns Products</a></li>
                  <li><a href="category-5col.html">5 Columns Products</a></li>
                  <li><a href="category-6col.html">6 Columns Products</a></li>
                  <li><a href="category-7col.html">7 Columns Products</a></li>
                  <li><a href="category-8col.html">8 Columns Products</a></li>
                </ul>
              </div>
              <div class="col-lg-4 p-0" style="background: #f4f4f4 no-repeat center 82%/cover url('/assets/web/images/menu-banner.jpg')"></div>
            </div>
          </div><!-- End .megamenu -->
        </li>
        <li>
          <a href="product.html">Products</a>
          <div class="megamenu megamenu-fixed-width">
            <div class="row">
              <div class="col-lg-3">
                <a href="#" class="nolink">Variations 1</a>
                <ul class="submenu">
                  <li><a href="product.html">Horizontal Thumbs</a></li>
                  <li><a href="product-full-width.html">Vertical Thumbnails</a></li>
                  <li><a href="product.html">Inner Zoom</a></li>
                  <li><a href="product-addcart-sticky.html">Addtocart Sticky</a></li>
                  <li><a href="product-sidebar-left.html">Accordion Tabs</a></li>
                </ul>
              </div><!-- End .col-lg-4 -->
              <div class="col-lg-3">
                <a href="#" class="nolink">Variations 2</a>
                <ul class="submenu">
                  <li><a href="product-sticky-tab.html">Sticky Tabs</a></li>
                  <li><a href="product-simple.html">Simple Product</a></li>
                  <li><a href="product-sidebar-left.html">With Left Sidebar</a></li>
                </ul>
              </div><!-- End .col-lg-4 -->
              <div class="col-lg-3">
                <a href="#" class="nolink">Product Layout Types</a>
                <ul class="submenu">
                  <li><a href="product.html">Default Layout</a></li>
                  <li><a href="product-extended-layout.html">Extended Layout</a></li>
                  <li><a href="product-full-width.html">Full Width Layout</a></li>
                  <li><a href="product-grid-layout.html">Grid Images Layout</a></li>
                  <li><a href="product-sticky-both.html">Sticky Both Side Info</a></li>
                  <li><a href="product-sticky-info.html">Sticky Right Side Info</a></li>
                </ul>
              </div><!-- End .col-lg-4 -->

              <div class="col-lg-3 p-0">
                <img src="{{ asset('assets/web/images/menu-bg.png') }}" alt="Menu banner" class="product-promo">
              </div><!-- End .col-lg-4 -->
            </div><!-- End .row -->
          </div><!-- End .megamenu -->
        </li>
        <li>
          <a href="#">Pages</a>
          <ul>
            <li><a href="cart.html">Shopping Cart</a></li>
            <li><a href="#">Checkout</a>
              <ul>
                <li><a href="checkout-shipping.html">Checkout Shipping</a></li>
                <li><a href="checkout-shipping-2.html">Checkout Shipping 2</a></li>
                <li><a href="checkout-review.html">Checkout Review</a></li>
              </ul>
            </li>
            <li><a href="#">Dashboard</a>
              <ul>
                <li><a href="dashboard.html">Dashboard</a></li>
                <li><a href="my-account.html">My Account</a></li>
              </ul>
            </li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="#">Blog</a>
              <ul>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="single.html">Blog Post</a></li>
              </ul>
            </li>
            <li><a href="contact.html">Contact Us</a></li>
            <li><a href="#" class="login-link">Login</a></li>
            <li><a href="forgot-password.html">Forgot Password</a></li>
          </ul>
        </li>
        <li><a href="blog.html">Blog</a></li>
        <li><a href="about.html">About Us</a></li>
        <li class="d-none d-xl-block custom"><a href="#">Special Offer!</a></li>
        <li class="d-none d-xl-block custom"><a href="https://1.envato.market/DdLk5" target="_blank">Buy Porto!</a></li>
        <!-- Right Side Of Navbar -->
        <li class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          @guest
              @if (Route::has('login'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
              @endif

              @if (Route::has('register'))
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
              @endif
          @else
              <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ Auth::user()->first_name }}
                  </a>

                  {{-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"> --}}
                      <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  {{-- </div> --}}
              </li>
          @endguest
        </li>
      </ul>
    </nav>
  </div><!-- End .container -->
</div><!-- End .header-bottom -->