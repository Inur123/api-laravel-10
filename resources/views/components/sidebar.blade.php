<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="dashboard" class="d-flex align-items-center">
                <img src="{{ asset('img/logo1.svg') }}" alt="Logo" style="width: 50px; height: auto;"
                    class="sidebar-logo mr-2" />
                ADMIN
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html" class="d-flex align-items-center">
                <img src="{{ asset('img/logo1.svg') }}" alt="Logo"
                    style="width: 50px; height: class="sidebar-logo" />

            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class='{{ Request::is('dashboard') ? 'active' : '' }}'>
                <a class="nav-link" href="{{ url('dashboard') }}"><i class="fas fa-dashboard">
                    </i> <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Girly Pedia</li>
            <li
                class="{{ Request::is('girlyPedia') || Request::is('girlyPedia/create') || Request::is('girlyPedia/*/edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('girlyPedia.index') }}">
                    <i class="fas fa-female"></i> <span>Girly Pedia</span>
                </a>
            </li>

            <li class="menu-header">Podcast</li>
            <li
                class="{{ Request::is('podcasts') || Request::is('podcasts/create') || Request::is('podcasts/*/edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('podcasts.index') }}">
                    <i class="fas fa-podcast"></i> <span>Podcast</span>
                </a>
            </li>

        </ul>

    </aside>
</div>
