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
            <li class="menu-header">Challenge</li>
            <li class="{{ Request::is('challenges') || Request::is('challenges/create') || Request::is('challenges/*/edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('challenges.index') }}">
                    <i class="fas fa-tasks"></i> <span>Challenge</span>
                </a>
            </li>
            <li class="menu-header">Daily Tasks</li> <!-- Header untuk Daily Tasks -->
            <li class="{{ Request::is('daily_tasks') || Request::is('daily_tasks/create') || Request::is('daily_tasks/*/edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('daily_tasks.index') }}">
                    <i class="fas fa-calendar-check"></i> <span>Daily Task</span> <!-- Ikon untuk Daily Task -->
                </a>
            </li>

        </ul>

    </aside>
</div>
