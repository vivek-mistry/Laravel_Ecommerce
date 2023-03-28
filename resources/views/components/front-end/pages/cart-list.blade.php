@extends('components.front-end.front-end-layout')

@section('contents')
@if ($total_sale_price)
<div class="container">
	<div class="row my-5">
        <div class="col-lg-8 mb-5 mb-lg-0">
            <div class="cart_product_details_area">
                <h2 class="font-bold font-24">Shopping Cart</h2>
                @foreach ($cart as $key => $cart_product)
                    <div class="single_cart_full_product">
                        <div class="row">
                            <div class="col-md-2 col-sm-3 col-xs-3 mobile_cart_full_img">
                                <div class="cart_full_img">
                                    <img src="{{ $cart_product->product->product_images[0]->product_image }}" width="100%" alt="photo">
                                </div>
                            </div>
                            <div class="col-md-10 col-sm-9 col-xs-9 mobile_cart_full_details">
                                <div class="cart_full_top_area">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="cart_full_product">
                                                <div class="cart-text">
                                                    <a href="{{ url('product/detail/'.$cart_product->product_id) }}" class="font-14 font-bold d-inline-block">{{ $cart_product->product->product_name }}</a>
                                                    <p class="font-14">{{ $cart_product->product->brand_name .' - '.$cart_product->product->color_name }} </p>
                                                    <div class="prise_wraper mt-2">
                                                        <p class="font-14"><span class="text-red">USD {{ $cart_product->product->product_sale_price }}</span> <span class="text-decoration-line-through">{{ $cart_product->product->product_price }}</span> ({{ calculateDiscountPercentage($cart_product->product->product_price, $cart_product->product->product_sale_price) }}% off)</p>
                                                        <p class="font-14">Offer Price $ {{ $cart_product->product->product_sale_price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="cart_full_quantity">
                                                <div class="btn-wrapper d-flex align-items-center mb-4 Quantity-wraper">
                                                    <span class="font-14 font-bold">Qty: <input type="text" min="1" value="{{ $cart_product->quantity }}" max="404" id="qty" class="input-number input-quantity"></span> 
                                                    <button type="button" data-type="minus" class="btn btn-number btn-minus ml-0"> - </button>
                                                    <button type="button" data-type="plus" class="btn btn-number btn-plus"> + </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="cart_full_product_price">
                                                <p class="text-red">${{ $cart_product->total_price }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="cart_full_close">
                                                <a onclick="removeCart({{$cart_product->id}}, this)"><img src="{{ asset('assets/icons/close.png') }}" alt="cart-full-close"></a>
                                            </div>
                                            <div class="cart_full_edit">
                                                <a href="#">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart_full_bottom_area">
                                    <div class="row">
                                        <div class="cart_full_radio">
                                            <div class="remember d-flex mb-2">
                                                <input type="radio" name="" id="remem">
                                                <label for="remem"><p class="set_as mx-2 mr-0">
                                                    <span>Ship it to <a href="#" class="text-decoration-underline"> Enter Zip</a></span>
                                                    <span class="font-12 d-block">In stock: Usually ships within 2 business days.</span>
                                                </p></label>
                                            </div>
                                            <div class="remember d-flex mb-3">
                                                <input type="radio" name="" id="remem2">
                                                <label for="remem2"><p class="set_as mx-2 mr-0">
                                                    <span>Pick Up <a href="#" class="text-decoration-underline"> Find Store</a></span>
                                                </p></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                @endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <div class="order_summery_area">
                <div class="order_details" id="orderpd">
                    <h3>ORDER SUMMARY</h3>
                    <div class="order_text d-flex justify-content-between">
                        <p>Subtotal</p>
                        <p>${{ $total_sale_price }}</p>
                    </div>
                    <div class="order_text d-flex justify-content-between">
                        <p>Shipping</p>
                        <p>FREE</p>
                    </div>
                    <div class="order_text d-flex justify-content-between">
                        <p>Sales Tax</p>
                        <p>$0.00</p>
                    </div>
                </div>
                <div class="order_total d-flex justify-content-between">
                    <h3>Order Total</h3>
                    <h3 class="text-red">${{ $total_sale_price }}</h3>
                </div>
                {{-- <div class="order_promo_code_box mb-5">
                    <form action="" method="">
                        <input type="text" class="pro_code" name="" placeholder="Promo Code">
                        <input type="Submit" class="pro_btn" name="" value="Apply">
                    </form>
                </div> --}}

                <a href="{{ url('checkout') }}" class="submit d-md-block d-none site_button font-bold font-18 w-100 py-3 text-center" id="nextBtn">CHECKOUT</a>

                <div class="check_pr_btn_back_text fix-mobile-bottom py-3 d-md-none px-3 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-red font-16 font-bold">$3,351.25</p>
                        <a href="#orderpd">View Price Details<i class="fas fa-chevron-up px-2 pr-0"></i></a>
                    </div>
                    <button type="button" class="submit d-block site_button font-bold">Checkout</button>
                </div>
            </div>
        </div>
	</div>
</div>
@else
<div class="container">
	<div class="row my-5 py-lg-5">
        <div class="col-md-6 offset-md-3 text-center">
            @if (Auth::user())
                <h3 class="font-32 font-bold mb-2 text-uppercase">Hi! Your Shopping Bag is empty.</h3>    
                <a href="{{ url('home') }}" class="outline_button font-bold font-18 py-3 text-uppercase d-block mt-5 mb-3">Continue Shopping</a>
            @else
                <p class="font-18 mb-5">Have saved items? Sign in to see them.</p>
                <a href="{{ url('home') }}" class="outline_button font-bold font-18 py-3 text-uppercase d-block mt-5 mb-3">Continue Shopping</a>
                <a href="{{ url('sign-in') }}" class="site_button font-bold font-18 py-3 text-uppercase d-block my-4">Sign In</a>
                
                <div class="text-center mb-5">
                    <a href="#" class="text-decoration-underline font-14">See Deals & Promotions</a>
                </div>
                <div class="text-center">
                    <p class="font-18 font-bold text-uppercase mb-3">Continue with</p>
                    <ul class="d-flex justify-content-center align-items-center mb-5">
                        <li><a href="#"><img src="{{ asset('assets/icons/Google.svg') }}" width="40px" height="40px"></a></li>
                        <li><a href="#" class="mx-3"><img src="{{ asset('assets/icons/Facebook.svg') }}" width="40px" height="40px"></a></li>
                        <li><a href="#"><img src="{{ asset('assets/icons/Instagram.svg') }}" width="40px" height="40px"></a></li>
                        <li class="mx-3"><a href="#"><img src="{{ asset('assets/icons/linkedin.svg') }}" width="40px" height="40px"></a></li>
                        <li><a href="#"><img src="{{ asset('assets/icons/Twitter.svg') }}" width="40px" height="40px"></a></li>
                    </ul>
                    <a href="#" class="font-14 text-decoration-underline">Terms & Conditions</a>
                </div>
            @endif
            
			
        </div>
    </div>
</div>  
@endif
@endsection
@section('insider-page')
    @include('components.front-end.common.insider-footer')
@endsection