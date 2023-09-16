@extends('components.front-end.front-end-layout')


@section('contents')
@php
    $navlink = '<a href="'.url('home').'" class="font-14">Home</a><span class="px-3">&gt;</span>';
    $navlink .= '<a href="'.url('product?category_id='.$product->category_id).'" class="font-14">'.$product->category->category_name.'</a><span class="px-3">&gt;</span>';
    $navlink .='<span class="font-14">'.$product->product_name.'</span>';
@endphp
<x-frontend-breadcrumb navlink="{{ $navlink }}"></x-frontend-breadcrumb>
<div class="container-fluid px-lg-4">
    <input type="hidden" id="product_price" value="<?= $product->product_sale_price ?>">
    <input type="hidden" id="product_id" value="<?= $product->id ?>">
    <div class="row pt-3">
        <div class="col-lg-7 mb-5 mb-lg-0">
            <div class="product_zoom_slide">
                <div class="pdp-image-gallery-block row mx-0">
                    <!-- Gallery thumb -->
                    <div class="gallery_pdp_container col-md-3 order-2 order-md-0">
                        <div id="gallery_pdp">
                            @foreach ($product->product_images as $key => $product_image)
                                <div class="single_zoom_img">
                                    <a href="#" class="active" data-image="{{ $product_image->product_image }}" data-zoom-image="{{ $product_image->product_image }}">
                                        <img id="" src="{{ $product_image->product_image }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Gallery -->
                    <!-- gallery Viewer -->
                    <div class="gallery-viewer col-md-9 m-0">
                        <img id="zoom_10" class="active-image-viewer" src="{{ $product->product_images[0]->product_image }}" data-zoom-image="{{ $product->product_images[0]->product_image }}" href="{{ $product->product_images[0]->product_image }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h3 class="font-24 font-bold text-uppercase mb-2">{{ $product->product_name }}</h3>
            <p>{{ $product->brand_name }}</p>
            <div class="prise_wraper mt-4 mb-5">
                <p class="font-18"><span class="text-red">USD {{ $product->product_sale_price }}</span> <span class="text-decoration-line-through">{{ $product->product_price }}</span> (<?= calculateDiscountPercentage($product->product_price, $product->product_sale_price) ?>% off)</p>
                <p class="font-18">Offer Price ${{ $product->product_sale_price }}</p>
            </div>
            <div class="btn-wrapper d-flex align-items-center mb-4 Quantity-wraper">
                <span class="font-18">
                    Qty: <input type="text" min="1" max="404" id="quantity" value="{{ isset($cart->quantity) ? $cart->quantity : 1 }}" class="input-number input-quantity"></span>
                <button type="button" data-type="minus" class="btn btn-number btn-minus quantity-minus ml-0"> - </button>
                <button type="button" data-type="plus" class="btn btn-number btn-plus quantity-plus"> + </button>
            </div>

            <a class="site_button font-18 text-uppercase text-center font-bold d-block mb-1 add-to-cart">Add to Cart</a>
            <a href="#" class="font-14 text-decoration-underline mb-3 d-inline-block">Add To Registry</a>
            <div class="remember d-flex mb-2">
                <input type="radio" name="" id="remem">
                <label for="remem">
                    <p class="set_as mx-2 mr-0">
                        <span>Ship it to <a href="#" class="text-decoration-underline"> Enter Zip</a></span>
                        <span class="font-14 d-block">In stock: Usually ships within 2 business days.</span>
                    </p>
                </label>
            </div>
            <div class="remember d-flex mb-3">
                <input type="radio" name="" id="remem2">
                <label for="remem2">
                    <p class="set_as mx-2 mr-0">
                        <span>Pick Up <a href="#" class="text-decoration-underline"> Find Store</a></span>
                    </p>
                </label>
            </div>

            <div class="accordion pro_detail text-start mb-4" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Product Details
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <p class="font-14 mb-3">{{ $product->description }}</p>
                            {{-- <p class="font-14 mb-3">Perfect for small apartments or couples, this George Foreman grill serves up delicious burgers, steaks, veggies or sandwiches in no time.</p> --}}
                            {{-- <ul class="px-3 pr-0">
                                <li>Durable grill plates with an easy-cleaning nonstick surface</li>
                                <li>36" sloped cooking surface helps juices drain into a dishwasher-safe drip tray</li>
                                <li>Power indicator light shuts off when grill is ready</li>
                                <li>Approx. dimensions: 8.55"L x 9.375"W x 4.98"H</li>
                                <li>WARNING: Do not use any power adapter, charger or cords other than those included with your product. Using incompatible, counterfeit or non-certified accessories can cause fire or accidents.</li>
                                <li>Contact the manufacturer for replacements.</li>
                                <li>Plastic/stainless steel</li>
                                <li>Spot clean</li>
                                <li>Imported</li>
                                <li>Web ID: 12680422</li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingtWO">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetWO" aria-expanded="false" aria-controls="collapsetWO">
                            Shipping &amp; Returns
                        </button>
                    </h2>
                    <div id="collapsetWO" class="accordion-collapse collapse" aria-labelledby="headingtWO" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            Shipping &amp; Returns detail will be here
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="font-24 font-bold text-uppercase mb-4 pb-2 border-bottom">frequently bought together</h3>
            <div class="d-flex align-items-center baught_together justify-content-lg-between mb-3">
                <div class="img_wraper border p-2">
                    <img src="{{ asset('assets/images/19453835_fpx.png') }}" width="180px" height="180px">
                </div>
                <div class="mx-2"><img src="{{ asset('assets/icons/plus.svg') }}"></div>
                <div class="img_wraper border p-2">
                    <img src="{{ asset('assets/images/20024311_fpx.png') }}" width="180px" height="180px">
                </div>
            </div>
            <div class="remember d-flex mb-4">
                <input type="radio" name="" id="remem3">
                <label for="remem3">
                    <p class="set_as mx-2 mr-0">
                        <span class="font-bold text-uppercase">George Foreman</span>
                        <span class="font-14 d-block">2-Serving Classic Plate Electric Indoor Grill & Panini Press</span>
                        <span><span class="text-red">Sale USD 28.99</span> 40.00</span>
                    </p>
                </label>
            </div>
            <div class="remember d-flex mb-4">
                <input type="radio" name="" id="remem4">
                <label for="remem4">
                    <p class="set_as mx-2 mr-0">
                        <span class="font-bold text-uppercase">Bella</span>
                        <span class="font-14 d-block">Bella 5-Cup Drip Coffeemaker</span>
                        <span><span class="text-red">Sale USD 28.99</span> 40.00</span>
                    </p>
                </label>
            </div>
            <a href="#" class="site_button font-18 text-uppercase text-center font-bold d-block mb-5">Buy Together $57.98</a>
        </div>
    </div>
    <div class="main-heading border-bottom text-center mb-5">
        <span class="font-28 font-bold text-uppercase pb-2 d-inline-block">Things We Know You'll Love</span>
    </div>
    <div class="row most_view_wraper pt-lg-4">
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/4900942_sd.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Apple</a>
            <p class="font-14">AirPods Pro (with Magsafe Charging Case) - White</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/5706617ld.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Apple</a>
            <p class="font-14">Apple Watch Series 7 (GPS) 41mm Starlight Aluminum Case with Starlight Sport Band</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/6437121_sd.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Apple</a>
            <p class="font-14">20W USB-C Power Adapter - White</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/6215933_sd.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Apple</a>
            <p class="font-14">Apple Watch Series 7 (GPS) 41mm Starlight Aluminum Case with Starlight Sport Band</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/6428997_sd.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Microsoft</a>
            <p class="font-14">Surface Laptop Go - 12.4" Touch-Screen - Intel 10th Generation Core i5 - 8GB</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/6084400_sd.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Apple</a>
            <p class="font-14">AirPods Pro (with Magsafe Charging Case) - White</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
    </div>
    <div class="text-center pb-5">
        <a href="#" class="site_button d-inline-block">Start Buying</a>
    </div>

    <div class="main-heading border-bottom text-center mb-5">
        <span class="font-28 font-bold text-uppercase pb-2 d-inline-block">Recently Viewed</span>
    </div>
    <div class="row most_view_wraper mb-lg-5">
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/5706621ld.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Apple</a>
            <p class="font-14">Apple Watch Series 3 (GPS) 38mm Silver Aluminum Case with White Sport Band </p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/6255151_sd.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Brand</a>
            <p class="font-14">NortonLifeLock - 360 Deluxe (5-Device) (1-Year Subscription with Auto Renewal)</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/6479210_so.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Brand</a>
            <p class="font-14">Free Guy [Includes Digital Copy] [4K Ultra HD Blu-ray/Blu-ray] [2020]</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/6476920_sd.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">iBUYPOWER</a>
            <p class="font-14">iBUYPOWER - Element Mini Gaming Desktop - AMD Ryzen 5 3600 - 16GB Memory - NVIDIA</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/6471479_sd.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Apple</a>
            <p class="font-14"> Defender Series Pro Hard Shell for Apple iPhone 13 Pro Max and iPhone 12 Pro Max -</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2 mb-5">
            <div class="img_wraper mb-3">
                <img src="{{ asset('assets/images/6480937_sd.jpg') }}">
            </div>
            <a href="#" class="font-14 font-bold d-inline-block">Brand</a>
            <p class="font-14">WD - easystore 14TB External USB 3.0 Hard Drive - Black</p>
            <div class="prise_wraper mt-2">
                <p class="font-14"><span class="text-red">USD 116.99</span> <span class="text-decoration-line-through">130.99</span> (18% off)</p>
                <p class="font-14">Offer Price $ 118.99</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('insider-page')
    @include('components.front-end.common.insider-footer')
@endsection
@section('scripts')
    <script type="text/javascript">
        $(".single_zoom_img").on('click', function(){
            // $(this).addClass('active')
            var active_image_src = $(this).find('img').attr('src');
            $(".active-image-viewer").attr('src', active_image_src);
        });

        
    </script>
    <!-- zoom js -->
	<script src="{{ asset('assets/js/zoom.js') }}"></script>

	<!-- product zoom -->
	<script src="https://icodefy.com/Tools/iZoom/js/Vendor/jquery/jquery-ui.min.js"></script>
	<script src="https://icodefy.com/Tools/iZoom/js/Vendor/ui-carousel/ui-carousel.js"></script>
@endsection
