<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->is('adminiso/dashboard') ? 'active' : '' }}"
                    href="{{ url('adminiso/dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>                
                <a class="nav-link collapsed {{ request()->is('adminiso/dokumen') || request()->is('adminiso/add/dokumen') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#users" aria-expanded="false"
                    aria-controls="users">
                    <div class="sb-nav-link-icon"><i class="fa fa-user fa-fw"></i></div>
                    Documents
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('adminiso/dokumen') || request()->is('adminiso/add/dokumen') ? 'show' : '' }}"
                    id="users" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('adminiso/users') ? 'active' : '' }}"
                            href="{{ url('adminiso/dokumen')}}">View Documents</a>
                        <a class="nav-link {{ request()->is('adminiso/add/user') ? 'active' : '' }}"
                            href="{{ url('adminiso/add/dokumen')}}">Add Documents</a>
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