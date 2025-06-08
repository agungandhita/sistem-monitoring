<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-50 w-80 h-screen -translate-x-full lg:translate-x-0 transition-all duration-500"
    aria-label="Sidebar">
    {{-- logo area --}}
    <div class="h-20 mb-2 border-b-[1px] border-main2 px-3 relative">
        <div class=" absolute top-[50%] -translate-y-[50%] p-2 w-full">
            <div class="flex gap-x-4 justify-between w-full pr-[25px]">
                <div class="flex gap-x-4">
                    <img src="{{ asset('img/logo.png') }}" alt="" class="object-contain w-52 h-20 my-auto">
                    <h1 class="font-semibold text-white text-[21px] my-auto">{{ config('services.aplication.AppName') }}
                    </h1>
                </div>

                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex justify-center w-8 h-8 items-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 bg-white">
                    <i class="ri-close-fill text-[30px]"></i>
                </button>
            </div>

        </div>
    </div>
    <div class="h-full px-3 pb-[290px] overflow-y-auto bg-Sidebar relative w-80 scrollbar-sidebar">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/quran"
                    class="flex items-center p-2 text-gray-400 rounded-lg group relative hover:bg-SidebarActive hover:text-white {{ request()->routeIs('dashboard') ? 'bg-SidebarActive text-white' : '' }}">
                    <i class="ri-dashboard-fill text-[20px] transition duration-75 "></i>
                    <span class="ml-3 font-semibold">Laporan</span>

                </a>
            </li>

            {{-- <li>
                <a href="/nilai-santri"
                    class="flex items-center p-2 text-gray-400 rounded-lg group relative hover:bg-SidebarActive hover:text-white {{ request()->routeIs('dashboard') ? 'bg-SidebarActive text-white' : '' }}">
                    <i class="ri-dashboard-fill text-[20px] transition duration-75 "></i>
                    <span class="ml-3 font-semibold">Kelas</span>

                </a>
            </li> --}}
       
    
            {{-- <li>
                <a href="{{ route('kelola-pembayaran.index') }}"
                    class="flex items-center p-2 text-gray-400 rounded-lg group hover:bg-SidebarActive hover:text-white {{ request()->routeIs('kelola-pembayaran.*') ? 'bg-SidebarActive text-white' : '' }}">
                    <i class="ri-bank-card-fill text-[20px] transition duration-75"></i>
                    <span class="ml-3 font-semibold">Pembayaran SPP</span>
                </a>
            </li> --}}
        
        </ul>

        {{-- menu bawa --}}
        <div class="fixed w-[313px] bottom-0 bg-Sidebar left-0 pt-2 px-3 pb-4">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="flex items-center p-2 text-gray-400 rounded-lg group w-full">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                        class="w-5 h-5 fill-gray-400 transition duration-75"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z" />
                    </svg>

                    <span class="ml-3 font-semibold">Logout</span>
                </button>

            </form>
            <div class="max-h-[50px] h-full w-full border-t-[1px] border-main2 flex gap-x-3 pt-2">
                <img src="{{ asset('img/myFoto.jpg') }}" alt=""
                    class="object-cover w-10 h-10 rounded-full my-auto">
                <div class="my-auto">
                    <h1 class="text-lg text-white capitalize">{{ auth()->user()->nama }}</h1>
                    <h1 class="text-sm text-gray-300 capitalize">{{ auth()->user()->role }}</h1>
                </div>
            </div>
        </div>
    </div>
</aside>



@push('scripts')
    <script>
        var dropdownSidebar = document.querySelectorAll('.dropdownSidebar');
        var arrowSidebar = document.querySelectorAll('.arrowSidebar');

        dropdownSidebar.forEach(function(element, index) {
            element.addEventListener('click', function() {
                arrowSidebar[index].classList.toggle('rotate-180');
            });
        });
    </script>
@endpush