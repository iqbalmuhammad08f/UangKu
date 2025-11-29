<aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <i class="fa-solid fa-wallet text-blue-600 text-xl mr-2"></i>
        <span class="font-bold text-lg tracking-tight text-gray-800">DompetKu</span>
    </div>

    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1 px-3">

            <li>
                <a href="{{ route('dashboard.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg group transition-colors
                   {{ request()->routeIs('dashboard.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }}">

                    <i class="fa-solid fa-chart-pie w-6 h-6 flex items-center justify-center mr-2
                       {{ request()->routeIs('dashboard.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                    </i>

                    <span class="font-medium">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('transactions.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg group transition-colors
                   {{ request()->routeIs('transactions.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }}">

                    <i class="fa-solid fa-list w-6 h-6 flex items-center justify-center mr-2
                       {{ request()->routeIs('transactions.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                    </i>

                    <span class="font-medium">Transaksi</span>
                </a>
            </li>

            <li>
                <a href="{{ route('wallets.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg group transition-colors
                   {{ request()->routeIs('wallets.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }}">

                    <i class="fa-solid fa-wallet w-6 h-6 flex items-center justify-center mr-2
                       {{ request()->routeIs('wallets.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                    </i>

                    <span class="font-medium">Dompet Saya</span>
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg group transition-colors
                   {{ request()->routeIs('categories.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }}">

                    <i class="fa-solid fa-tags w-6 h-6 flex items-center justify-center mr-2
                       {{ request()->routeIs('categories.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}">
                    </i>

                    <span class="font-medium">Kategori</span>
                </a>
            </li>

        </ul>

        <div class="mt-8 px-6">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pengaturan</p>
            <ul class="space-y-1">
                <li>
                    <a href="#"
                       class="flex items-center py-2 text-gray-600 hover:text-blue-600 transition-colors">
                        <i class="fa-solid fa-user w-6 mr-2"></i> Profil
                    </a>
                </li>

                <li>
                    <button onclick="toggleModal('logoutModal')"
                        class="flex items-center py-2 text-red-500 hover:text-red-700 transition-colors w-full text-left">
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
