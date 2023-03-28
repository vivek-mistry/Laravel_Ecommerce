function checkAuthenticate() {
    var end_point = FRONTEND_BASEURL + '/check-auth';
    var is_auth = true;
    $.ajax({
        url: end_point,
        type: "GET",
        dataType: 'json',
        async: false,
        success: function (response) {
            if (!response.is_login) {
                is_auth = false;
                openSnackBar('Need to Login');
            }
        }
    });
    return is_auth;
}
$(".add-to-cart").on('click', function () {
    var is_auth = checkAuthenticate();
    if (is_auth === true) {
        var end_point = FRONTEND_BASEURL + '/cart';
        var cart = {};
        cart.product_id = $('#product_id').val();
        cart.price = $('#product_price').val();
        cart.quantity =  $('#quantity').val();

        $.ajax({
            url: end_point,
            type: "POST",
            data: cart,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (!response.status) {
                    openSnackBar(response.message);

                } else {
                    openSnackBar('Added to cart');
                    getUserCarts();
                }

            }
        });
    }
});
getUserCarts();
function getUserCarts() {
    var end_point = FRONTEND_BASEURL + '/cart';
    $.ajax({
        url: end_point,
        type: "GET",
        dataType: 'json',
        async: false,
        success: function (response) {
            $(".cart_items_wraper").html(response.html_view);
            $(".cart-counter").text(response.cart_counter);
            $(".total_actual_price").text(response.total_actual_price);
            $(".total_sale_price").text("$"+response.total_sale_price);
        }
    });
}

function removeCart(cart_id, element = null)
{
    var end_point = FRONTEND_BASEURL + '/cart/'+cart_id;
    $.ajax({
        url: end_point,
        type: "GET",
        dataType: 'json',
        async: false,
        success: function (response) {
            openSnackBar('Item Removed From Cart');
            if(element)
            {
                location.reload();
            }
            getUserCarts();
        }
    });
}

function updateCartQuanity()
{
    var end_point = FRONTEND_BASEURL + '/cart';
    var cart = {};
    cart.product_id = $('#product_id').val();
    cart.quantity =  $('#quantity').val();
    $.ajax({
        url: end_point,
        type: "PUT",
        data: cart,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status) {
                getUserCarts();
            }

        }
    });
}

$(".quantity-minus").on('click', function(){
    var quantity = $("#quantity").val();
    if(quantity > 1)
    {
        quantity = parseInt(quantity) - 1;
        $("#quantity").val(quantity);
        updateCartQuanity();
    }else{
        openSnackBar("Minimum 1 quantity required")
    }
});

$(".quantity-plus").on('click', function(){
    var quantity = $("#quantity").val();
    if(quantity < 5)
    {
        quantity = parseInt(quantity) + 1;
        $("#quantity").val(quantity);
        updateCartQuanity();
    }else{
        openSnackBar("Can not add more than 5 quantity")
    }
});
