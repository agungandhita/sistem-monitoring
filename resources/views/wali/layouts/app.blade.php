<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>@yield('title', 'SISMO - Wali')</title>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <img src="{{ asset('img/logo MIM.png') }}" alt="Logo" class="w-8 h-8 mr-3">
                        <span class="text-lg sm:text-xl font-bold text-gray-900">SISMO</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Wali</span>
                    </div>
                    
                    <!-- Navigation Links - Hidden on mobile -->
                    <div class="hidden md:ml-8 md:flex md:space-x-4 lg:space-x-8">
                        <a href="{{ route('wali.dashboard') }}" 
                           class="{{ request()->routeIs('wali.dashboard') ? 'border-green-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v6m8-6v6m-8-2h8"></path>
                            </svg>
                            <span class="hidden lg:inline">Dashboard</span>
                        </a>
                        
                        <a href="{{ route('wali.catatan-perkembangan.index') }}" 
                           class="{{ request()->routeIs('wali.catatan-perkembangan.*') ? 'border-green-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="hidden lg:inline">Catatan</span>
                        </a>
                        
                        <a href="{{ route('wali.jadwal.index') }}" 
                           class="{{ request()->routeIs('wali.jadwal.*') ? 'border-green-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="hidden lg:inline">Jadwal</span>
                        </a>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" onclick="toggleMobileMenu()" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 p-2">
                        <svg id="mobile-menu-open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="mobile-menu-close" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- User Menu - Hidden on mobile -->
                <div class="hidden md:flex items-center">
                    <div class="relative ml-3">
                        <div class="flex items-center space-x-2 lg:space-x-4">
                            <span class="text-sm text-gray-700 hidden lg:block">{{ auth('wali')->user()->nama }}</span>
                            <div class="relative">
                                <button type="button" onclick="toggleDropdown()" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-green-600 font-semibold text-sm">
                                            {{ strtoupper(substr(auth('wali')->user()->nama, 0, 1)) }}
                                        </span>
                                    </div>
                                    <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                    <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-200">
                                        <div class="font-medium">{{ auth('wali')->user()->nama }}</div>
                                        <div class="text-gray-500 truncate">{{ auth('wali')->user()->email }}</div>
                                    </div>
                                    <form action="{{ route('wali.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                <a href="{{ route('wali.dashboard') }}" 
                   class="{{ request()->routeIs('wali.dashboard') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
                    <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v6m8-6v6m-8-2h8"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('wali.catatan-perkembangan.index') }}" 
                   class="{{ request()->routeIs('wali.catatan-perkembangan.*') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
                    <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Catatan Perkembangan
                </a>
                <a href="{{ route('wali.jadwal.index') }}" 
                   class="{{ request()->routeIs('wali.jadwal.*') ? 'bg-green-50 border-green-500 text-green-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
                    <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Jadwal Pelajaran
                </a>
                
                <!-- Mobile User Info -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="px-3 py-2">
                        <div class="text-base font-medium text-gray-800">{{ auth('wali')->user()->nama }}</div>
                        <div class="text-sm text-gray-500 truncate">{{ auth('wali')->user()->email }}</div>
                    </div>
                    <form action="{{ route('wali.logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown-menu');
            dropdown.classList.toggle('hidden');
        }
        
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const openIcon = document.getElementById('mobile-menu-open');
            const closeIcon = document.getElementById('mobile-menu-close');
            
            mobileMenu.classList.toggle('hidden');
            openIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdown-menu');
            const button = event.target.closest('button');
            
            if (!button || !button.onclick) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>