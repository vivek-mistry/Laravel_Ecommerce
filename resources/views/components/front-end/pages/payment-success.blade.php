@extends('components.front-end.front-end-layout')

@section('contents')
    <div class="container">
        <div class="row my-5 py-lg-5">
            <div class="col-md-6 offset-md-3 text-center">
                <h3 class="font-32 font-bold mb-2 text-uppercase">Payment Success</h3>
                <a href="{{ url('home') }}" class="outline_button font-bold font-18 py-3 text-uppercase d-block mt-5 mb-3">Continue Shopping</a>
                


            </div>
        </div>
    </div>
@endsection
@section('insider-page')
    @include('components.front-end.common.insider-footer')
@endsection
