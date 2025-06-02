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
                <a class="nav-link collapsed {{ request()->is('adminiso/kategori') || request()->is('adminiso/add/kategori') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#kategoridok" aria-expanded="false"
                    aria-controls="kategoridok">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Category Documents
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('adminiso/kategori') || request()->is('adminiso/add/kategori') ? 'show' : '' }}"
                    id="kategoridok" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('adminiso/kategori') ? 'active' : '' }}"
                            href="{{ url('adminiso/kategori')}}">View Category</a>
                        <a class="nav-link {{ request()->is('adminiso/add/kategori') ? 'active' : '' }}"
                            href="{{ url('adminiso/add/kategori')}}">Add Category</a>
                    </nav>
                </div>              
                <a class="nav-link collapsed {{ request()->is('adminiso/dokumen') || request()->is('adminiso/add/dokumen') ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#dokumens" aria-expanded="false"
                    aria-controls="dokumens">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Documents
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('adminiso/dokumen') || request()->is('adminiso/add/dokumen') ? 'show' : '' }}"
                    id="dokumens" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('adminiso/dokumen') ? 'active' : '' }}"
                            href="{{ url('adminiso/dokumen')}}">View Documents</a>
                        <a class="nav-link {{ request()->is('adminiso/add/dokumen') ? 'active' : '' }}"
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