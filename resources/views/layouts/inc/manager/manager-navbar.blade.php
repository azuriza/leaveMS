<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark fixed-top">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="dashboard">Manager</a>
    
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <!-- <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div> -->
    </form>
    
    <!-- Navbar Links-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown" id="notif-wrapper">
            <a class="nav-link position-relative" id="notificationDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-lg"></i>
                <span class="badge-notif d-none" id="notif-count">0</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-animated" aria-labelledby="notificationDropdown" id="notif-list">
                <li><span class="dropdown-item text-muted">Loading...</span></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                @if(Auth::user()->profile_picture)
                    <img src="{{ asset('profile_pictures/' . Auth::user()->profile_picture) }}" class="rounded-circle me-2"
                        style="width: 35px; height: 35px; object-fit: cover;" alt="Profile Picture">
                @else
                    <img src="{{ asset('views/assets/img/avatar.png') }}" class="rounded-circle me-2"
                        style="width: 35px; height: 35px; object-fit: cover;" alt="Default Avatar">
                @endif
                @if(Auth::user()->name && Auth::user()->last_name)
                    <span class="d-none d-lg-inline">{{ Auth::user()->name . ' ' . Auth::user()->last_name }}</span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/profile">Profile</a></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
    
    <!-- Dark Mode Toggle -->
    <!-- <button id="darkModeToggle" class="btn btn-outline-light ms-2 me-3" title="Toggle Dark Mode">
        <i class="bi bi-moon"></i>
    </button> -->
</nav>
<script>
    // Simpan judul awal tab
    const originalTitle = document.title;

    function fetchNotifications() {
        fetch('/notifications/latest')
            .then(response => response.json())
            .then(data => {
                const count = data.length;
                const countBadge = document.getElementById('notif-count');
                const notifList = document.getElementById('notif-list');

                // Update badge
                if (count > 0) {
                    countBadge.textContent = count;
                    countBadge.classList.remove('d-none');
                    document.title = `(${count}) ${originalTitle}`;
                } else {
                    countBadge.classList.add('d-none');
                    document.title = originalTitle;
                }

                // Tampilkan notifikasi
                notifList.innerHTML = '';
                if (count === 0) {
                    notifList.innerHTML = `<li><span class="dropdown-item">Tidak ada notifikasi</span></li>`;
                } else {
                    data.forEach(notif => {
                        notifList.innerHTML += `
                            <li>
                                <a class="dropdown-item new-notif" href="${notif.data.url ?? '#'}" data-id="${notif.id}">
                                    ${notif.data.message ?? 'Notifikasi baru'}
                                </a>
                            </li>`;
                    });
                }
            })
            .catch(() => {
                document.getElementById('notif-list').innerHTML = `
                    <li><span class="dropdown-item text-danger">Gagal memuat notifikasi</span></li>`;
            });
    }

    // Tandai sebagai dibaca saat klik salah satu notifikasi
    document.addEventListener('click', function (e) {
    if (e.target.classList.contains('new-notif')) {
            e.preventDefault();
            const id = e.target.getAttribute('data-id');
            const href = e.target.getAttribute('href');

            fetch(`/notifications/mark-as-read/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                window.location.href = href; // redirect setelah ditandai dibaca
            });
        }
    });

    // Spinner awal
    document.getElementById('notif-list').innerHTML = `
        <li id="loading-spinner">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </li>
    `;

    fetchNotifications();
    setInterval(fetchNotifications, 5000);
</script>
