<div>
    <div class="flex items-start">
        <nav id="sidebar" class="lg:min-w-[250px] w-max max-lg:min-w-8">
            <div id="sidebar-collapse-menu" style="height: calc(100vh - 72px)"
                class="bg-white shadow-lg h-screen fixed py-6 px-4 top-[70px] left-0 overflow-auto z-[99] lg:min-w-[250px] lg:w-max max-lg:w-0 max-lg:invisible transition-all duration-500">
                <ul class="space-y-2">
                    <li>
                        <a href="{{route('admin.dashboard')}}"
                            class="text-gray-700 text-sm flex items-center hover:bg-gray-50 rounded-md px-4 py-2.5 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- 2. KELAS -->
                    <li>
                        <a href="{{ route('admin.kelas.index') }}"
                            class="text-gray-700 text-sm flex items-center hover:bg-gray-50 rounded-md px-4 py-2.5 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <span>Kelas</span>
                        </a>
                    </li>
                    
                    <!-- 3. SISWA -->
                    <li>
                        <a href="{{ route('admin.siswa.index') }}"
                            class="text-gray-700 text-sm flex items-center hover:bg-gray-50 rounded-md px-4 py-2.5 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                            <span>Siswa</span>
                        </a>
                    </li>
                    
                    <!-- 4. KURIKULUM -->
                    <li>
                        <a href="{{ route('admin.kurikulum.index') }}"
                            class="text-gray-700 text-sm flex items-center hover:bg-gray-50 rounded-md px-4 py-2.5 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            <span>Kurikulum</span>
                        </a>
                    </li>
                    
                    <!-- 5. MAPEL -->
                    <li>
                        <a href="{{ route('admin.mapel.index') }}"
                            class="text-gray-700 text-sm flex items-center hover:bg-gray-50 rounded-md px-4 py-2.5 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <span>Mapel</span>
                        </a>
                    </li>
                    
                    <!-- 6. GURU -->
                    <li>
                        <a href="{{ route('admin.guru.index') }}"
                            class="text-gray-700 text-sm flex items-center hover:bg-gray-50 rounded-md px-4 py-2.5 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span>Guru</span>
                        </a>
                    </li>
                    
                    <!-- 7. GURU MAPEL -->
                    <li>
                        <a href="{{ route('admin.guru-mapel.index') }}"
                            class="text-gray-700 text-sm flex items-center hover:bg-gray-50 rounded-md px-4 py-2.5 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            <span>Guru Mapel</span>
                        </a>
                    </li>
                    
                    <!-- 8. JADWAL -->
                    <li>
                        <a href="{{ route('admin.jadwal.index') }}"
                            class="text-gray-700 text-sm flex items-center hover:bg-gray-50 rounded-md px-4 py-2.5 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-6-7.5h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <span>Jadwal</span>
                        </a>
                    </li>
                    
                    
                    <!-- 4. TAHAP ASSIGNMENT -->
               

                    {{-- <li>
                        <a href="{{ route('admin.rombel.index') }}"
                            class="text-gray-700 text-sm flex items-center hover:bg-gray-50 rounded-md px-4 py-2.5 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <span>Rombel</span>
                        </a>
                    </li> --}}
        
                
                </ul>

                <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-gray-700 text-sm flex items-center cursor-pointer hover:bg-gray-50 rounded-md px-4 py-2.5 w-full transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px] mr-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <button id="toggle-sidebar"
            class='lg:hidden w-8 h-8 z-[100] fixed top-[74px] left-[10px] cursor-pointer bg-gray-600 hover:bg-gray-700 flex items-center justify-center rounded-full outline-none transition-all duration-500'>
            <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" class="w-3 h-3" viewBox="0 0 55.752 55.752">
                <path
                    d="M43.006 23.916a5.36 5.36 0 0 0-.912-.727L20.485 1.581a5.4 5.4 0 0 0-7.637 7.638l18.611 18.609-18.705 18.707a5.398 5.398 0 1 0 7.634 7.635l21.706-21.703a5.35 5.35 0 0 0 .912-.727 5.373 5.373 0 0 0 1.574-3.912 5.363 5.363 0 0 0-1.574-3.912z"
                    data-original="#000000" />
            </svg>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle sidebar on mobile
        const toggleButton = document.getElementById('toggle-sidebar');
        const sidebarMenu = document.getElementById('sidebar-collapse-menu');
        
        if (toggleButton && sidebarMenu) {
            toggleButton.addEventListener('click', function () {
                if (sidebarMenu.classList.contains('max-lg:invisible')) {
                    sidebarMenu.classList.remove('max-lg:invisible', 'max-lg:w-0');
                    sidebarMenu.classList.add('max-lg:w-[250px]');
                    toggleButton.classList.add('left-[260px]');
                    toggleButton.classList.add('rotate-180');
                } else {
                    sidebarMenu.classList.add('max-lg:invisible', 'max-lg:w-0');
                    sidebarMenu.classList.remove('max-lg:w-[250px]');
                    toggleButton.classList.remove('left-[260px]');
                    toggleButton.classList.remove('rotate-180');
                }
            });
        }
        
        // Dropdown functionality
        const accordions = document.querySelectorAll('.hs-accordion');
        
        accordions.forEach(accordion => {
            const button = accordion.querySelector('.hs-accordion-toggle');
            const content = accordion.querySelector('.hs-accordion-content');
            
            if (button && content) {
                button.addEventListener('click', function () {
                    const isActive = button.getAttribute('aria-expanded') === 'true';
                    
                    if (isActive) {
                        button.setAttribute('aria-expanded', 'false');
                        content.style.maxHeight = '0';
                        button.classList.remove('hs-accordion-active');
                    } else {
                        button.setAttribute('aria-expanded', 'true');
                        content.style.maxHeight = content.scrollHeight + 'px';
                        button.classList.add('hs-accordion-active');
                    }
                });
            }
        });
    });
</script>
