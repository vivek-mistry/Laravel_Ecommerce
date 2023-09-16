
orderDataTable();

function orderDataTable(filters = null)
{
    let end_point = '';
    end_point =BASE_URL + '/backend/order/paginate';

    $('#order-list').DataTable({
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
                return row.order_number;
            },
            targets: 0,
        },
        {
            render: function (data, type, row) {
                return row.net_amount;
            },
            targets: 1,
        },
        {
            render: function (data, type, row) {
                return row.current_order_status != null ? row.current_order_status.status  : '---';
            },
            targets: 2,
        },
        {
            render: function (data, type, row) {
                return dispayDateFormat(row.created_at);
            },
            targets: 3,
        }
        ],
    });
}
