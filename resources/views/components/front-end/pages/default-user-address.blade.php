<div class="col-md-6">
    <p class="font-18 font-bold mb-2">Default Shipping Address</p>
    @if (isset($user_default_address->id))
        <p class="font-18 mb-2">{{ $user_default_address->full_name }} ({{ $user_default_address->email }}) ({{ $user_default_address->phone_number }})</p>
        <p class="font-18 mb-2">{{ $user_default_address->address. ', ' .  $user_default_address->state . ', '. $user_default_address->city. ' - '. $user_default_address->pin_code}}</p>
        {{-- <p class="font-18 mb-2">{{ $user_default_address->state }}</p>
        <p class="font-18 mb-2">{{ $user_default_address->city }}</p> --}}
        <a class="font-18 edit-address" data-id="{{ $user_default_address->id }}">Edit Address</a>
    @else
        <p class="font-18 mb-2 edit-address" >You have not set a default billing address.</p>
    @endif
</div>