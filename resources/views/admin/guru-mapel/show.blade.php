@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Penugasan Guru</h1>
                <p class="text-gray-600">Informasi lengkap penugasan {{ $guru->nama }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.guru-mapel.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Guru Profile Section -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-6 text-center">
                @if($guru->foto)
                    <img src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama }}" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-white shadow-lg">
                @else
                    <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto mb-4 flex items-center justify-center border-4 border-white shadow-lg">
                        <i class="fas fa-user text-4xl text-gray-500"></i>
                    </div>
                @endif
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $guru->nama }}</h3>
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium inline-block mb-2">
                    {{ $guru->jabatan }}
                </div>
                @if($guru->nip)
                    <p class="text-sm text-gray-600">NIP: {{ $guru->nip }}</p>
                @elseif($guru->nuptk)
                    <p class="text-sm text-gray-600">NUPTK: {{ $guru->nuptk }}</p>
                @endif
                
                <!-- Quick Stats -->
                <div class="mt-6 space-y-3">
                    <div class="bg-white rounded-lg p-3 shadow-sm">
                        <div class="text-2xl font-bold text-blue-600">{{ $guru->mapels->count() }}</div>
                        <div class="text-sm text-gray-600">Total Penugasan</div>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm">
                        <div class="text-2xl font-bold text-green-600">{{ $guru->mapels->pluck('mapel_id')->unique()->count() }}</div>
                        <div class="text-sm text-gray-600">Mata Pelajaran</div>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm">
                        <div class="text-2xl font-bold text-purple-600">{{ $guru->mapels->pluck('pivot.kelas_id')->unique()->count() }}</div>
                        <div class="text-sm text-gray-600">Kelas Diampu</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignments Details -->
        <div class="lg:col-span-2">
            <!-- Basic Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Guru
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                        <p class="text-gray-800 font-medium">{{ $guru->nama }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jabatan</label>
                        <p class="text-gray-800 font-medium">{{ $guru->jabatan }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">NIP/NUPTK</label>
                        <p class="text-gray-800 font-medium">
                            @if($guru->nip)
                                {{ $guru->nip }}
                            @elseif($guru->nuptk)
                                {{ $guru->nuptk }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                        <p class="text-gray-800 font-medium">{{ $guru->email ?: '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Assignments List -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-tasks mr-2"></i>Daftar Penugasan
                    <span class="text-sm font-normal text-gray-500">({{ $guru->mapels->count() }} penugasan)</span>
                </h3>
                
                @if($guru->mapels->count() > 0)
                    <div class="space-y-4">
                        @foreach($guru->mapels as $index => $mapel)
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition duration-200">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center text-white font-bold">
                                            {{ substr($mapel->kode_mapel, 0, 2) }}
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $mapel->mapel }}</h4>
                                            <p class="text-sm text-gray-600">{{ $mapel->kode_mapel }}</p>
                                        </div>
                                    </div>
                                    @if($mapel->deskripsi)
                                        <p class="text-sm text-gray-600 mb-3">{{ $mapel->deskripsi }}</p>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.guru-mapel.edit', [$guru->guru_id, $mapel->mapel_id, $mapel->pivot->kurikulum_id, $mapel->pivot->kelas_id]) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition duration-200" title="Edit Penugasan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            onclick="confirmDelete('{{ $guru->guru_id }}', '{{ $mapel->mapel_id }}', '{{ $mapel->pivot->kurikulum_id }}', '{{ $mapel->pivot->kelas_id }}', '{{ $mapel->mapel }}', '{{ $mapel->kelas->nama_kelas ?? "N/A" }} - {{ $mapel->kelas->tingkat ?? "" }}')"
                                            class="text-red-600 hover:text-red-900 transition duration-200" title="Hapus Penugasan">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Kurikulum</label>
                                    @if($mapel->pivot->kurikulum)
                                        <p class="text-sm font-medium text-gray-900">{{ $mapel->pivot->kurikulum->nama_kurikulum }}</p>
                                        <p class="text-xs text-gray-600">{{ $mapel->pivot->kurikulum->tahun_ajaran }}</p>
                                    @else
                                        <p class="text-sm text-gray-500">-</p>
                                    @endif
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Kelas</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $mapel->kelas->nama_kelas ?? 'N/A' }} - {{ $mapel->kelas->tingkat ?? '' }}
                                    </span>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <span class="w-2 h-2 bg-blue-400 rounded-full mr-1"></span>
                                        Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tasks text-2xl text-gray-400"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Penugasan</h4>
                        <p class="text-gray-500 mb-4">Guru ini belum memiliki penugasan mata pelajaran.</p>
                        <a href="{{ route('admin.guru-mapel.create') }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Penugasan
                        </a>
                    </div>
                @endif
            </div>

            <!-- Summary by Class -->
            @if($guru->mapels->count() > 0)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-chart-bar mr-2"></i>Ringkasan per Kelas
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $kelasSummary = $guru->mapels->groupBy('pivot.kelas_id');
                    @endphp
                    @foreach($kelasSummary as $kelas => $mapels)
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white text-center">
                        <div class="text-2xl font-bold">{{ $mapels->count() }}</div>
                        <div class="text-purple-100 text-sm">Mapel di Kelas {{ $mapels->first()->kelas->nama_kelas ?? $kelas }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 pt-6 border-t">
        <div class="flex justify-between items-center">
            <div class="flex space-x-3">
                <a href="{{ route('admin.guru-mapel.create') }}" 
                   class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Tambah Penugasan
                </a>
                <button type="button" onclick="printDetail()" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                    <i class="fas fa-print mr-2"></i>Cetak Detail
                </button>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.guru.show', $guru->guru_id) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-user mr-2"></i>Lihat Profil Guru
                </a>
            </div>
        </div>
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
    function confirmDelete(guruId, mapelId, kurikulumId, kelasId, mapelNama, kelasNama) {
        const message = `Apakah Anda yakin ingin menghapus penugasan:<br><br>
                        <strong>Guru:</strong> {{ $guru->nama }}<br>
                        <strong>Mata Pelajaran:</strong> ${mapelNama}<br>
                        <strong>Kelas:</strong> ${kelasNama}<br><br>
                        Tindakan ini tidak dapat dibatalkan.`;
        
        document.getElementById('deleteMessage').innerHTML = message;
        document.getElementById('deleteForm').action = `/admin/guru-mapel/${guruId}/${mapelId}/${kurikulumId}/${kelasId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    function printDetail() {
        window.print();
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

<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        body {
            background: white !important;
        }
        
        .shadow-md {
            box-shadow: none !important;
        }
        
        .bg-gradient-to-br {
            background: #f8fafc !important;
        }
        
        button {
            display: none !important;
        }
        
        .border-t {
            display: none !important;
        }
    }
</style>
@endsection