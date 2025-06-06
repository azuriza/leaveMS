<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->is('/dashboard') ? 'active' : '' }}"
                    href="{{ url('/dashboard')}}">
                <!-- <a class="nav-link {{ request()->is('#') ? 'active' : '' }}" href="{{ url('#')}}"> -->
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed {{ request()->is('add/applyleave') || request()->is('show/applyleave') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Applied Leave
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('add/applyleave') || request()->is('show/applyleave') || request()->is('showho/applyleave') ? 'show' : '' }}" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('add/applyleave') ? 'active' : '' }}" href="{{ url('add/applyleave')}}">Apply Leave</a>
                        <a class="nav-link {{ request()->is('show/applyleave') ? 'active' : '' }}" href="{{ url('show/applyleave')}}">View Leaves</a>
                        <a class="nav-link {{ request()->is('showho/applyleave') ? 'active' : '' }}" href="{{ url('showho/applyleave')}}">View HandOver</a>
                    </nav>
                </div>
                <a class="nav-link collapsed {{ request()->is('show/dokumen') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#dokumens" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    ISO Documents
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->is('show/dokumen') ? 'show' : '' }}" id="dokumens" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('show/dokumen') ? 'active' : '' }}" href="{{ url('show/dokumen')}}">View Documents</a>
                    </nav>
                </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->name . ' ' . Auth::user()->last_name }}
        </div>
    </nav>
</div>
