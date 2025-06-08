{{-- <div class="fixed w-full top-0 left-0 border-b bg-white shadow-sm z-20">
    <div class="h-16 relative md:ml-80">
        <div class="absolute top-1/2 -translate-y-1/2 w-full px-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100">
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <h1 class="font-semibold text-xl text-gray-800 ml-2">Dashboard</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input type="text" class="rounded-full bg-gray-100 pl-10 pr-4 py-2 text-sm border-none focus:ring-2 focus:ring-blue-500" placeholder="Search...">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- search mobile --}}
{{-- <form action="" id="search" class="hidden sm:hidden">
    <div class="relative">
        <input type="text" class="rounded-md bg-white pl-10 py-2 h-9 border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Search">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2">
            <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
        </svg>
    </div>
</form> --}}

{{-- notifikasi page --}}
{{-- @include('admin.partials.norifikasi') --}}
{{-- 
@push('scripts')
    <script>
        var search = document.getElementById('search');
        var btnSearch = document.getElementById('btn-search');

        btnSearch.addEventListener('click', function() {
            search.classList.add('fixed');
            search.classList.add('top-24');
            search.classList.add('right-5');
            if (search.classList.contains('fixed')) {
                search.classList.toggle('hidden');
            }
        });
    </script> --}}
{{-- @endpush  --}}
