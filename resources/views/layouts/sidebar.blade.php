<li class="
    @if(Route::currentRouteName() == "dashboard")
    {{ "nav-item active" }}
    @else {{ "nav-item" }}
    @endif
">
    <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="fas fa-fw fa-home"></i>
        <span>{{ ucfirst("dashboard") }}</span></a>
</li>

@foreach ($global["permission"] as $permission)
@if($permission->menu->is_serialized == 1 && $permission->menu->method == "GET" || $permission->menu->method == "RESOURCE")
<li class="
    @if(Route::currentRouteName() === $permission->menu->route.".index" || Route::currentRouteName() === $permission->menu->route.".create" || Route::currentRouteName() === $permission->menu->route.".edit" || Route::currentRouteName() === $permission->menu->route.".show")
    {{ "nav-item active" }}
    @else {{ "nav-item" }}
    @endif
">
    <a class="nav-link" href="{{ route($permission->menu->route.".index")}}">
        <i class="{{ $permission->menu->icon }}"></i>
        <span>{{ $permission->menu->name }}</span></a>
</li>
@endif
@endforeach

<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

