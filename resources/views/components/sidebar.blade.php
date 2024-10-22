<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class='{{ Request::is('dashboard') ? 'active' : '' }}'>
                <a class="nav-link"
                    href="{{ url('dashboard') }}"><i class="fas fa-dashboard">
                    </i> <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Girly Pedia</li>
            <li class='{{ Request::is('girlyPedia') ? 'active' : '' }}'>
                <a class="nav-link"
                    href="{{ url('girlyPedia') }}"><i class="fas fa-users">
                    </i> <span>Girly Pedia</span>
                </a>
            </li>
            <li class="menu-header">Podcast</li>
            <li class="{{ Request::is('podcasts') || Request::is('podcasts/create') || Request::is('podcasts/*/edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('podcasts.index') }}">
                    <i class="fas fa-podcast"></i> <span>Podcast</span>
                </a>
            </li>

        </ul>

    </aside>
</div>
