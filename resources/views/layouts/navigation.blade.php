<nav x-data="{ open: false, showLogout: false }" class="bg-white border-b border-gray-100">
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
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button @click="showLogout = true"
                            class="w-full text-left block px-4 py-2 text-sm leading-5 text-white
                                   hover:opacity-90 focus:outline-none transition duration-150 ease-in-out"
                            style="background-color:#004d4d;">
                            {{ __('Log Out') }}
                        </button>
                    </x-slot>
                </x-dropdown>
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
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button @click="showLogout = true; open = false"
                    class="w-full text-left block ps-3 pe-4 py-2 border-l-4 border-teal-700
                           text-base font-medium text-white hover:opacity-90
                           focus:outline-none transition duration-150 ease-in-out"
                    style="background-color:#003333;">
                    {{ __('Log Out') }}
                </button>
            </div>
        </div>
    </div>

    {{-- ── LOGOUT MODAL WITH EXCHANGED COLORS (TEAL HEADER, BURGUNDY BUTTON) ───────────────────────────────────────── --}}
    <div x-show="showLogout" x-transition style="display:none"
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
            <!-- Header with Teal (exchanged from Burgundy) -->
            <div class="px-6 py-4" style="background: linear-gradient(135deg, #004d4d 0%, #0F766E 100%);">
                <div class="flex items-center gap-3">
                    <!-- Warning Icon -->
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Confirm Logout</h3>
                </div>
            </div>
            
            <!-- Body -->
            <div class="px-6 py-5">
                <p class="text-gray-700 mb-2 font-medium">
                    Are you sure you want to logout?
                </p>
                <p class="text-sm text-gray-500">
                    Your session will be ended and you'll need to log in again to access your account.
                </p>
            </div>
            
            <!-- Footer with Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button type="button" @click="showLogout = false"
                    class="px-5 py-2.5 bg-gray-300 hover:bg-gray-400 text-gray-700
                           rounded-lg font-semibold transition duration-200 ease-in-out
                           focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                    Cancel
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2.5 text-white rounded-lg font-semibold transition duration-200 ease-in-out
                               focus:outline-none focus:ring-2 focus:ring-offset-2"
                        style="background: linear-gradient(135deg, #6D0B2F 0%, #8B1A3B 100%);"
                        onmouseover="this.style.background='linear-gradient(135deg, #550921 0%, #6D0B2F 100%)'"
                        onmouseout="this.style.background='linear-gradient(135deg, #6D0B2F 0%, #8B1A3B 100%)'">
                        Yes, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>