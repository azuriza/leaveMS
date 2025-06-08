<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->is('adminhr/dashboard') ? 'active' : '' }}"
                    href="{{ url('adminhr/dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed {{ request()->is('adminhr/applyleave') || request()->is('adminhr/applyleaveself') || request()->is('adminhr/add/applyleave') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="false"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Applied Leave
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('adminhr/applyleave') || request()->is('adminhr/applyleaveself') || request()->is('adminhr/add/applyleave') ? 'show' : '' }}"
                    id="collapse" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('adminhr/applyleave') ? 'active' : '' }}"
                            href="{{ url('adminhr/applyleave')}}">View Employee Sick/Compassionate</a>
                        <a class="nav-link {{ request()->is('adminhr/applyleaveself') ? 'active' : '' }}"
                            href="{{ url('adminhr/applyleaveself')}}">View Employee Annual Leave</a>
                        
                    </nav>
                </div>
                <a class="nav-link collapsed {{ request()->is('adminhr/laporanleave') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#laporanleave" aria-expanded="false"
                    aria-controls="laporanleave">
                    <div class="sb-nav-link-icon"><i class="fa fa-user fa-fw"></i></div>
                    Leave Report
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('adminhr/laporanleave') ? 'show' : '' }}"
                    id="laporanleave" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('adminhr/laporanleave') ? 'active' : '' }}"
                            href="{{ url('adminhr/laporanleave')}}">View Leave Report</a>
                    </nav>
                </div>
                <a class="nav-link collapsed {{ request()->is('adminhr/users') || request()->is('adminhr/add/user') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#users" aria-expanded="false"
                    aria-controls="users">
                    <div class="sb-nav-link-icon"><i class="fa fa-user fa-fw"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('adminhr/users') || request()->is('adminhr/add/user') ? 'show' : '' }}"
                    id="users" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('adminhr/users') ? 'active' : '' }}"
                            href="{{ url('adminhr/users')}}">View Users</a>
                        <a class="nav-link {{ request()->is('adminhr/add/user') ? 'active' : '' }}"
                            href="{{ url('adminhr/add/user')}}">Add User</a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->name . ' ' . Auth::user()->last_name }}
        </div>
    </nav>
</div>