<nav x-data="{ open: false }" class="bg-white border-b border-stone-200 sticky top-0 z-50 shadow-xs">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo Branding LastCall (Persis Welcome Page) -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role === 'merchant' ? url('/merchant/dashboard') : url('/dashboard') }}" 
                    class="text-2xl font-extrabold text-orange-600 no-underline"
                    style="font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
                        LastCall 🥐
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->role === 'merchant')
                        <x-nav-link :href="url('/merchant/dashboard')" :active="request()->is('merchant/dashboard')">
                            {{ __('Dashboard Merchant') }}
                        </x-nav-link>
                        <x-nav-link :href="url('/merchant/store')" :active="request()->is('merchant/store*')">
                            {{ __('Profil Toko') }}
                        </x-nav-link>
                        <x-nav-link :href="url('/merchant/products')" :active="request()->is('merchant/products*')">
                            {{ __('Kelola Produk') }}
                        </x-nav-link>
                        <x-nav-link :href="url('/merchant/orders')" :active="request()->is('merchant/orders*')">
                            {{ __('📦 Pesanan Masuk') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="url('/dashboard')" :active="request()->is('dashboard')">
                            {{ __('Katalog Makanan') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3.5 py-2 border border-stone-200 text-xs font-bold rounded-xl text-stone-700 bg-stone-50 hover:bg-stone-100 hover:text-orange-600 focus:outline-none transition ease-in-out duration-150 gap-1.5">
                            <span class="text-stone-400">👤</span>
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Pengaturan Akun') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Keluar / Logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-stone-400 hover:text-stone-500 hover:bg-stone-100 focus:outline-none focus:bg-stone-100 focus:text-stone-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'inline-flex': open, 'hidden': ! open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-stone-200 bg-stone-50">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'merchant')
                <x-responsive-nav-link :href="url('/merchant/dashboard')" :active="request()->is('merchant/dashboard')">
                    {{ __('Dashboard Merchant') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="url('/merchant/store')" :active="request()->is('merchant/store*')">
                    {{ __('Profil Toko') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="url('/merchant/products')" :active="request()->is('merchant/products*')">
                    {{ __('Kelola Produk') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="url('/dashboard')" :active="request()->is('dashboard')">
                    {{ __('Katalog Makanan') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-stone-200">
            <div class="px-4">
                <div class="font-bold text-base text-stone-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-stone-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Pengaturan Akun') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar / Logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>