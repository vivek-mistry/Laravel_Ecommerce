@extends('components.front-end.front-end-layout')

@section('contents')
    <div class="container my-5">
        <div class="row py-5">
            @include('components.front-end.common.account-sidebar')
            <div class="col-md-9 px-lg-4 pr-0">
                <h3 class="font-28 font-bold mb-4">Address Book</h3>
                <p class="font-24 mb-3">Default Address</p>
                <div class="row mb-5 pb-lg-4">
                    {{-- <div class="col-md-6 mb-4 mb-lg-0">
                        <p class="font-16 font-bold mb-3">Default Bulling Address</p>
                        <p class="font-14 mb-1">James Smith</p>
                        <p class="font-14 mb-1">Address Line 1 demo</p>
                        <p class="font-14 mb-1">City Name, Armed Forces, Canada, 00990</p>
                        <p class="font-14 mb-1">United States</p>
                        <p class="font-14 mb-3">T: 9928384888</p>
                        <a href="#" class="font-14">Change Bulling Address</a>
                    </div> --}}
                    @include('components.front-end.pages.default-user-address')
                </div>
                <h3 class="font-24 font-bold mb-4">Additional Address Entries</h3>
                @if ($user_addresses->count() == 0)
                    <p class="font-14 mb-4">You have no other address entries in your address book.</p>
                @else
                    <div class="table-responsive">
                        <table id="example" class="table font-18" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user_addresses as $key => $address)
                                    <tr>
                                        <td>{{ $address->full_name }}</td>
                                        <td>{{ $address->email }}</td>
                                        <td>{{ $address->phone_number }}</td>
                                        <td>{{ $address->address }}</td>
                                        <td>{{ $address->city }}</td>
                                        <td>{{ $address->state }}</td>
                                        <td>
                                            <a class="edit-address" data-id="{{ $address->id }}">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            No orders
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
                <button type="button" class="font-bold font-16 site_button" onclick="openModel('save-address-modal')">Add
                    New
                    Address</button>
            </div>
        </div>
    </div>
    @include('components.front-end.popups.create-user-address')
    @include('components.front-end.popups.update-user-address')
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/useraddress.js') }}"></script>
@endsection
