<header class='flex shadow-md z-[99] py-1 px-4 sm:px-7 bg-white min-h-[70px] tracking-wide z-[10] fixed top-0 w-full'>
    <div class='flex flex-wrap items-center justify-between gap-4 w-full relative'>
        <a href="javascript:void(0)" class="flex items-center gap-2">
            <img src="{{ asset('img/logo MIM.png') }}" alt="logo" class='w-10 object-contain' />
            <div class="flex flex-col">
                <h1 class="uppercase text-xl font-semibold text-gray-800">
                    SISMO
                </h1>
                <span class="text-xs text-gray-500 -mt-1">Sistem Informasi Sekolah Modern</span>
            </div>
        </a>
        
        <!-- User Info -->
        <div class="flex items-center gap-4">
            <!-- Notifications -->
            <button class="relative p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5 5-5m-5 5H9m11 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            
            <!-- User Profile -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800">Administrator</p>
                    <p class="text-xs text-gray-500">admin@sismo.com</p>
                </div>
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">A</span>
                </div>
            </div>
        </div>
    </div>
</header>
