<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
    <button class="md:hidden text-gray-600">
        <i class="fa-solid fa-bars text-xl"></i>
    </button>

    <h2 class="text-xl font-bold text-gray-800 hidden md:block">
        @yield('header_title', 'Overview')
    </h2>

    <div class="flex items-center gap-4">
        @yield('header_actions')

        <a href="{{ route('profile.index') }}" class="flex items-center gap-2 cursor-pointer border-l pl-4 border-gray-200 hover:opacity-80 transition">
            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border border-gray-300">
                <img src="{{ auth()->user()->avatar_url }}"
                     alt="{{ auth()->user()->name }}"
                     class="w-full h-full object-cover">
            </div>
            <span class="text-sm font-medium text-gray-700 hidden lg:block">
                {{ auth()->user()->name }}
            </span>
        </a>
    </div>
</header>
