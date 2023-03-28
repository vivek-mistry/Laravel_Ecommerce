$(".edit-address").on("click", function () {
    var end_point = FRONTEND_BASEURL + '/user-address/' + $(this).data('id');
    $.ajax({
        url: end_point,
        type: "GET",
        dataType: 'json',
        async: false,
        success: function (response) {
            $("#full_name").val(response.full_name);
            $("#email").val(response.email);
            $("#phone_number").val(response.phone_number);
            $("#address").val(response.address);
            $("#city").val(response.city);
            $("#state").val(response.state);
            $("#pin_code").val(response.pin_code);
            if(response.is_default == 1)
            {
                $("#update_is_default_div").hide();
            }else{
                $("#update_is_default_div").show();
            }
            $("#formUserAddressUpdate").attr('action', end_point);
            openModel('update-address-modal');
        }
    });
});
