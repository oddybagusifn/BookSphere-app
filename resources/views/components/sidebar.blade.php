<aside class="d-flex flex-column bg-white shadow-sm px-3 py-4 position-sticky top-0 shadow-sm"
    style="width: 250px; height: 100vh; overflow-y: auto;">
    <!-- Menu -->
    <ul class="nav flex-column gap-2">
        @php
            $menu = [
                ['label' => 'Dashboard', 'icon' => 'house', 'route' => 'admin.dashboard'],
                ['label' => 'Buku', 'icon' => 'book-open', 'route' => 'admin.books'],
                ['label' => 'Kategori', 'icon' => 'books', 'route' => 'admin.categories.index'],
                ['label' => 'Peminjaman', 'icon' => 'bookmark', 'route' => 'admin.borrowings.index'],
                ['label' => 'Pengaturan', 'icon' => 'gear', 'route' => '#'],
            ];
        @endphp

        @foreach ($menu as $item)
            @php
                $isActive = $item['route'] !== '#' && request()->routeIs($item['route']);
                $activeStyle = $isActive
                    ? 'background: linear-gradient(145deg, #4E342E, #6D4C41, #8D6E63); color: white; font-weight: 600; box-shadow: 0 2px 6px rgba(0,0,0,0.2);'
                    : '';
                $iconColor = $isActive ? 'text-white' : 'text-dark';
            @endphp
            <li class="nav-item">
                <a href="{{ $item['route'] !== '#' ? route($item['route']) : '#' }}"
                    class="nav-link d-flex align-items-center gap-2 rounded-3 px-3 py-2 {{ $iconColor }}"
                    style="{{ $activeStyle }}">
                    <i class="ph ph-{{ $item['icon'] }} fs-5 {{ $iconColor }}"></i>
                    <span class="sidebar-label">{{ $item['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Spacer -->
    <div class="flex-grow-1"></div>

    <!-- Dark Mode + Logout -->
    <div class="mt-4 border-top pt-3 px-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <i class="ph ph-moon fs-5 text-accent"></i>
                <span class="small text-dark sidebar-label">Dark Mode</span>
            </div>
            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" id="darkModeToggle" checked>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="btn btn-sm w-100 btn-outline-dark rounded-pill d-flex align-items-center justify-content-center gap-2">
                <i class="ph ph-sign-out"></i> <span class="sidebar-label">Logout</span>
            </button>
        </form>
    </div>
</aside>
