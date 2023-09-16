@extends('components.front-end.front-end-layout')

@section('contents')
    <input type="hidden" id="category_id" value="<?= $category_id ?>" />
    <input type="hidden" id="search_keyword" value="<?= $search ?>" />
    @php
        $category = Cache::get('cache-categories')->find($category_id);
        $navlink = '<a href="'.url('home').'" class="font-14">Home</a><span class="px-3">&gt;</span>';
        if($category)
        {  
            $navlink .='<span class="font-14">'.$category->category_name.'</span>';
        }
        if($search)
        {
            $navlink .='<span class="font-14">Searching for \''.$search.'\'</span>';
        }
    @endphp
    <x-frontend-breadcrumb navlink="{{ $navlink }}"></x-frontend-breadcrumb>
    <div class="container-fluid px-lg-4">
        <div class="row pt-3">
            @include('components.front-end.pages.product-list-sidebar')
            <div class="col-md-9 px-lg-4 pr-0">
                <div class="row most_view_wraper mb-lg-5 product-list">
                    @include('components.front-end.pages.product-card')
                </div>
                <div class="mb-5 pb-lg-5 text-center img-top loading-div">
                    <a href="#" class="site_button font-16 loading-btn font-bold d-inline-block py-4"><img
                            src="{{ asset('assets/icons/Loading.svg') }}" alt="Loading" class="mx-2 ml-0"> LOADING</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('insider-page')
    @include('components.front-end.common.insider-footer')
@endsection
@section('scripts')
    <script>
        "use strict"; 
        var offset = 12; 
        var default_limit = 12;
        const category_id = $("#category_id").val();
        const search_keyword = $("#search_keyword").val();
        ajaxCall(true);
        removeCurrentLoadProductClass();
        productLoader(false);
        function productLoader(param)
        {
            $(".loading-div").show(param);
        }
        function ajaxCall(param)
        {
            $('.product-list').attr('data-ajaxready','');
            if(param)
            {
                $('.product-list').attr('data-ajaxready','1');
            }
            return ;

        }
        function removeCurrentLoadProductClass()
        {
            $(".product-list").find('.current-loaded-products').removeClass("current-loaded-products");
        }
        $(window).scroll(function() {
            if ($(document).height() - $(this).height() - $('.footer_bottom').height() - 400< $(this).scrollTop()) {
                if($('.product-list').attr('data-ajaxready')==1){
                    offset += default_limit;
                    ajaxCall(false);
                    productLoader(true);
                    loadMoreData(offset, default_limit);
                }else{
                    return false;
                }
            }
        });
        function queryStringParameter() {
            let query_string = "?limit="+default_limit+"&offset="+offset+"&category_id="+category_id+"&search="+search_keyword;

            // Product > PRICE Filter
            if($("input[name='price_filter']").prop('checked')){
                query_string += '&price_filter='+$("input[name='price_filter']:checked").val();
            }
            
            return query_string;
        }
        function loadMoreData(offset, default_limit)
        {
            var end_point = FRONTEND_BASEURL + '/product-json'+queryStringParameter();
            
            $.ajax({
                url: end_point,
                type: "GET",
                dataType: 'json',
                success: function(response) {
                    productLoader(false);
                    $(".product-list").append(response.htmldata);
                    if(typeof $(".current-loaded-products")[0] != undefined)
                    {
                        $(".current-loaded-products")[0].scrollIntoView({behavior: "smooth", block: "start", inline: "start"});
                    }
                    offset += default_limit;
                    removeCurrentLoadProductClass();
                    ajaxCall(true);
                }
            });
        }

        $(".product-filter-functionality").on('click', function(){
            offset = 0; 
            default_limit = 12;

            $(".product-list").empty();

            ajaxCall(false);
            productLoader(true);
            loadMoreData(offset, default_limit);
        });
    </script>
@endsection
