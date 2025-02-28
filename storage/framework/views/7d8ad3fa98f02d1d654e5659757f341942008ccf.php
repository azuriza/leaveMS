<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-bs-theme="<?php echo e(session('theme', 'light')); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('backend/images/apple-touch-icon.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('backend/images/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('backend/images/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('backend/images/site.webmanifest')); ?>">
    <link rel="mask-icon" href="<?php echo e(asset('backend/images/safari-pinned-tab.svg')); ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- summernote css -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('backend/css/custom.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('backend/css/styles.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" rel="stylesheet">

    <!-- datatables css -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0px !important;
            margin-left: 0px !important;
        }

        div.dataTables_wrapper div.dataTables_length select {
            width: 50% !important;
        }

        div.dataTables_wrapper {
            width: 100% !important;
            margin: 0 auto !important;
            padding-left: 3px !important;
            padding-right: 0px !important;
        }

        .bg-error {
            background-color: #dc3545 !important;
            color: #fff !important;
        }

        .text-error {
            color: #dc3545 !important;
        }
    </style>
</head>

<body id="body">

    <?php echo $__env->make('layouts.inc.admin.admin-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div id="layoutSidenav">

        <?php echo $__env->make('layouts.inc.admin.admin-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div id="layoutSidenav_content">
            <main>
                <?php echo $__env->yieldContent('content'); ?>
            </main>

            <?php echo $__env->make('layouts.inc.admin.admin-footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

    <script src="<?php echo e(asset('backend/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backend/js/scripts.js')); ?>"></script>
    <script src="<?php echo e(asset('backend/js/jquery-3.6.0.min.js')); ?>"></script>

    <?php if(session('status') && session('status_code')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastMessage = "<?php echo e(session('status')); ?>";
                var toastClass = "<?php echo e(session('status_code')); ?>";  // 'success', 'warning', 'danger', 'error
                var faviconPath = "<?php echo e(asset('backend/images/favicon-32x32.png')); ?>"; // Path to the favicon

                var toastHTML = `
                                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                                        <div id="liveToast" class="toast bg-${toastClass} text-white" role="alert" aria-live="assertive" aria-atomic="true">
                                            <div class="toast-header">
                                                <img src="${faviconPath}" class="rounded me-2" alt="Favicon" style="width: 20px; height: 20px;">
                                                <strong class="me-auto">Notification</strong>
                                                <small>Just now</small>
                                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                            </div>
                                            <div class="toast-body">
                                                ${toastMessage}
                                            </div>
                                        </div>
                                    </div>
                                `;

                document.body.insertAdjacentHTML('beforeend', toastHTML);

                var toastElement = document.getElementById('liveToast');
                var toastInstance = new bootstrap.Toast(toastElement, { delay: 3000 });
                toastInstance.show();
            });
        </script>
    <?php endif; ?>

    <!-- summernote js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#mysummernote").summernote({
                height: 150,
            });
            $('.dropdown-toggle').dropdown();

            // Automatically expand the parent menu if a child link is active
            $('.nav-link.active').each(function () {
                $(this).closest('.collapse').addClass('show');
                $(this).closest('.collapse').prev('.nav-link').addClass('parent-expanded');
            });
        });
    </script>

    <!-- datatables js -->
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#mydataTable').DataTable({
                "scrollY": true,
                "scrollX": true
            });

            // Dark mode toggle functionality
            const darkModeToggle = document.getElementById('darkModeToggle');

            // Function to update the <html> data-bs-theme attribute
            function updateTheme() {
                const theme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-bs-theme', theme);
            }

            // Load the saved theme from localStorage and update the <html> attribute
            updateTheme();

            // Toggle dark mode on button click
            darkModeToggle.addEventListener('click', function () {
                const currentTheme = localStorage.getItem('theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                // Update localStorage with the new theme
                localStorage.setItem('theme', newTheme);

                // Update the <html> data-bs-theme attribute
                updateTheme();

                // Change button icon and text
                if (newTheme === 'dark') {
                    darkModeToggle.innerHTML = '<i class="bi bi-sun"></i>';
                } else {
                    darkModeToggle.innerHTML = '<i class="bi bi-moon"></i>';
                }
            });

        });
    </script>

</body>

</html><?php /**PATH D:\PROJECT\leave-management-system\resources\views/layouts/backend.blade.php ENDPATH**/ ?>