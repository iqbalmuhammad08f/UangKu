<li>
    <a href="{{ route('dashboard.index') }}" onclick="toggleSidebar('mobileSidebar')"
        class="flex items-center px-4 py-3 rounded-lg group transition-colors
       {{ request()->routeIs('dashboard.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }}">

        <i
            class="fa-solid fa-chart-pie w-6 h-6 flex items-center justify-center mr-2
           {{ request()->routeIs('dashboard.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>

        <span class="font-medium">Dashboard</span>
    </a>
</li>

<li>
    <a href="{{ route('transactions.index') }}" onclick="toggleSidebar('mobileSidebar')"
        class="flex items-center px-4 py-3 rounded-lg group transition-colors
       {{ request()->routeIs('transactions.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }}">

        <i
            class="fa-solid fa-list w-6 h-6 flex items-center justify-center mr-2
           {{ request()->routeIs('transactions.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>

        <span class="font-medium">Transaksi</span>
    </a>
</li>

<li>
    <a href="{{ route('wallets.index') }}" onclick="toggleSidebar('mobileSidebar')"
        class="flex items-center px-4 py-3 rounded-lg group transition-colors
       {{ request()->routeIs('wallets.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }}">

        <i
            class="fa-solid fa-wallet w-6 h-6 flex items-center justify-center mr-2
           {{ request()->routeIs('wallets.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>

        <span class="font-medium">Dompet Saya</span>
    </a>
</li>

<li>
    <a href="{{ route('categories.index') }}" onclick="toggleSidebar('mobileSidebar')"
        class="flex items-center px-4 py-3 rounded-lg group transition-colors
       {{ request()->routeIs('categories.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:bg-gray-50' }}">

        <i
            class="fa-solid fa-tags w-6 h-6 flex items-center justify-center mr-2
           {{ request()->routeIs('categories.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>

        <span class="font-medium">Kategori</span>
    </a>
</li>
