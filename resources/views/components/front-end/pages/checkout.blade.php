@extends('components.front-end.front-end-layout')

@section('contents')
    <section class="checkout_wrapper_area">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-xl-10 offset-xl-1 offset-md-1">
                    <div class="checkout_area">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="checkout_left_side_area">
                                    <!-- Circles which indicates the steps of the form: -->
                                    {{-- <div class="mb-4">
                                        <ul id="progressbar">
                                            <li class="step"></li>
                                            <li class="step"></li>
                                            <li class="step"></li>
                                        </ul>
                                    </div> --}}
                                    <div class="checkout_first_step">
                                        <h2>
                                            {{-- <span>1</span> --}}
                                            Shipping & Gift Options
                                        </h2>
                                        @include('components.front-end.pages.default-user-address')
                                        @if (!isset($user_default_address->id))
                                            <button type="button" class="font-bold font-16 site_button"
                                                onclick="openModel('save-address-modal')">Add
                                                New
                                                Address</button>
                                            <br /> <br />
                                        @endif
                                        @if ($coupons->count() > 0)
                                            <h2>
                                                {{-- <span>2</span> --}}
                                                COUPON Options
                                            </h2>
                                            <div class="payment_items align-items-center">
                                                <div class="table-responsive">
                                                    <table id="example" class="table font-18">
                                                        <thead>
                                                            <tr>
                                                                <th>COUPON</th>
                                                                <th>Description</th>
                                                                <th>ACTION</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($coupons as $key => $coupon)
                                                                <tr>
                                                                    <td>{{ $coupon->coupon_code }}</td>
                                                                    <td>{{ $coupon->description }}</td>
                                                                    <td>
                                                                        <a class="apply_coupon"
                                                                            data-id="{{ $coupon->id }}">
                                                                            APPLY
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif

                                        <h2>
                                            {{-- <span>3</span> --}}
                                            PAYMENT Options
                                        </h2>
                                        <div class="payment_items d-flex align-items-center">
                                            <div class="single_payment_opt">
                                                <div class="remember d-flex align-items-center">
                                                    <input type="radio" name="payment" id="stripe" class="mx-2 ml-0"
                                                        required="required">
                                                    <label for="ctext-redit">
                                                        <p>Stripe</p>
                                                    </label>
                                                </div>
                                            </div>
                                            {{-- <div class="single_payment_opt">
                                                <div class="remember d-flex align-items-center">
                                                    <input type="radio" name="payment" id="paypal" class="mx-2 ml-0"
                                                        required="required">
                                                    <label for="paypal">
                                                        <p>PayPal</p>
                                                    </label>
                                                </div>
                                            </div> --}}
                                            <div class="single_payment_opt">
                                                <div class="remember d-flex align-items-center">
                                                    <input type="radio" name="payment" id="cash_on_delivery"
                                                        class="mx-2 ml-0" required="required">
                                                    <label for="pay_late">
                                                        <p>Cash on Delivery</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        @if (isset($user_default_address->id))
                                            <a class="submit site_button font-bold btn-checkout">
                                                Checkout
                                                {{--  {{ url('make-checkout') }} --}}
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="checkout_right_side_area">
                                    <div class="order_details" id="orderdm">
                                        <h3><span><i class="fas fa-check"></i></span>ORDER SUMMARY</h3>
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
                                        <div class="order_text d-flex justify-content-between">
                                            <p>Coupon Discount</p>
                                            <p id="coupon_discount_amount">$0.00</p>
                                            <input type="hidden" id="applied_coupon_id" value="" />
                                        </div>
                                    </div>
                                    <div class="order_total d-flex justify-content-between">
                                        <h3>Order Total</h3>
                                        <h3 class="text-red" id="total_order_amount">${{ $total_sale_price }}</h3>
                                    </div>
                                    {{-- <div class="order_promo_code_box">
                                        <form action="" method="" check_input_wrap>
                                            <input type="text" class="pro_code" name="" placeholder="Promo Code">
                                            <input type="Submit" class="pro_btn" name="" value="Apply">
                                        </form>
                                    </div> --}}
                                    <div class="order_reveiw_area">
                                        {{-- <div class="d-flex justify-content-between align-items-center">
                                            <h3>Order Review</h3>
                                            <a href="#" class="text-decoration-underline font-14">Edit</a>
                                        </div> --}}
                                        @foreach ($cart as $key => $cart_product)
                                            <div class="cart-popup_box d-flex">
                                                <div class="cart-popup_img">
                                                    <a href="#"><img
                                                            src="{{ $cart_product->product->product_images[0]->product_image }}"
                                                            alt="image"></a>
                                                </div>
                                                <div class="cart-text">
                                                    <a href="#"
                                                        class="font-14 font-bold d-inline-block">{{ $cart_product->product->product_name }}</a>
                                                    <p class="font-14">
                                                        {{ $cart_product->product->brand_name . ' - ' . $cart_product->product->color_name }}
                                                    </p>
                                                    <div class="prise_wraper mt-2">
                                                        <p class="font-14"><span class="text-red">USD
                                                                {{ $cart_product->product->product_sale_price }}</span>
                                                            <span
                                                                class="text-decoration-line-through">{{ $cart_product->product->product_price }}</span>
                                                            ({{ calculateDiscountPercentage($cart_product->product->product_price, $cart_product->product->product_sale_price) }}%
                                                            off)
                                                        </p>
                                                        <p class="font-14">Offer Price $
                                                            {{ $cart_product->product->product_sale_price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('components.front-end.popups.create-user-address')
    @include('components.front-end.popups.update-user-address')
@endsection
@section('insider-page')
    @include('components.front-end.common.insider-footer')
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/useraddress.js') }}"></script>
    <script type="text/javascript">
        function getCheckOutQueryString()
        {
            return '?applied_coupon_id='+$("#applied_coupon_id").val();
        }
        $(".btn-checkout").on('click', function() {
            /**
             * Check Radio click and Manage redirection
             */
            if ($("#stripe").prop("checked")) {
                window.location.href = FRONTEND_BASEURL + '/stripe-checkout'+getCheckOutQueryString();
            } else if ($("#cash_on_delivery").prop("checked")) {
                window.location.href = FRONTEND_BASEURL + '/make-checkout'+getCheckOutQueryString();
            } else {
                openSnackBar("Please Choose Payment Option");
            }
        });
        $(".apply_coupon").on('click', function() {
            // openSnackBar("Successfully applied coupon");
            let coupon_id = $(this).data('id');
            // let post_data = {};
            let endpoint = FRONTEND_BASEURL + '/coupon/apply/'+coupon_id;
            console.log("endpoint => ", endpoint);
            $.ajax({
                url: endpoint,
                type: "POST",
                // data: post_data,
                dataType: 'json',
                content: this,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.status === true)
                    {
                        $("#coupon_discount_amount").text(response.total_discount);
                        $("#total_order_amount").text(response.pay_amount);
                        $("#applied_coupon_id").val(coupon_id);
                    }
                    openSnackBar(response.message);
                }
            });

        });
    </script>
@endsection
