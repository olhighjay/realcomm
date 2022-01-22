@extends('layouts.web.app')
@section('main')
<main class="main">
			<div class="promo-section bg-gray" data-parallax="{'speed': 1.5, 'enableOnMobile': true, 'offset': 24 }" data-image-src="{{ asset('assets/web/images/banners/promo-bg.png') }}">
				<div class="promo-banner banner container text-uppercase">
					<div class="banner-content row align-items-center text-center">
						<div class="col-md-5 col-lg-4 ml-xl-auto text-md-right">
							<h2 class="mb-md-0">Top electronic<br>Deals</h2>
						</div>
						<div class="col-md-3 pb-4 pb-md-0">
							<a href="#" class="btn btn-primary ls-10">View Sale</a>
						</div>
						<div class="col-md-4 mr-xl-auto text-md-left">
							<h4 class="mb-1 coupon-sale-text p-0 d-block ls-10 text-transform-none">
								<b class="bg-dark text-white font1">Exclusive COUPON</b>
							</h4>
							<h5 class="mb-0 coupon-sale-text ls-10 p-0"><i class="ls-0">UP TO</i><b class="text-white bg-secondary">$100</b> OFF</h5>
						</div>
					</div>
				</div>
			</div>

			<nav aria-label="breadcrumb" class="breadcrumb-nav">
				<div class="container">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
						<li class="breadcrumb-item"><a href="#">Men</a></li>
						<li class="breadcrumb-item active" aria-current="page">Accessories</li>
					</ol>
				</div>
			</nav>

			<div class="container mb-3">
				<nav class="toolbox horizontal-filter">
					<div class="toolbox-left d-none d-lg-block">
						<div class="toolbox-item filter-toggle">
							<span>Filters:</span>
							<a href=#>&nbsp;</a>
						</div>
					</div><!-- End .toolbox-left -->

					<div class="toolbox-item toolbox-sort ml-lg-auto">
						<label>Sort By:</label>

						<div class="select-custom">
							<select name="orderby" class="form-control">
								<option value="menu_order" selected="selected">Default sorting</option>
								<option value="popularity">Sort by popularity</option>
								<option value="rating">Sort by average rating</option>
								<option value="date">Sort by newness</option>
								<option value="price">Sort by price: low to high</option>
								<option value="price-desc">Sort by price: high to low</option>
							</select>
						</div><!-- End .select-custom -->

					</div><!-- End .toolbox-item -->

					<div class="toolbox-item toolbox-show ml-auto ml-lg-0">
						<label>Show:</label>

						<div class="select-custom">
							<select name="count" class="form-control">
								<option value="20">20</option>
								<option value="30">30</option>
								<option value="40">40</option>
								<option value="50">50</option>
							</select>
						</div><!-- End .select-custom -->
					</div><!-- End .toolbox-item -->

					<div class="toolbox-item layout-modes">
						<a href="category.html" class="layout-btn btn-grid active" title="Grid">
							<i class="icon-mode-grid"></i>
						</a>
						<a href="category-list.html" class="layout-btn btn-list" title="List">
							<i class="icon-mode-list"></i>
						</a>
					</div><!-- End .layout-modes -->
				</nav>

				<div class="row main-content-wrap">
					<div class="col-lg-9 main-content">
						<div class="row">
							@foreach ($categoryProducts as $categoryProduct)
								<div class="col-6 col-sm-4 col-md-3">
									<div class="product-default inner-quickview inner-icon">
										<figure>
											<a href="/product/{{ $categoryProduct->id }}/{{ $categoryProduct->slug }}">
												<img src="{{ asset('/assets/web/images/products/product-1.jpg') }}">
											</a>
											<div class="label-group">
												<div class="product-label label-hot">HOT</div>
												@if ($categoryProduct->sale_price)
													<div class="product-label label-sale">{{ round(($categoryProduct->regular_price - $categoryProduct->sale_price) * 100 / $categoryProduct->regular_price) }}%</div>
												@endif
											</div>
											<div class="btn-icon-group">
												<button class="btn-icon btn-add-cart" data-toggle="modal" data-target="#addCartModal"><i class="icon-shopping-cart"></i></button>
											</div>
											<a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View">Quick View</a> 
										</figure>
										<div class="product-details">
											<div class="category-wrap">
												<div class="category-list">
													<a href="category.html" class="product-category">{{ $category->name }}</a>
												</div>
												<a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a>
											</div>
											<h2 class="product-title">
												<a href="product.html">{{ $categoryProduct->name }}</a>
											</h2>
											<div class="ratings-container">
												<div class="product-ratings">
													<span class="ratings" style="width:100%"></span><!-- End .ratings -->
													<span class="tooltiptext tooltip-top"></span>
												</div><!-- End .product-ratings -->
											</div><!-- End .product-container -->
											<div class="price-box">
												@if ($categoryProduct->sale_price)
													<span class="old-price">${{ $categoryProduct->regular_price }}</span>
													<span class="product-price">${{ $categoryProduct->sale_price }}</span>					
												@else
													<span class="product-price">${{ $categoryProduct->regular_price }}</span>
												@endif
											</div><!-- End .price-box -->
										</div><!-- End .product-details -->
									</div>
								</div><!-- End .col-sm-4 -->	
							@endforeach
						</div><!-- End .row -->

						<nav class="toolbox toolbox-pagination">
							<div class="toolbox-item toolbox-show">
								<label>Show:</label>

								<div class="select-custom">
									<select name="count" class="form-control">
										<option value="12">12</option>
										<option value="24">24</option>
										<option value="36">36</option>
									</select>
								</div><!-- End .select-custom -->
							</div><!-- End .toolbox-item -->

							<ul class="pagination toolbox-item">
								<li class="page-item disabled">
									<a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
								</li>
								<li class="page-item active">
									<a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
								</li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item"><a class="page-link" href="#">4</a></li>
								<li class="page-item"><a class="page-link" href="#">5</a></li>
								<li class="page-item"><span class="page-link">...</span></li>
								<li class="page-item">
									<a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
								</li>
							</ul>
						</nav>
					</div><!-- End .col-lg-9 -->

					<div class="sidebar-overlay"></div>
					<div class="sidebar-toggle"><i class="fas fa-sliders-h"></i></div>
					<aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
						<div class="sidebar-wrapper">
							<div class="widget">
								<h3 class="widget-title">
									<a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true" aria-controls="widget-body-2">Categories</a>
								</h3>

								<div class="collapse show" id="widget-body-2">
									<div class="widget-body">
										<ul class="cat-list">
											<li><a href="#">Accessories</a></li>
											<li><a href="#">Watch Fashion</a></li>
											<li><a href="#">Tees, Knits &amp; Polos</a></li>
											<li><a href="#">Pants &amp; Denim</a></li>
										</ul>
									</div><!-- End .widget-body -->
								</div><!-- End .collapse -->
							</div><!-- End .widget -->

							<div class="widget">
								<h3 class="widget-title">
									<a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="true" aria-controls="widget-body-3">Price</a>
								</h3>

								<div class="collapse show" id="widget-body-3">
									<div class="widget-body">
										<form action="#">
											<div class="price-slider-wrapper">
												<div id="price-slider"></div><!-- End #price-slider -->
											</div><!-- End .price-slider-wrapper -->

											<div class="filter-price-action d-flex align-items-center justify-content-between flex-wrap">
												<button type="submit" class="btn btn-primary">Filter</button>

												<div class="filter-price-text">
													Price:
													<span id="filter-price-range"></span>
												</div><!-- End .filter-price-text -->
											</div><!-- End .filter-price-action -->
										</form>
									</div><!-- End .widget-body -->
								</div><!-- End .collapse -->
							</div><!-- End .widget -->

							<div class="widget">
								<h3 class="widget-title">
									<a data-toggle="collapse" href="#widget-body-4" role="button" aria-expanded="true" aria-controls="widget-body-4">Size</a>
								</h3>

								<div class="collapse show" id="widget-body-4">
									<div class="widget-body">
										<ul class="cat-list">
											<li><a href="#">Small</a></li>
											<li><a href="#">Medium</a></li>
											<li><a href="#">Large</a></li>
											<li><a href="#">Extra Large</a></li>
										</ul>
									</div><!-- End .widget-body -->
								</div><!-- End .collapse -->
							</div><!-- End .widget -->

							<div class="widget">
								<h3 class="widget-title">
									<a data-toggle="collapse" href="#widget-body-5" role="button" aria-expanded="true" aria-controls="widget-body-5">Brand</a>
								</h3>

								<div class="collapse show" id="widget-body-5">
									<div class="widget-body">
										<ul class="cat-list">
											<li><a href="#">Adidas</a></li>
											<li><a href="#">Calvin Klein (26)</a></li>
											<li><a href="#">Diesel (3)</a></li>
											<li><a href="#">Lacoste (8)</a></li>
										</ul>
									</div><!-- End .widget-body -->
								</div><!-- End .collapse -->
							</div><!-- End .widget -->

							<div class="widget">
								<h3 class="widget-title">
									<a data-toggle="collapse" href="#widget-body-6" role="button" aria-expanded="true" aria-controls="widget-body-6">Color</a>
								</h3>

								<div class="collapse show" id="widget-body-6">
									<div class="widget-body">
										<ul class="config-swatch-list">
											<li class="active">
												<a href="#" style="background-color: #000;"></a>
												<span>Black</span>
											</li>
											<li>
												<a href="#" style="background-color: #0188cc;"></a>
												<span>Blue</span>
											</li>
											<li>
												<a href="#" style="background-color: #81d742;"></a>
												<span>Green</span>
											</li>
											<li>
												<a href="#" style="background-color: #6085a5;"></a>
												<span>Indigo</span>
											</li>
											<li>
												<a href="#" style="background-color: #ab6e6e;"></a>
												<span>Red</span>
											</li>
											<li>
												<a href="#" style="background-color: #ddb373;"></a>
												<span>Brown</span>
											</li>
											<li>
												<a href="#" style="background-color: #6b97bf;"></a>
												<span>Light-Blue</span>
											</li>
											<li>
												<a href="#" style="background-color: #eded68;"></a>
												<span>Yellow</span>
											</li>
										</ul>
									</div><!-- End .widget-body -->
								</div><!-- End .collapse -->
							</div><!-- End .widget -->

							<div class="widget widget-featured">
								<h3 class="widget-title">Featured</h3>

								<div class="widget-body">
									<div class="owl-carousel widget-featured-products">
										<div class="featured-col">
											<div class="product-default left-details product-widget">
												<figure>
													<a href="product.html">
														<img src="{{ asset('assets/web/images/products/product-10.jpg') }}">
													</a>
												</figure>
												<div class="product-details">
													<h2 class="product-title">
														<a href="product.html">Product Short Name</a>
													</h2>
													<div class="ratings-container">
														<div class="product-ratings">
															<span class="ratings" style="width:100%"></span><!-- End .ratings -->
															<span class="tooltiptext tooltip-top"></span>
														</div><!-- End .product-ratings -->
													</div><!-- End .product-container -->
													<div class="price-box">
														<span class="product-price">$49.00</span>
													</div><!-- End .price-box -->
												</div><!-- End .product-details -->
											</div>
											<div class="product-default left-details product-widget">
												<figure>
													<a href="product.html">
														<img src="{{ asset('assets/web/images/products/product-11.jpg') }}">
													</a>
												</figure>
												<div class="product-details">
													<h2 class="product-title">
														<a href="product.html">Product Short Name</a>
													</h2>
													<div class="ratings-container">
														<div class="product-ratings">
															<span class="ratings" style="width:100%"></span><!-- End .ratings -->
															<span class="tooltiptext tooltip-top"></span>
														</div><!-- End .product-ratings -->
													</div><!-- End .product-container -->
													<div class="price-box">
														<span class="product-price">$49.00</span>
													</div><!-- End .price-box -->
												</div><!-- End .product-details -->
											</div>
											<div class="product-default left-details product-widget">
												<figure>
													<a href="product.html">
														<img src="{{ asset('assets/web/images/products/product-12.jpg') }}">
													</a>
												</figure>
												<div class="product-details">
													<h2 class="product-title">
														<a href="product.html">Product Short Name</a>
													</h2>
													<div class="ratings-container">
														<div class="product-ratings">
															<span class="ratings" style="width:100%"></span><!-- End .ratings -->
															<span class="tooltiptext tooltip-top"></span>
														</div><!-- End .product-ratings -->
													</div><!-- End .product-container -->
													<div class="price-box">
														<span class="product-price">$49.00</span>
													</div><!-- End .price-box -->
												</div><!-- End .product-details -->
											</div>
										</div><!-- End .featured-col -->

										<div class="featured-col">
											<div class="product-default left-details product-widget">
												<figure>
													<a href="product.html">
														<img src="{{ asset('assets/web/images/products/product-13.jpg') }}">
													</a>
												</figure>
												<div class="product-details">
													<h2 class="product-title">
														<a href="product.html">Product Short Name</a>
													</h2>
													<div class="ratings-container">
														<div class="product-ratings">
															<span class="ratings" style="width:100%"></span><!-- End .ratings -->
															<span class="tooltiptext tooltip-top"></span>
														</div><!-- End .product-ratings -->
													</div><!-- End .product-container -->
													<div class="price-box">
														<span class="product-price">$49.00</span>
													</div><!-- End .price-box -->
												</div><!-- End .product-details -->
											</div>
											<div class="product-default left-details product-widget">
												<figure>
													<a href="product.html">
														<img src="{{ asset('assets/web/images/products/product-14.jpg') }}">
													</a>
												</figure>
												<div class="product-details">
													<h2 class="product-title">
														<a href="product.html">Product Short Name</a>
													</h2>
													<div class="ratings-container">
														<div class="product-ratings">
															<span class="ratings" style="width:100%"></span><!-- End .ratings -->
															<span class="tooltiptext tooltip-top"></span>
														</div><!-- End .product-ratings -->
													</div><!-- End .product-container -->
													<div class="price-box">
														<span class="product-price">$49.00</span>
													</div><!-- End .price-box -->
												</div><!-- End .product-details -->
											</div>
											<div class="product-default left-details product-widget">
												<figure>
													<a href="product.html">
														<img src="{{ asset('assets/web/images/products/product-8.jpg') }}">
													</a>
												</figure>
												<div class="product-details">
													<h2 class="product-title">
														<a href="product.html">Product Short Name</a>
													</h2>
													<div class="ratings-container">
														<div class="product-ratings">
															<span class="ratings" style="width:100%"></span><!-- End .ratings -->
															<span class="tooltiptext tooltip-top"></span>
														</div><!-- End .product-ratings -->
													</div><!-- End .product-container -->
													<div class="price-box">
														<span class="product-price">$49.00</span>
													</div><!-- End .price-box -->
												</div><!-- End .product-details -->
											</div>
										</div><!-- End .featured-col -->
									</div><!-- End .widget-featured-slider -->
								</div><!-- End .widget-body -->
							</div><!-- End .widget -->

							<div class="widget widget-block">
								<h3 class="widget-title">Custom HTML Block</h3>
								<h5>This is a custom sub-title.</h5>
								<p>Lorem ipsum dolor sit amet, consectetur elitad adipiscing Cras non placerat mi. </p>
							</div><!-- End .widget -->
						</div><!-- End .sidebar-wrapper -->
					</aside><!-- End .col-lg-3 -->
				</div><!-- End .row -->
			</div><!-- End .container -->
		</main><!-- End .main -->
@endsection

