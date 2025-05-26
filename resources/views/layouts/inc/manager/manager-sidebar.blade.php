<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->is('manager/dashboard') ? 'active' : '' }}"
                    href="{{ url('manager/dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed {{ request()->is('manager/add/leavetype') || request()->is('manager/leavetype') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Leave Type
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('manager/add/leavetype') || request()->is('manager/leavetype') ? 'show' : '' }}"
                    id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('manager/add/leavetype') ? 'active' : '' }}"
                            href="{{ url('manager/add/leavetype')}}">Add Leave Type</a>
                        <a class="nav-link {{ request()->is('manager/leavetype') ? 'active' : '' }}"
                            href="{{ url('manager/leavetype')}}">View Leave Type</a>
                    </nav>
                </div>

                <a class="nav-link collapsed {{ request()->is('manager/applyleave') || request()->is('manager/add/applyleave') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="false"
                    aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Applied Leave
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('manager/applyleave') || request()->is('manager/add/applyleave') ? 'show' : '' }}"
                    id="collapse" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('manager/applyleave') ? 'active' : '' }}"
                            href="{{ url('manager/applyleave')}}">View Leaves</a>
                        <a class="nav-link {{ request()->is('manager/add/applyleave') ? 'active' : '' }}"
                            href="{{ url('manager/add/applyleave')}}">Apply Leave</a>
                    </nav>
                </div>
                <a class="nav-link collapsed {{ request()->is('manager/users') || request()->is('manager/add/user') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#users" aria-expanded="false"
                    aria-controls="users">
                    <div class="sb-nav-link-icon"><i class="fa fa-user fa-fw"></i></div>
                    Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('manager/users') || request()->is('manager/add/user') ? 'show' : '' }}"
                    id="users" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('manager/users') ? 'active' : '' }}"
                            href="{{ url('manager/users')}}">View Users</a>
                        <a class="nav-link {{ request()->is('manager/add/user') ? 'active' : '' }}"
                            href="{{ url('manager/add/user')}}">Add User</a>
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