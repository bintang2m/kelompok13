<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>

                    <!-- Nav Explore / Mencari Dropdown -->
                    @php $navGenres = \App\Models\Genre::orderBy('name', 'asc')->get(); @endphp
                    <div class="hidden sm:flex sm:items-center ml-2">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out h-full mt-1 cursor-pointer">
                                    <div>Mencari</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="max-h-64 overflow-y-auto">
                                    @forelse($navGenres as $g)
                                        <x-dropdown-link href="{{ route('novels.index', ['genre' => $g->id]) }}">
                                            {{ $g->name }}
                                        </x-dropdown-link>
                                    @empty
                                        <div class="px-4 py-2 text-sm text-gray-400">Belum ada genre</div>
                                    @endforelse
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <x-nav-link :href="route('history.index')" :active="request()->routeIs('history.*')" class="ml-4">
                        {{ __('Riwayat') }}
                    </x-nav-link>
                    
                    @auth
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="ml-6">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Search Bar (Middle) -->
            <div class="hidden sm:flex flex-1 items-center justify-center px-4">
                <form action="{{ route('novels.index') }}" method="GET" class="w-full max-w-md">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari novel berdasarkan judul..." class="w-full border-gray-300 rounded-full shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 pl-4 py-2 pr-10 text-sm">
                        <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-500 hover:text-blue-600">
                            🔍
                        </button>
                    </div>
                </form>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 gap-2">
                            @if(Auth::user()->avatar)
                                <img src="{{ Storage::url(Auth::user()->avatar) }}" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                            @else
                                <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-xs">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('dashboard')">
                            {{ __('Dasbor Utama') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Kelola Profil') }}
                        </x-dropdown-link>
                        @if(Auth::user()->role === 'admin')
                            <x-dropdown-link :href="route('admin.dashboard')" class="text-red-600 font-bold bg-red-50 hover:bg-red-100">
                                {{ __('🛡️ Area Super Admin') }}
                            </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300 origin-top"
         x-transition:enter-start="opacity-0 scale-y-0"
         x-transition:enter-end="opacity-100 scale-y-100"
         x-transition:leave="transition ease-in duration-200 origin-top"
         x-transition:leave-start="opacity-100 scale-y-100"
         x-transition:leave-end="opacity-0 scale-y-0"
         class="sm:hidden absolute w-full z-50 bg-white border-b border-gray-200 shadow-2xl rounded-b-2xl overflow-hidden pb-4" 
         style="display: none;">
         
        <!-- Mobile Search Bar -->
        <div class="px-5 pt-5 pb-3">
            <form action="{{ route('novels.index') }}" method="GET" class="w-full">
                <div class="relative flex items-center bg-gray-50 border border-gray-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all shadow-inner">
                    <span class="pl-4 text-gray-400">🔍</span>
                    <input type="text" name="search" placeholder="Cari novel favoritmu..." class="w-full bg-transparent border-0 py-3 pl-3 pr-4 text-sm text-gray-700 focus:ring-0 placeholder-gray-400 font-medium">
                </div>
            </form>
        </div>

        <div class="px-3 pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="rounded-xl mx-2 font-bold flex items-center gap-2 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700' : '' }}">
                🏠 {{ __('Home / Beranda') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('history.index')" :active="request()->routeIs('history.*')" class="rounded-xl mx-2 font-bold flex items-center gap-2 {{ request()->routeIs('history.*') ? 'bg-blue-50 text-blue-700' : '' }}">
                🕰️ {{ __('Riwayat Baca') }}
            </x-responsive-nav-link>
            
            @auth
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-xl mx-2 font-bold flex items-center gap-2 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                🎨 {{ __('Dashboard Profil') }}
            </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Mobile Genres -->
        <div class="px-5 py-4 bg-gradient-to-br from-gray-50 to-white border-y border-gray-100">
            <div class="w-full text-xs font-black text-gray-400 tracking-wider mb-3 uppercase flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                Jelajahi Kategori
            </div>
            <div class="flex flex-wrap gap-2">
                @forelse($navGenres as $g)
                    <a href="{{ route('novels.index', ['genre' => $g->id]) }}" class="text-xs font-bold bg-white border border-gray-200 shadow-sm hover:shadow-md hover:border-blue-300 hover:text-blue-600 text-gray-600 px-3 py-2 rounded-full transition-all transform hover:-translate-y-0.5">{{ $g->name }}</a>
                @empty
                    <span class="text-xs text-gray-400 italic">Belum ada genre</span>
                @endforelse
            </div>
        </div>

        <!-- Responsive Auth / Settings Options -->
        <div class="pt-5 px-5">
            @auth
            <div class="flex items-center gap-4 bg-blue-600 rounded-2xl p-4 shadow-lg mb-4 text-white">
                @if(Auth::user()->avatar)
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" class="w-14 h-14 rounded-full object-cover border-2 border-white/50 shadow-inner">
                @else
                    <div class="w-14 h-14 rounded-full bg-white/20 border-2 border-white/50 text-white font-black flex items-center justify-center text-xl shadow-inner">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-1">
                    <div class="font-extrabold text-lg leading-tight">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-blue-200 text-sm opacity-90 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1 bg-gray-50 rounded-xl p-2 border border-gray-100">
                <x-responsive-nav-link :href="route('profile.edit')" class="rounded-lg font-semibold hover:bg-gray-200 flex items-center gap-2">
                    ⚙️ {{ __('Pengaturan Akun') }}
                </x-responsive-nav-link>

                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" class="text-white font-bold bg-red-600 hover:bg-red-700 rounded-lg mt-1 flex items-center gap-2 shadow-sm">
                        🛡️ {{ __('Area Super Admin') }}
                    </x-responsive-nav-link>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-600 font-semibold rounded-lg hover:bg-red-50 flex items-center gap-2">
                        🚪 {{ __('Keluar (Log Out)') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @else
            <div class="flex flex-col gap-3">
                <a href="{{ route('login') }}" class="w-full text-center py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md transition transform active:scale-95">Masuk / Log In</a>
                <a href="{{ route('register') }}" class="w-full text-center py-3 bg-white border-2 border-slate-200 hover:bg-slate-50 text-slate-700 font-bold rounded-xl transition transform active:scale-95">Daftar Akun Baru</a>
            </div>
            @endauth
        </div>
    </div>
</nav>
