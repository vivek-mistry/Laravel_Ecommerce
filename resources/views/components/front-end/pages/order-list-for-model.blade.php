@forelse ($order->items as $item)
    <div class="box-wraper border-bottom">
        <div class="p-3 d-flex position-relative">
            <div class="img_wraper">
                <img src="{{ $item->product->product_images[0]->product_image }}" width="80px">
            </div>
            <div class="content_wraper font-12 px-3 pr-0">
                <a href="{{ url('product/detail/'.$item->product_id) }}" class="font-14 font-bold d-inline-block">{{ $item->product->product_name }}</a>
                <p class="font-12">{{ $item->product->brand_name }}</p>
                <div class="prise_wraper mt-2">
                    <p class="font-12"><span class="text-red">USD {{ $item->product->product_sale_price }}</span> <span
                            class="text-decoration-line-through">{{ $item->product->product_price }}</span> (<?= calculateDiscountPercentage($item->product->product_price, $item->product->product_sale_price) ?>% off)</p>
                    <p class="font-12">Offer Price $ {{ $item->product->product_sale_price }}</p>
                </div>
            </div>
            
        </div>
    </div>
@empty
    <div class="box-wraper border-bottom p-5">
        Order is empty.
    </div>
@endforelse