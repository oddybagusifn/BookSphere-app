@php
    $isAdminPage = Request::is('admin*');
    $hideNavbar = Request::is('login') || Request::is('/') || Request::is('register') || Request::is('forgot-password');
    $hideFooter =
        Request::is('login') || Request::is('register') || Request::is('forgot-password') || Request::is('admin*');
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BookSphere</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/style.css">


    <style>
        @media (min-width: 768px) {
            .admin-main {
                margin-left: 250px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    @unless ($hideNavbar)
        <x-navbar />
    @endunless

    <div class="d-flex">
        @if ($isAdminPage)
            <!-- Sidebar (Visible only on md and above) -->
            <aside class="bg-white px-3 py-4 d-none d-md-flex flex-column position-fixed"
                style="top: 56px; bottom: 0; left: 0; width: 250px; z-index: 1000;">
                @include('components.sidebar')
            </aside>
        @endif

        <!-- Main Content -->
        <main class="flex-grow-1 {{ $isAdminPage ? 'admin-main' : '' }}">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    @unless ($hideFooter)
        <x-footer />
    @endunless

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <script src="{{ asset('/js/script.js') }}"></script>

    @include('components.scripts.search')
    @stack('scripts')
</body>

</html>
