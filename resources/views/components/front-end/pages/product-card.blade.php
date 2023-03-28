@foreach ($product_list as $key => $product)
    <div class="col-6 col-md-4 col-xl-3 mb-5 current-loaded-products {{ $product->id }}">
        <div class="img_wraper mb-3">
            <img src="{{ $product->product_images[0]->product_image }}">
        </div>
        <a href="{{ url('product/detail/'.$product->id) }}" class="font-14 font-bold d-inline-block"><?= $product->product_name ?></a>
        <p class="font-14"><?= $product->brand_name ?> - <?= $product->color_name ?></p>
        <div class="prise_wraper mt-2">
            <p class="font-14"><span class="text-red">USD <?= $product->product_sale_price ?></span> <span
                    class="text-decoration-line-through"><?= $product->product_price ?></span> (<?= calculateDiscountPercentage($product->product_price, $product->product_sale_price) ?>% off)</p>
            <p class="font-14">Offer Price $<?= $product->product_sale_price ?></p>
        </div>
    </div>
@endforeach
