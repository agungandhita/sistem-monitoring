@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Rombel</h1>
            <p class="text-gray-600">Kelola data rombongan belajar</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.rombel.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Rombel
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6 flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" id="searchInput" placeholder="Cari rombel..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="flex gap-2">
            <select id="kelasFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kelas</option>
                @foreach($rombels->unique('kelas.nama_kelas')->sortBy('kelas.tingkat') as $rombel)
                    @if($rombel->kelas)
                        <option value="{{ $rombel->kelas->kelas_id }}">{{ $rombel->kelas->nama_kelas }}</option>
                    @endif
                @endforeach
            </select>
            <select id="tahunFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($rombels->unique('tahun_ajaran')->sortByDesc('tahun_ajaran') as $rombel)
                    <option value="{{ $rombel->tahun_ajaran }}">{{ $rombel->tahun_ajaran }}</option>
                @endforeach
            </select>
            <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="tidak_aktif">Tidak Aktif</option>
            </select>
            <select id="waliFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Wali Kelas</option>
                @foreach($rombels->whereNotNull('waliKelas')->unique('wali_kelas_id')->sortBy('waliKelas.nama_lengkap') as $rombel)
                    <option value="{{ $rombel->wali_kelas_id }}">{{ $rombel->waliKelas->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Rombel</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Ajaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wali Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="rombelTableBody">
                @forelse($rombels as $index => $rombel)
                    <tr class="hover:bg-gray-50 rombel-row" 
                        data-nama="{{ strtolower($rombel->nama_rombel) }}"
                        data-kelas="{{ $rombel->kelas_id }}"
                        data-tahun="{{ $rombel->tahun_ajaran }}"
                        data-status="{{ $rombel->status }}"
                        data-wali="{{ $rombel->wali_kelas_id }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $rombel->nama_rombel }}</div>
                            @if($rombel->deskripsi)
                                <div class="text-sm text-gray-500">{{ Str::limit($rombel->deskripsi, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($rombel->kelas)
                                <div class="text-sm text-gray-900">{{ $rombel->kelas->nama_kelas }}</div>
                                <div class="text-sm text-gray-500">Tingkat {{ $rombel->kelas->tingkat }}</div>
                            @else
                                <span class="text-sm text-red-500">Kelas tidak ditemukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $rombel->tahun_ajaran }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($rombel->waliKelas)
                                <div class="text-sm text-gray-900">{{ $rombel->waliKelas->nama_lengkap }}</div>
                                <div class="text-sm text-gray-500">{{ $rombel->waliKelas->nip ?? 'Tidak ada NIP' }}</div>
                            @else
                                <span class="text-sm text-gray-500">Belum ditentukan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $rombel->siswas->count() }} siswa</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $rombel->kapasitas_maksimal ?? 'Tidak terbatas' }}</div>
                            @if($rombel->kapasitas_maksimal)
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                    @php
                                        $percentage = $rombel->kapasitas_maksimal > 0 ? ($rombel->siswas->count() / $rombel->kapasitas_maksimal) * 100 : 0;
                                        $colorClass = $percentage >= 90 ? 'bg-red-500' : ($percentage >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                                    @endphp
                                    <div class="{{ $colorClass }} h-2 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($rombel->status == 'aktif')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.rombel.show', $rombel->rombel_id) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition duration-200" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.rombel.edit', $rombel->rombel_id) }}" 
                                   class="text-yellow-600 hover:text-yellow-900 transition duration-200" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="confirmDelete('{{ $rombel->rombel_id }}', '{{ $rombel->nama_rombel }}')" 
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
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-lg font-medium text-gray-900 mb-2">Belum ada data rombel</p>
                                <p class="text-gray-500 mb-4">Mulai dengan menambahkan rombel baru</p>
                                <a href="{{ route('admin.rombel.create') }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                                    Tambah Rombel
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="deleteMessage"></p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Hapus
                    </button>
                </form>
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Search and Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const kelasFilter = document.getElementById('kelasFilter');
    const tahunFilter = document.getElementById('tahunFilter');
    const statusFilter = document.getElementById('statusFilter');
    const waliFilter = document.getElementById('waliFilter');
    const tableBody = document.getElementById('rombelTableBody');
    const rows = tableBody.querySelectorAll('.rombel-row');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedKelas = kelasFilter.value;
        const selectedTahun = tahunFilter.value;
        const selectedStatus = statusFilter.value;
        const selectedWali = waliFilter.value;

        rows.forEach(row => {
            const nama = row.dataset.nama;
            const kelas = row.dataset.kelas;
            const tahun = row.dataset.tahun;
            const status = row.dataset.status;
            const wali = row.dataset.wali;

            const matchesSearch = nama.includes(searchTerm);
            const matchesKelas = !selectedKelas || kelas === selectedKelas;
            const matchesTahun = !selectedTahun || tahun === selectedTahun;
            const matchesStatus = !selectedStatus || status === selectedStatus;
            const matchesWali = !selectedWali || wali === selectedWali;

            if (matchesSearch && matchesKelas && matchesTahun && matchesStatus && matchesWali) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterTable);
    kelasFilter.addEventListener('change', filterTable);
    tahunFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
    waliFilter.addEventListener('change', filterTable);
});

// Delete confirmation
function confirmDelete(rombelId, rombelName) {
    document.getElementById('deleteMessage').textContent = `Apakah Anda yakin ingin menghapus rombel "${rombelName}"? Tindakan ini tidak dapat dibatalkan.`;
    document.getElementById('deleteForm').action = `{{ url('admin/rombel') }}/${rombelId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection