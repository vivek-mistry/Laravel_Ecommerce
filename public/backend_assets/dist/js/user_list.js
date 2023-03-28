
userDataTable();

function userDataTable(filters = null)
{
    let end_point = '';
    end_point =BASE_URL + '/backend/user/paginate';

    $('#user-list').DataTable({
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
                return row.name;
            },
            targets: 0,
        },
        {
            render: function (data, type, row) {
                return row.email;
            },
            targets: 1,
        },
        {
            render: function (data, type, row) {
                return row.phone_number;
            },
            targets: 2,
        },
        {
            render: function (data, type, row) {

                var edit = BASE_URL + '/backend/user/edit/'+ row.id ;
                var remove = BASE_URL + '/backend/user/remove/'+ row.id ;
                var action = `<a href="`+edit+`" class="btn btn-sm btn-primary" title="Edit">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="`+remove+`" class="btn btn-sm btn-danger" title="Remove" onclick="return confirm('Are you sure?')">
                    <i class="fa fa-trash"></i>
                </a>`;
                return action;
            },
            targets: 3,
        }
        ],
    });
}
