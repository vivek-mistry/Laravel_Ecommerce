<div class="col-md-3 mb-5 mb-md-0">
    <ul class="account_sidebar">
        @php
            $account_sidebar_segment = Request::segment(1);
        @endphp
        <li><a href="{{ url('my-account') }}" class="font-18 {{ $account_sidebar_segment === 'my-account' ? 'active' : '' }}">My Account</a></li>
        <li><a href="{{ url('my-orders') }}" class="font-18 {{ $account_sidebar_segment === 'my-orders' ? 'active' : '' }}">My Orders</a></li>
        <li><a href="{{ url('address-book') }}" class="font-18 {{ $account_sidebar_segment === 'address-book' ? 'active' : '' }}">Address Book</a></li>
        <li><a href="{{ url('account-info') }}" class="font-18 {{ $account_sidebar_segment === 'account-info' ? 'active' : '' }}">Account Information</a></li>
        <li><a href="{{ url('sign-out') }}" class="font-18">Sign out</a></li>
    </ul>
</div>