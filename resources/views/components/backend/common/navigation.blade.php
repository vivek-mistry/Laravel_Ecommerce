@php
$current_route = Illuminate\Support\Facades\Request::segment(2);
@endphp
<li class="nav-item">
    <a href="{{ $routes }}" class="nav-link {{ $current_route == $activeRoute ? 'active' : null }}">
        <i class="nav-icon fas {{$faClass}}"></i>
        <p>
            {{ $menuTitle }}
        </p>
    </a>
</li>
