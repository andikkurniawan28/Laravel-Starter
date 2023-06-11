<li class="nav-item">
    <a class="nav-link" href="{{  route('dashboard') }}">
        <i class="fas fa-fw fa-home"></i>
        <span>{{ ucfirst("dashboard") }}</span></a>
</li>

@foreach ($global["permission"] as $permission)
<li class="nav-item">
    <a class="nav-link" href="{{ route($permission->menu->route) }}">
        <i class="fas fa-fw fa-{{ $permission->menu->icon }}"></i>
        <span>{{ $permission->menu->name }}</span></a>
</li>
@endforeach

<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

