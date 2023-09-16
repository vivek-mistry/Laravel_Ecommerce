
couponDataTable();

function couponDataTable(filters = null)
{
    let end_point = '';
    end_point =BASE_URL + '/backend/coupon/paginate';

    $('#coupon-list').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "ajax": {
            type: "POST",
            url: end_point,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        columnDefs: [{
            render: function (data, type, row) {
                return row.coupon_code;
            },
            targets: 0,
        },
        {
            render: function (data, type, row) {
                return row.coupon_type;
            },
            targets: 1,
        },
        {
            render: function (data, type, row) {
                return row.discount+"("+row.discount_type+")";
            },
            targets: 2,
        },
        {
            render: function (data, type, row) {
                return row.min_order_amount;
            },
            targets: 3,
        },
        {
            render: function (data, type, row) {
                return row.max_discount_amount;
            },
            targets: 4,
        },
        {
            render: function (data, type, row) {
                return row.number_of_time_used;
            },
            targets: 5,
        },
        {
            render: function (data, type, row) {
                let expired_at = `<label class="badge badge-success">`+dispayDateFormat(row.expired_at)+`</label>`;
                if(currentDate() > row.expired_at)
                {
                    expired_at = `<label class="badge badge-danger">`+dispayDateFormat(row.expired_at)+`</label>`;
                }
                
                return expired_at;
            },
            targets: 6,
        },
        {
            render: function (data, type, row) {
                let status = `<label class="badge badge-success">Active</label>`;
                if(!row.is_active)
                {
                    status = `<label class="badge badge-danger">Deactive</label>`;
                }
                return status;
            },
            targets: 7,
        },
        {
            render: function (data, type, row) {

                let edit = BASE_URL + '/backend/coupon/edit/'+ row.id ;
                let remove = BASE_URL + '/backend/coupon/remove/'+ row.id ;
                let action = `<a href="`+edit+`" class="btn btn-sm btn-primary" title="Edit">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="`+remove+`" class="btn btn-sm btn-danger" title="Remove" onclick="return confirm('Are you sure?')">
                    <i class="fa fa-trash"></i>
                </a>`;
                return action;
            },
            targets: 8,
        }
        ],
    });
}
