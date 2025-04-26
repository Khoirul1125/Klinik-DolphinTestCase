
<!-- Sidebar -->
 <div class="sidebar">
    <br>
    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    @php
        $menus = App\Services\MenuService::getUserMenu();
    @endphp
    @php
        use Illuminate\Support\Facades\Auth;
        use App\Models\RoleRedirect;

        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil nama role pertama yang dimiliki user
        $roleName = $user->roles->pluck('name')->first();

        // Ambil route redirect berdasarkan role dari tabel RoleRedirect
        $redirectRoute = RoleRedirect::where('role_id', $roleName)->value('redirect_route') ?? 'dashboard';
    @endphp

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route($redirectRoute) }}"class="nav-link">
                    <i class="fas fa-fw fa-solid fa-hospital" style="color: #63E6BE; font-size: 1.2rem;"></i>
                    <p style="margin-left: 10px;">
                        Dashboard
                    </p>
                </a>
            </li>
            @foreach ($menus as $menu)
                @php
                    $isActive = request()->routeIs($menu->route);
                    $hasActiveChild = $menu->children->contains(fn($submenu) => request()->routeIs($submenu->route) || $submenu->children->contains(fn($subsubmenu) => request()->routeIs($subsubmenu->route)));
                @endphp

                <li class="nav-item {{ $menu->children->isNotEmpty() ? 'has-treeview' : '' }} {{ $isActive || $hasActiveChild ? 'menu-open' : '' }}">
                    <a href="{{ $menu->route ? route($menu->route) : '#' }}" class="nav-link {{ $isActive ? 'active' : '' }}">
                        <i class="fa-fw {{ $menu->icon }}" style="color: #63E6BE; font-size: 1.2rem;"></i>
                        <p style="margin-left: 10px;">
                            {{ $menu->name }}
                            @if ($menu->children->isNotEmpty())
                                <i class="right fas fa-angle-left"></i>
                            @endif
                        </p>
                    </a>

                    @if ($menu->children->isNotEmpty())
                        <ul class="nav nav-treeview">
                            @foreach ($menu->children as $submenu)
                                @php
                                    $isSubActive = request()->routeIs($submenu->route);
                                    $hasSubActiveChild = $submenu->children->contains(fn($subsubmenu) => request()->routeIs($subsubmenu->route));
                                @endphp

                                <li class="nav-item {{ $submenu->children->isNotEmpty() ? 'has-treeview' : '' }} {{ $isSubActive || $hasSubActiveChild ? 'menu-open' : '' }}">
                                    <a href="{{ $submenu->route ? route($submenu->route) : '#' }}" class="nav-link {{ $isSubActive ? 'active' : '' }}">
                                        <i class="fa-fw {{ $submenu->icon }}" style="color: #63E6BE; font-size: 1.2rem;"></i>
                                        <p style="margin-left: 10px;">
                                            {{ $submenu->name }}
                                            @if ($submenu->children->isNotEmpty())
                                                <i class="right fas fa-angle-left"></i>
                                            @endif
                                        </p>
                                    </a>

                                    @if ($submenu->children->isNotEmpty())
                                        <ul class="nav nav-treeview">
                                            @foreach ($submenu->children as $subsubmenu)
                                                @php
                                                    $isSubSubActive = request()->routeIs($subsubmenu->route);
                                                @endphp

                                                <li class="nav-item">
                                                    <a href="{{ $subsubmenu->route ? route($subsubmenu->route) : '#' }}" class="nav-link {{ $isSubSubActive ? 'active' : '' }}">
                                                        <i class="fa-fw {{ $subsubmenu->icon }}" style="color: #63E6BE; font-size: 1.2rem;"></i>
                                                        <p style="margin-left: 10px;">
                                                            {{ $subsubmenu->name }}
                                                        </p>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach



            {{-- user role managemen --}}
            @if(Auth::check() && Auth::user()->hasRole('Super-Admin'))
                <li class="nav-item {{ request()->routeIs('user.role-premesion', 'role', 'permissions') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('user.role-premesion', 'role', 'permissions') ? 'active' : '' }}">
                        <i class="fa-fw fa-solid fa-person-shelter" style="color: #63E6BE; font-size: 1.2rem;"></i>
                        <p style="margin-left: 10px;">
                            User & Role
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.role-premesion') }}" class="nav-link {{ request()->routeIs('user.role-premesion') ? 'active' : '' }}">
                                <i class="fas fa-fw fa-solid fa-person-circle-question" style="color: #63E6BE;"></i>
                                <p style="margin-left: 10px;">User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('role') }}" class="nav-link {{ request()->routeIs('role') ? 'active' : '' }}">
                                <i class="fas fa-fw fa-solid fa-person-circle-exclamation" style="color: #63E6BE;"></i>
                                <p style="margin-left: 10px;">Role</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('permissions') }}" class="nav-link {{ request()->routeIs('permissions') ? 'active' : '' }}">
                                <i class="fas fa-fw fa-solid fa-person-circle-check" style="color: #63E6BE;"></i>
                                <p style="margin-left: 10px;">Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ request()->routeIs('wagateway', 'setweb') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('wagateway', 'setweb') ? 'active' : '' }}">
                        <i class="fa-fw fa-solid fa-screwdriver-wrench" style="color: #63E6BE; font-size: 1.2rem;"></i>
                        <p style="margin-left: 10px;">
                            Setting Aplikasi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('wagateway') }}" class="nav-link {{ request()->routeIs('wagateway') ? 'active' : '' }}">
                                <i class="fas fa-fw fa-cogs"></i>
                                <p style="margin-left: 10px;">Wa Gateway</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('setweb') }}" class="nav-link {{ request()->routeIs('setweb') ? 'active' : '' }}">
                                <i class="fas fa-fw fa-cogs"></i>
                                <p style="margin-left: 10px;">Web Setting</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- <li class="nav-item">
                <form action="{{ route('update.app') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Update Application</button>
                </form>
            </li> --}}
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
