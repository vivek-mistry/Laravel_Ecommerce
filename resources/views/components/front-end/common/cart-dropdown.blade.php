@forelse ($cart_products as $cart_product)
    <div class="box-wraper border-bottom">
        <div class="p-3 d-flex position-relative">
            <div class="img_wraper">
                <img src="{{ $cart_product->product->product_images[0]->product_image }}" width="80px">
            </div>
            <div class="content_wraper font-12 px-3 pr-0">
                <a href="{{ url('product/detail/'.$cart_product->product_id) }}" class="font-14 font-bold d-inline-block">{{ $cart_product->product->product_name }}</a>
                <p class="font-12">{{ $cart_product->product->brand_name }}</p>
                <div class="prise_wraper mt-2">
                    <p class="font-12"><span class="text-red">USD {{ $cart_product->product->product_sale_price }}</span> <span
                            class="text-decoration-line-through">{{ $cart_product->product->product_price }}</span> (<?= calculateDiscountPercentage($cart_product->product->product_price, $cart_product->product->product_sale_price) ?>% off)</p>
                    <p class="font-12">Offer Price $ {{ $cart_product->product->product_sale_price }}</p>
                </div>
            </div>
            <a href="#" class="close_item" onclick="removeCart({{ $cart_product->id }})"><img src="{{ asset('assets/icons/close.png') }}" alt="cart-full-close"
                    height="10px" width="10px"></a>
        </div>
    </div>
@empty
    <div class="box-wraper border-bottom p-5">
        Cart is empty.
    </div>
@endforelse
