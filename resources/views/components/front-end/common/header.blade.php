<header>
    <div class="top_bar py-2 bg-black text-center">
        <p class="font-14 font-bold font-14 text-white">Free Shipping on EVERYTHING!* <a href="#" class="text-white font-14 text-decoration-underline">Details</a></p>
    </div>
    <div class="header_bottom py-3">
        <div class="px-2 px-lg-4">
            <div class="row align-items-center">
                <div class="col-xl-3 text-center text-xl-start">
                    <a href="{{ url('home') }}" class="main-logo">
                        <img src="{{ asset('assets/icons/logo.svg') }}">
                        {{-- <h1>FIMA</h1> --}}
                    </a>
                </div>
                <div class="col-xl-6 my-3 my-xl-0">
                    <form class="header_search_form position-relative d-flex align-items-center" method="GET" action="{{ url('product') }}">
                        <input type="search" name="search" placeholder="Everything you find ships for free" class="font-18 typeahead" id="search_product">
                        <div class="search_btn_wraper position-relative d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" id="Group_1" data-name="Group 1" width="15.621" height="15.618" viewBox="0 0 15.621 15.618">
                                <g id="Group_953" data-name="Group 953">
                                    <path id="Path_1769" data-name="Path 1769" d="M62.424,121.121a6.212,6.212,0,1,1,4.392-10.6h0a6.212,6.212,0,0,1-4.392,10.6Zm0-11.1a4.885,4.885,0,0,0-3.456,8.34,5,5,0,0,0,6.911,0,4.884,4.884,0,0,0-3.455-8.34Z" transform="translate(-56.211 -108.7)" fill="#fff" />
                                </g>
                                <g id="Group_954" data-name="Group 954" transform="translate(10.86 10.856)">
                                    <path id="Path_1770" data-name="Path 1770" d="M68.5,121.653a.66.66,0,0,1-.468-.193L64.6,118.023a.663.663,0,0,1,.937-.937l3.436,3.436a.662.662,0,0,1-.469,1.13Z" transform="translate(-64.406 -116.891)" fill="#fff" />
                                </g>
                            </svg>
                            <input type="submit" class="search_btn font-18" name="" value="Search">
                        </div>
                    </form>
                </div>
                <div class="col-xl-3 header_right">
                    <div class="d-flex align-items-center justify-content-center justify-content-xl-end">
                        <img src="{{ asset('assets/icons/Logo.png') }}" width="49px">
                        <div class="icon_wraper mx-4 mr-0">
                            @php
                                $account_url = url("sign-in");
                                if(Auth::user())
                                {
                                    $account_url = url('my-account');
                                }
                            @endphp
                            <a href="{{$account_url}}" class="d-flex flex-column align-items-center">
                                <img src="{{ asset('assets/icons/Account.svg') }}" height="22px" width="22px">
                                <span class="font-14 pt-1">Account</span>
                            </a>
                        </div>
                        <div class="icon_wraper mx-4">
                            <a href="#" class="d-flex flex-column align-items-center">
                                <img src="{{ asset('assets/icons/Notification.svg') }}" height="22px" width="22px">
                                <span class="font-14 pt-1">Notification</span>
                            </a>
                        </div>
                        <div class="icon_wraper cart-notify position-relative">
                            <a href="#" class="d-flex flex-column align-items-center position-relative">
                                <img src="{{ asset('assets/icons/Cart.svg') }}" height="25px" width="25px">
                                <span class="font-14 pt-1">Cart</span>
                                <span class="counter cart-counter">00</span>
                            </a>
                            <div class="cart_popup_wraper">
                                <div class="cart_items_wraper">
                                    <?php
                                    $cart_products = [];//getUserCart()
                                    ?>
                                    @include('components.front-end.common.cart-dropdown', ['cart_products' => $cart_products])
                                </div>
                                <div class="action_wraper p-3 border-top">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <p class="font-16 font-bold">Estimate Total</p>
                                        <p class="font-16 font-bold"><span class="text-red total_sale_price">$1675.00</span> <span class="text-decoration-line-through total_actual_price">1880.00</span></p>
                                    </div>
                                    <a href="{{url('cart-list')}}" class="site_button font-14 font-bold text-uppercase d-block text-center py-2">View Cart & Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include ('components.front-end.common.header-menu')
</header>
