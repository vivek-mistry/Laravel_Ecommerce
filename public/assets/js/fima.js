const FRONTEND_BASEURL = $("#base_url").val();

function openModel(id) {
    $("#" + id).modal('show');
}

function openSnackBar(message) {
    return Snackbar.show({
        text: message,
        width: '475px',
        onActionClick: function (element) {
            $(element).css('opacity', 0);
        }
    });
}

function loadPageLoader() {
    $(".fima-page-loader").show();
    $(".fima-content").addClass('d-none');
}

function removePageLoader() {
    $(".fima-content").removeClass('d-none');
    $(".fima-page-loader").hide();
}

/**
 * Manage Page loader
 */
$(document).ready(function () {
    removePageLoader();
});
