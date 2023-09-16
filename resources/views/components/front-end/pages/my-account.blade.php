@extends('components.front-end.front-end-layout')

@section('contents')
    <div class="container my-5">
        <div class="row py-5">
            @include('components.front-end.common.account-sidebar')
            <div class="col-md-9 px-lg-4 pr-0">
                <h3 class="font-28 font-bold mb-4">My Account</h3>
                <p class="font-24 mb-4">Account Information</p>
                <p class="font-18 font-bold mb-3">Contact Information</p>
                <p class="font-18 mb-2">{{ $user->name }}</p>
                <p class="font-18 mb-2">{{ $user->email }}</p>
                <a href="{{ url('account-info') }}" class="font-18">Edit </a>
                <a href="{{ url('change-password') }}" class="font-18">Change Password </a>
                <div class="row mt-5 mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center flex-wrap justify-content-between">
                            <p class="font-24 mb-3 mb-md-0">Address Book</p>
                            <a href="{{ url('address-book') }}" class="font-18">Manage Addresses</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-md-6 mb-4 mb-md-0">
                        <p class="font-18 font-bold mb-2">Default Billing Address</p>
                        <p class="font-18 mb-2">You have not set a default billing address.</p>
                        <a href="#" class="font-18">Edit Address</a>
                    </div> --}}
                    @include('components.front-end.pages.default-user-address')
                </div>
            </div>
        </div>
    </div>
    @include('components.front-end.popups.update-user-address')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/useraddress.js') }}"></script>
@endsection
