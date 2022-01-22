<div class="header-middle">
  <div class="container">
    <div class="header-left w-lg-max ml-auto ml-lg-0">
      <div class="header-icon header-search header-search-inline header-search-category">
        <a href="#" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
        <form action="#" method="get">
          <div class="header-search-wrapper">
            <input type="search" class="form-control" name="q" id="q" placeholder="Search..." required>
            <div class="select-custom body-text">
              <select id="cat" name="cat">
                <option value="">All Categories</option>
                <option value="4">Fashion</option>
                <option value="12">- Women</option>
                <option value="13">- Men</option>
                <option value="66">- Jewellery</option>
                <option value="67">- Kids Fashion</option>
                <option value="5">Electronics</option>
                <option value="21">- Smart TVs</option>
                <option value="22">- Cameras</option>
                <option value="63">- Games</option>
                <option value="7">Home &amp; Garden</option>
                <option value="11">Motors</option>
                <option value="31">- Cars and Trucks</option>
                <option value="32">- Motorcycles &amp; Powersports</option>
                <option value="33">- Parts &amp; Accessories</option>
                <option value="34">- Boats</option>
                <option value="57">- Auto Tools &amp; Supplies</option>
              </select>
            </div><!-- End .select-custom -->
            <button class="btn icon-search-3 p-0" type="submit"></button>
          </div><!-- End .header-search-wrapper -->
        </form>
      </div><!-- End .header-search -->
    </div><!-- End .header-left -->

    <div class="header-center order-first order-lg-0 ml-0 ml-lg-auto">
      <button class="mobile-menu-toggler" type="button">
        <i class="icon-menu"></i>
      </button>
      <a href="index.html" class="logo">
        <img src="{{ asset('assets/web/images/logo.png') }}" alt="Porto Logo">
      </a>
    </div><!-- End .header-center -->

    <div class="header-right w-lg-max ml-0 ml-lg-auto">
      <div class="header-contact d-none d-lg-flex align-items-center ml-auto pr-xl-4 mr-4">
        <i class="icon-phone-2"></i>
        <h6 class="pt-1 line-height-1 pr-2">Call us now<a href="tel:#" class="d-block text-dark pt-1 font1">+123 5678 890</a></h6>
      </div><!-- End .header-contact -->

      <a href="login.html" class="header-icon login-link pl-1"><i class="icon-user-2"></i></a>

      <a href="#" class="header-icon pl-1 pr-2"><i class="icon-wishlist-2"></i></a>

      <div class="dropdown cart-dropdown">
        <a href="#" class="dropdown-toggle dropdown-arrow" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
          <i class="icon-shopping-cart"></i>
          <span class="cart-count badge-circle">2</span>
        </a>

        <div class="dropdown-menu">
          <div class="dropdownmenu-wrapper">
            <div class="dropdown-cart-header">
              <span>2 Items</span>

              <a href="cart.html" class="float-right">View Cart</a>
            </div><!-- End .dropdown-cart-header -->

            <div class="dropdown-cart-products">
              <div class="product">
                <div class="product-details">
                  <h4 class="product-title">
                    <a href="product.html">Woman Ring</a>
                  </h4>

                  <span class="cart-product-info">
                    <span class="cart-product-qty">1</span>
                    x $99.00
                  </span>
                </div><!-- End .product-details -->

                <figure class="product-image-container">
                  <a href="product.html" class="product-image">
                    <img src="{{ asset('assets/web/images/products/cart/product-1.jpg') }}" alt="product" width="80" height="80">
                  </a>
                  <a href="#" class="btn-remove icon-cancel" title="Remove Product"></a>
                </figure>
              </div><!-- End .product -->

              <div class="product">
                <div class="product-details">
                  <h4 class="product-title">
                    <a href="product.html">Woman Necklace</a>
                  </h4>

                  <span class="cart-product-info">
                    <span class="cart-product-qty">1</span>
                    x $35.00
                  </span>
                </div><!-- End .product-details -->

                <figure class="product-image-container">
                  <a href="product.html" class="product-image">
                    <img src="{{ asset('assets/web/images/products/cart/product-2.jpg') }}" alt="product" width="80" height="80">
                  </a>
                  <a href="#" class="btn-remove icon-cancel" title="Remove Product"></a>
                </figure>
              </div><!-- End .product -->
            </div><!-- End .cart-product -->

            <div class="dropdown-cart-total">
              <span>Total</span>

              <span class="cart-total-price float-right">$134.00</span>
            </div><!-- End .dropdown-cart-total -->

            <div class="dropdown-cart-action">
              <a href="checkout-shipping.html" class="btn btn-dark btn-block">Checkout</a>
            </div><!-- End .dropdown-cart-total -->
          </div><!-- End .dropdownmenu-wrapper -->
        </div><!-- End .dropdown-menu -->
      </div><!-- End .dropdown -->
    </div><!-- End .header-right -->
  </div><!-- End .container -->
</div><!-- End .header-middle -->