<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- End CSRF Token -->

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

    <!-- font awesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

    <!-- owl carousel -->
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <script type="text/javascript" src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>

    <link rel="stylesheet" href="https://icodefy.com/Tools/iZoom/css/zoom.css">

    <!-- Main Css -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">

    <!-- Snackbar -->
    {{-- <link href="{{ asset('assets/snackbar/css/materialize.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('assets/snackbar/css/snackbar.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/snackbar/css/prism.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/snackbar/css/style.css') }}" rel="stylesheet"> --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js-bootstrap-css/1.2.1/typeaheadjs.css"
        rel="stylesheet">

    @yield('styles')
</head>

<body>
    {{-- <div class="container-fluid">
        <div class="spinner-border text-danger"
            role="status" style="align-items: center;
            justify-content: center;
            left: 50%;
            position: fixed;
            top: 50%;
            transition: opacity 0.3s linear;
            
            z-index: 9999;">
            <span class="sr-only">Loading...</span>
        </div>
    </div> --}}

    <div class="fima-content-wrapper">
        <div class="fima-page-loader spinner-border text-danger" role="status"
            style="align-items: center; justify-content: center; left: 50%; position: fixed; margin: -1em;top: 50%; transition: opacity 0.3s linear;z-index: 9999;">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="d-none fima-content">
            @include ('components/front-end/common/header')
            <input type="hidden" id="base_url" value="{{ url('') }}">
            @yield('contents')

            @include ('components/front-end/common/footer')
        </div>
    </div>


</body>
<script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/snackbar/js/modernizr.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/snackbar/js/materialize.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/snackbar/js/prism.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/snackbar/js/snackbar.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/snackbar/js/init.js') }}"></script>

<!--FIMA JS -->
<script type="text/javascript" src="{{ asset('assets/js/fima.js') }}"></script>

<!-- Cart JS -->
<script type="text/javascript" src="{{ asset('assets/js/cart.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.jquery.min.js">
</script>
<script type="text/javascript" src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js">
</script>
@yield('scripts')

<script>
    var products = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: FRONTEND_BASEURL + '/product-search?search=%QUERY',
            wildcard: '%QUERY'
        }
    });
    products.initialize();
    $('#search_product').typeahead(null, {
        name: 'products',
        display: 'value',
        source: products,
        templates: {
            header: function(response) {
                result = `<div class="box-wraper border-bottom">
                        <div class="p-3 d-flex position-relative">
                            <div class="content_wraper font-12 px-3 pr-0">
                                <a href="` + FRONTEND_BASEURL + `/product?search=` + response.query +
                    `" class="font-14 font-bold d-inline-block">Searching for '` + response.query + `'</a>
                            </div>
                        </div>
                    </div>`;
                return result;
            },
            empty: function(response) {
                result = `<div class="box-wraper border-bottom">
                        <div class="p-3 d-flex position-relative">
                            <div class="content_wraper font-12 px-3 pr-0">
                                <a href="` + FRONTEND_BASEURL +
                    `" class="font-14 font-bold d-inline-block">Looking for ` + response.query + `</a>
                            </div>
                        </div>
                    </div>`;
                return result;
            },
            suggestion: function(response) {

                result = `<div class="box-wraper border-bottom">
                        <div class="p-3 d-flex position-relative">
                            <div class="img_wraper">
                                <img src="` + response.product_images[0].product_image + `" width="80px">
                            </div>
                            <div class="content_wraper font-12 px-3 pr-0">
                                <a href="` + FRONTEND_BASEURL + `/product/detail/` + response.id +
                    `" class="font-14 font-bold d-inline-block">` + response.product_name + `</a>
                                <p class="font-12">` + response.brand_name + `</p>
                                
                            </div>
                           
                        </div>
                    </div>`;
                return result;
            }
        }
    });
</script>

</html>
