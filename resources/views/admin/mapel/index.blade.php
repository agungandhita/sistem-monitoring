@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Mata Pelajaran</h1>
            <p class="text-gray-600">Kelola data mata pelajaran dan kurikulum</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.mapel.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Mata Pelajaran
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6 flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" id="searchInput" placeholder="Cari mata pelajaran..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="flex gap-2">
            <select id="sortFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Urutkan</option>
                <option value="kode_asc">Kode A-Z</option>
                <option value="kode_desc">Kode Z-A</option>
                <option value="nama_asc">Nama A-Z</option>
                <option value="nama_desc">Nama Z-A</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Mapel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Mata Pelajaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kurikulum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru Pengampu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="mapelTableBody">
                @forelse($mapels as $index => $mapel)
                <tr class="hover:bg-gray-50 mapel-row" data-kode="{{ strtolower($mapel->kode_mapel) }}" data-nama="{{ strtolower($mapel->mapel) }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $mapels->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-sm font-medium text-blue-800">{{ substr($mapel->kode_mapel, 0, 2) }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $mapel->kode_mapel }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $mapel->mapel }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($mapel->kurikulum)
                            <span class="px-2 py-1 text-xs bg-purple-100 text-purple-800 rounded-full">
                                {{ $mapel->kurikulum->nama_kurikulum }}
                            </span>
                            <div class="text-xs text-gray-400 mt-1">{{ $mapel->kurikulum->tahun_ajaran }}</div>
                        @else
                            <span class="text-gray-400 italic">Belum ada kurikulum</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {{ $mapel->deskripsi ? Str::limit($mapel->deskripsi, 50) : '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($mapel->gurus && $mapel->gurus->count() > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach($mapel->gurus->take(2) as $guru)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $guru->nama }}
                                    </span>
                                @endforeach
                                @if($mapel->gurus->count() > 2)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        +{{ $mapel->gurus->count() - 2 }} lainnya
                                    </span>
                                @endif
                            </div>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Belum ada guru
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.mapel.show', $mapel->mapel_id) }}" 
                               class="text-blue-600 hover:text-blue-900 transition duration-200" title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.mapel.edit', $mapel->mapel_id) }}" 
                               class="text-yellow-600 hover:text-yellow-900 transition duration-200" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <button onclick="confirmDelete('{{ $mapel->mapel_id }}', '{{ $mapel->mapel }}')" 
                                    class="text-red-600 hover:text-red-900 transition duration-200" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="text-lg font-medium text-gray-900 mb-2">Belum ada mata pelajaran</p>
                            <p class="text-gray-500 mb-4">Mulai dengan menambahkan mata pelajaran pertama</p>
                            <a href="{{ route('admin.mapel.create') }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                Tambah Mata Pelajaran
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($mapels->hasPages())
    <div class="mt-6">
        {{ $mapels->links() }}
    </div>
    @endif

    <!-- Info -->
    <div class="mt-4 text-sm text-gray-600">
        Menampilkan {{ $mapels->firstItem() ?? 0 }} - {{ $mapels->lastItem() ?? 0 }} dari {{ $mapels->total() }} mata pelajaran
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
            </div>
        </div>
        <div class="mb-4">
            <p class="text-sm text-gray-500">
                Apakah Anda yakin ingin menghapus mata pelajaran <strong id="deleteMapelName"></strong>? 
                Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeDeleteModal()" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Batal
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.mapel-row');
        
        rows.forEach(row => {
            const kode = row.dataset.kode;
            const nama = row.dataset.nama;
            
            if (kode.includes(searchTerm) || nama.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Sort functionality
    document.getElementById('sortFilter').addEventListener('change', function() {
        const sortType = this.value;
        const tbody = document.getElementById('mapelTableBody');
        const rows = Array.from(tbody.querySelectorAll('.mapel-row'));
        
        if (!sortType) return;
        
        rows.sort((a, b) => {
            let aValue, bValue;
            
            switch(sortType) {
                case 'kode_asc':
                    aValue = a.dataset.kode;
                    bValue = b.dataset.kode;
                    return aValue.localeCompare(bValue);
                case 'kode_desc':
                    aValue = a.dataset.kode;
                    bValue = b.dataset.kode;
                    return bValue.localeCompare(aValue);
                case 'nama_asc':
                    aValue = a.dataset.nama;
                    bValue = b.dataset.nama;
                    return aValue.localeCompare(bValue);
                case 'nama_desc':
                    aValue = a.dataset.nama;
                    bValue = b.dataset.nama;
                    return bValue.localeCompare(aValue);
            }
        });
        
        // Re-append sorted rows
        rows.forEach(row => tbody.appendChild(row));
    });

    // Delete confirmation
    function confirmDelete(mapelId, mapelName) {
        document.getElementById('deleteMapelName').textContent = mapelName;
        document.getElementById('deleteForm').action = `/admin/mapel/${mapelId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endsection