<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link <?php echo e(request()->is('#') ? 'active' : ''); ?>" href="<?php echo e(url('#')); ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed <?php echo e(request()->is('add/applyleave') || request()->is('show/applyleave') ? 'active' : ''); ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Leave Type
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?php echo e(request()->is('add/applyleave') || request()->is('show/applyleave') ? 'show' : ''); ?>" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?php echo e(request()->is('add/applyleave') ? 'active' : ''); ?>" href="<?php echo e(url('add/applyleave')); ?>">Apply Leave</a>
                        <a class="nav-link <?php echo e(request()->is('show/applyleave') ? 'active' : ''); ?>" href="<?php echo e(url('show/applyleave')); ?>">View Leaves</a>
                    </nav>
                </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo e(Auth::user()->name . ' ' . Auth::user()->last_name); ?>

        </div>
    </nav>
</div>
<?php /**PATH D:\PROJECT\leave-management-system\resources\views/layouts/inc/employee/employee-sidebar.blade.php ENDPATH**/ ?>