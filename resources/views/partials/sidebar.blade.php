<aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <i class="fa-solid fa-wallet text-blue-600 text-xl mr-2"></i>
        <span class="font-bold text-lg tracking-tight text-gray-800">DompetKu</span>
    </div>

    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1 px-3">
            @include('partials.sidebar-items')
        </ul>

        <div class="mt-8 px-6">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pengaturan</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('profile.index') }}"
                        class="flex items-center py-2 px-3 rounded-lg transition-colors
                       {{ request()->routeIs('profile.*') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-gray-600 hover:text-blue-600' }}">
                        <i class="fa-solid fa-user w-6 mr-2"></i> Profil
                    </a>
                </li>

                <li>
                    <button onclick="toggleModal('logoutModal')"
                        class="flex items-center py-2 px-3 text-red-500 hover:text-red-700 transition-colors w-full text-left">
                        <i class="fa-solid fa-right-from-bracket w-6 mr-2"></i> Logout
                    </button>
                </li>
            </ul>
        </div>
    </nav>

    <x-modal id="logoutModal" title="Logout" method="post" button="Ya" action="{{ route('logout') }}">
        Apakah anda yakin ingin keluar?
    </x-modal>

</aside>

<!-- Mobile Sidebar (hidden by default, toggled via JS) -->
<div id="mobileSidebarBackdrop" class="fixed inset-0 bg-opacity-30 z-40 hidden md:hidden"
    onclick="toggleSidebar('mobileSidebar')"></div>

<aside id="mobileSidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 md:hidden transform -translate-x-full transition-transform">
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <i class="fa-solid fa-wallet text-blue-600 text-xl mr-2"></i>
        <span class="font-bold text-lg tracking-tight text-gray-800">DompetKu</span>
        <button class="ml-auto text-gray-400" onclick="toggleSidebar('mobileSidebar')">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1 px-3">
            @include('partials.sidebar-items')
        </ul>

        <div class="mt-8 px-6">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pengaturan</p>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('profile.index') }}"
                        class="flex items-center py-2 px-3 rounded-lg transition-colors
                       {{ request()->routeIs('profile.*') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-gray-600 hover:text-blue-600' }}">
                        <i class="fa-solid fa-user w-6 mr-2"></i> Profil
                    </a>
                </li>

                <li>
                    <button onclick="toggleModal('logoutModal'); toggleSidebar('mobileSidebar')"
                        class="flex items-center py-2 px-3 text-red-500 hover:text-red-700 transition-colors w-full text-left">
                        <i class="fa-solid fa-right-from-bracket w-6 mr-2"></i> Logout
                    </button>
                </li>
            </ul>
        </div>
    </nav>
</aside>
