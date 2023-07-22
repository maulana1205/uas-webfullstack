<aside class="main-sidebar sidebar-light-primary elevation-4">
    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/img/admin1.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="/" class="d-block">{{ session()->get('username') }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ ($sub == "Dashboard") ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p class="text">Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/input_data" class="nav-link {{ ($sub == "Input Data") ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p class="text">Input Data</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/logout" class="nav-link {{ ($sub == "Input Data") ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p class="text">Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
