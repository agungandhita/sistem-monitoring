@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Penugasan Guru Mata Pelajaran</h1>
            <p class="text-gray-600">Kelola penugasan guru ke mata pelajaran berdasarkan kurikulum dan kelas</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.guru-mapel.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Penugasan
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6 flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" id="searchInput" placeholder="Cari guru atau mata pelajaran..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="flex gap-2">
            <select id="kelasFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kelas</option>
                @php
                    $allKelas = [];
                    foreach($gurus as $guru) {
                        foreach($guru->mapels as $mapel) {
                            $allKelas[] = $mapel->pivot->kelas;
                        }
                    }
                    $uniqueKelas = array_unique($allKelas);
                    sort($uniqueKelas);
                @endphp
                @foreach($uniqueKelas as $kelas)
                    <option value="{{ $kelas }}">{{ $kelas }}</option>
                @endforeach
            </select>
            <select id="jabatanFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Jabatan</option>
                @foreach($gurus->pluck('jabatan')->unique() as $jabatan)
                    <option value="{{ $jabatan }}">{{ $jabatan }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Guru</p>
                    <p class="text-2xl font-bold">{{ $gurus->count() }}</p>
                </div>
                <div class="bg-blue-400 rounded-full p-3">
                    <i class="fas fa-chalkboard-teacher text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Penugasan</p>
                    <p class="text-2xl font-bold">
                        @php
                            $totalAssignments = 0;
                            foreach($gurus as $guru) {
                                $totalAssignments += $guru->mapels->count();
                            }
                        @endphp
                        {{ $totalAssignments }}
                    </p>
                </div>
                <div class="bg-green-400 rounded-full p-3">
                    <i class="fas fa-tasks text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Mata Pelajaran Aktif</p>
                    <p class="text-2xl font-bold">
                        @php
                            $activeMapels = [];
                            foreach($gurus as $guru) {
                                foreach($guru->mapels as $mapel) {
                                    $activeMapels[] = $mapel->mapel_id;
                                }
                            }
                            $uniqueMapels = array_unique($activeMapels);
                        @endphp
                        {{ count($uniqueMapels) }}
                    </p>
                </div>
                <div class="bg-purple-400 rounded-full p-3">
                    <i class="fas fa-book text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Kelas Aktif</p>
                    <p class="text-2xl font-bold">{{ count($uniqueKelas) }}</p>
                </div>
                <div class="bg-orange-400 rounded-full p-3">
                    <i class="fas fa-school text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg" id="guruMapelTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kurikulum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php $no = ($gurus->currentPage() - 1) * $gurus->perPage() + 1; @endphp
                @forelse($gurus as $guru)
                    @forelse($guru->mapels as $mapel)
                    {{-- @dd($mapel) --}}
                        <tr class="hover:bg-gray-50 transition duration-200" data-guru="{{ strtolower($guru->nama) }}" data-mapel="{{ strtolower($mapel->mapel) }}" data-kelas="{{ $mapel->pivot->kelas_id }}" data-jabatan="{{ strtolower($guru->jabatan) }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $no++ }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($guru->foto)
                                        <img src="{{ asset('uploads/guru/' . $guru->foto) }}" alt="{{ $guru->nama }}" 
                                             class="w-10 h-10 rounded-full object-cover mr-3 border-2 border-gray-200">
                                    @else
                                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-gray-500"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $guru->nama }}</div>
                                        <div class="text-sm text-gray-500">
                                            @if($guru->nip)
                                                NIP: {{ $guru->nip }}
                                            @elseif($guru->nuptk)
                                                NUPTK: {{ $guru->nuptk }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $mapel->mapel }}</div>
                                <div class="text-sm text-gray-500">{{ $mapel->kode_mapel }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($mapel->kurikulums)
                                    @foreach($mapel->kurikulums as $kurikulum)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $kurikulum->nama_kurikulum }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    @php
                                        $kelasObj = \App\Models\Kelas::find($mapel->pivot->kelas_id);
                                    @endphp
                                    {{ $kelasObj ? $kelasObj->nama_kelas . ' - ' . $kelasObj->tingkat : 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $guru->jabatan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.guru-mapel.show', $guru->guru_id) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition duration-200" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.guru-mapel.edit', [$guru->guru_id, $mapel->mapel_id, $mapel->pivot->kurikulum_id, $mapel->pivot->kelas_id]) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 transition duration-200" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            @php
                                                $kelasObj = \App\Models\Kelas::find($mapel->pivot->kelas_id);
                                                $kelasName = $kelasObj ? $kelasObj->nama_kelas . ' - ' . $kelasObj->tingkat : 'N/A';
                                            @endphp
                                            onclick="confirmDelete('{{ $guru->guru_id }}', '{{ $mapel->mapel_id }}', '{{ $mapel->pivot->kurikulum_id }}', '{{ $mapel->pivot->kelas_id }}', '{{ $guru->nama }}', '{{ $mapel->mapel }}', '{{ $kelasName }}')"
                                            class="text-red-600 hover:text-red-900 transition duration-200" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Guru {{ $guru->nama }} belum memiliki penugasan mata pelajaran
                            </td>
                        </tr>
                    @endforelse
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data penugasan guru mata pelajaran
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $gurus->links() }}
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
            </div>
        </div>
        <div class="mb-4">
            <p class="text-sm text-gray-500" id="deleteMessage">
                <!-- Message will be populated by JavaScript -->
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
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
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
    document.getElementById('searchInput').addEventListener('keyup', function() {
        filterTable();
    });

    // Filter functionality
    document.getElementById('kelasFilter').addEventListener('change', function() {
        filterTable();
    });

    document.getElementById('jabatanFilter').addEventListener('change', function() {
        filterTable();
    });

    function filterTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const kelasFilter = document.getElementById('kelasFilter').value;
        const jabatanFilter = document.getElementById('jabatanFilter').value.toLowerCase();
        const rows = document.querySelectorAll('#guruMapelTable tbody tr');

        rows.forEach(row => {
            if (row.cells.length === 1) return; // Skip empty rows
            
            const guru = row.getAttribute('data-guru') || '';
            const mapel = row.getAttribute('data-mapel') || '';
            const kelas = row.getAttribute('data-kelas') || '';
            const jabatan = row.getAttribute('data-jabatan') || '';

            const matchesSearch = guru.includes(searchTerm) || mapel.includes(searchTerm);
            const matchesKelas = !kelasFilter || kelas === kelasFilter;
            const matchesJabatan = !jabatanFilter || jabatan.includes(jabatanFilter);

            if (matchesSearch && matchesKelas && matchesJabatan) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function confirmDelete(guruId, mapelId, kurikulumId, kelas, guruNama, mapelNama, kelasNama) {
        const message = `Apakah Anda yakin ingin menghapus penugasan:<br><br>
                        <strong>Guru:</strong> ${guruNama}<br>
                        <strong>Mata Pelajaran:</strong> ${mapelNama}<br>
                        <strong>Kelas:</strong> ${kelasNama}<br><br>
                        Tindakan ini tidak dapat dibatalkan.`;
        
        document.getElementById('deleteMessage').innerHTML = message;
        document.getElementById('deleteForm').action = `/admin/guru-mapel/${guruId}/${mapelId}/${kurikulumId}/${kelas}`;
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