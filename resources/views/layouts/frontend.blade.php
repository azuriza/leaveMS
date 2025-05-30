<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>UPI HRMS</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('frontend/images/favicon-32x32.png') }}" type="image/png" />

    <!-- Fonts & Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@500;700&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        rel="stylesheet"
    />

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />

    <!-- Custom Style -->
    <style>
        body {
  background: #fff;
  position: relative;
  min-height: 100vh;
  overflow-x: hidden;
}

.background-lines {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  pointer-events: none;
  z-index: -1;
  background:
    repeating-linear-gradient(
      90deg,
      rgba(0,0,0,0.05),
      rgba(0,0,0,0.05) 1px,
      transparent 1px,
      transparent 20px
    );
  animation: linesMove 15s linear infinite;
  background-size: 100% 100%;
}

@keyframes linesMove {
  0% {
    background-position: 0 0;
  }
  100% {
    background-position: 100% 0;
  }
}

        :root {
            --primary-color: #FF5733; /* Merah keoranyean */
            --accent-color: #FFC300; /* Kuning cerah */
            --dark: #212529;
            --light: #f8f9fa;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            font-family: "Nunito", sans-serif;
            background-color: var(--light);
            color: var(--dark);
            padding-top: 70px; /* ruang navbar fixed */
        }

        main {
            flex: 1 0 auto; /* isi konten tumbuh dan dorong footer */
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.3rem;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: #000 !important;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        .btn-outline-light {
            border-color: #fff;
            color: #fff;
        }

        .btn-outline-light:hover {
            background-color: #fff;
            color: var(--primary-color);
        }

        /* Footer */
        footer {
            flex-shrink: 0;
            background-color: var(--primary-color);
            color: #fff;
        }

        footer a {
            color: #fff;
            text-decoration: none;
        }

        footer a:hover {
            color: #000;
            text-decoration: underline;
        }
    </style>

    @stack("styles")
</head>
<body>
<div class="background-lines"></div>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('frontend/images/upi-logo.png') }}" alt="UPI Logo" style="height: 30px; margin-right: 8px;">
                UPI HRMS
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarModern"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- <div class="collapse navbar-collapse" id="navbarModern">
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <span class="nav-link">👋 {{ Auth::user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                            class="d-inline"
                        >
                            @csrf
                            <button class="btn btn-outline-light ms-2" type="submit">
                                Logout
                            </button>
                        </form>
                    </li>
                    @endguest
                </ul>
            </div> -->
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container py-4">
        @yield("content")
    </main>

    {{-- Footer --}}
    @include('layouts.inc.footer')

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset("frontend/js/jquery-3.6.0.min.js") }}"></script>

    @if(session("status"))
    <script src="{{ asset("frontend/js/sweetalert.min.js") }}"></script>
    <script>
        swal({
            title: "{{ session("status") }}",
            icon: "{{ session("status_code") ?? "info" }}",
            button: "OK",
        }).then(() => {
            window.location.reload();
        });
    </script>
    @endif

    @stack("scripts")
</body>
</html>
