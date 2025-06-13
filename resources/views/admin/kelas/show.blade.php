@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <a href="{{ route('admin.kelas.index') }}" 
                   class="text-gray-600 hover:text-gray-800 mr-4 transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Kelas {{ $kelas->nama_kelas }}</h1>
                    {{-- @dd($kelas) --}}
                    <p class="text-gray-600">Informasi lengkap tentang kelas dan siswa</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.kelas.edit', $kelas->kelas_id) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Kelas
                </a>
                <button onclick="confirmDelete({{ $kelas->kelas_id }}, '{{ $kelas->nama_kelas }}', '{{ $kelas->tahun_ajaran }}')"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Kelas
                </button>
            </div>
        </div>
    </div>

    <!-- Kelas Information Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Basic Info Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Nama Kelas</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $kelas->nama_kelas }}</p>
                </div>
            </div>
        </div>

        <!-- Tingkat Card -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Tingkat</p>
                    <p class="text-2xl font-bold text-green-900">Kelas {{ $kelas->tingkat }}</p>
                </div>
            </div>
        </div>

        <!-- Capacity Card -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-yellow-600">Kapasitas</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ $kelas->total_siswa }}/{{ $kelas->kapasitas }}</p>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="{{ $kelas->status == 'aktif' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }} border rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-2 {{ $kelas->status == 'aktif' ? 'bg-green-500' : 'bg-red-500' }} rounded-lg">
                    @if($kelas->status == 'aktif')
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium {{ $kelas->status == 'aktif' ? 'text-green-600' : 'text-red-600' }}">Status</p>
                    <p class="text-2xl font-bold {{ $kelas->status == 'aktif' ? 'text-green-900' : 'text-red-900' }} capitalize">{{ $kelas->status }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Kelas Details -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Informasi Kelas
            </h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="font-medium text-gray-600">Nama Kelas:</span>
                    <span class="text-gray-900">{{ $kelas->nama_kelas }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="font-medium text-gray-600">Tingkat:</span>
                    <span class="text-gray-900">Kelas {{ $kelas->tingkat }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="font-medium text-gray-600">Tahun Ajaran:</span>
                    <span class="text-gray-900">{{ $kelas->tahun_ajaran }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="font-medium text-gray-600">Kurikulum:</span>
                    <span class="text-gray-900">{{ $kelas->kurikulum->nama_kurikulum ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="font-medium text-gray-600">Kapasitas:</span>
                    <span class="text-gray-900">{{ $kelas->kapasitas }} siswa</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="font-medium text-gray-600">Jumlah Siswa:</span>
                    <span class="text-gray-900 {{ $kelas->total_siswa >= $kelas->kapasitas ? 'text-red-600 font-semibold' : '' }}">
                        {{ $kelas->total_siswa }} siswa
                        @if($kelas->total_siswa >= $kelas->kapasitas)
                            <span class="text-xs text-red-500 ml-1">(Penuh)</span>
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="font-medium text-gray-600">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kelas->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($kelas->status) }}
                    </span>
                </div>
                @if($kelas->keterangan)
                <div class="py-2">
                    <span class="font-medium text-gray-600 block mb-2">Keterangan:</span>
                    <p class="text-gray-900 bg-white p-3 rounded border">{{ $kelas->keterangan }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Statistik Kelas
            </h2>
            <div class="space-y-4">
                <!-- Capacity Progress -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-600">Kapasitas Terisi</span>
                        <span class="text-sm text-gray-900">{{ round(($kelas->total_siswa / $kelas->kapasitas) * 100) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="{{ $kelas->total_siswa >= $kelas->kapasitas ? 'bg-red-500' : 'bg-blue-500' }} h-2 rounded-full transition-all duration-300" 
                             style="width: {{ min(($kelas->total_siswa / $kelas->kapasitas) * 100, 100) }}%"></div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-white p-4 rounded-lg border">
                        <div class="text-2xl font-bold text-blue-600">{{ $kelas->kapasitas - $kelas->total_siswa }}</div>
                        <div class="text-sm text-gray-600">Sisa Kapasitas</div>
                    </div>
                    <div class="bg-white p-4 rounded-lg border">
                        <div class="text-2xl font-bold text-green-600">{{ $kelas->total_siswa }}</div>
                        <div class="text-sm text-gray-600">Total Siswa</div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="font-medium text-blue-800 mb-2">Informasi Tambahan</h3>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Kelas dibuat: {{ $kelas->created_at->format('d M Y H:i') }}</li>
                        <li>• Terakhir diupdate: {{ $kelas->updated_at->format('d M Y H:i') }}</li>
                        @if($kelas->kurikulum)
                            <li>• Kurikulum: {{ $kelas->kurikulum->nama_kurikulum }} ({{ $kelas->kurikulum->tahun_kurikulum }})</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Data -->
    @if($kelas->guruMapels->count() > 0)
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
            Guru & Mata Pelajaran
        </h2>
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($kelas->guruMapels as $guruMapel)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $guruMapel->guru->nama }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $guruMapel->mapel->mapel }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $guruMapel->guru->nip }}</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
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
@endsection

@section('scripts')
<script>
    // Delete confirmation
    function confirmDelete(kelasId, namaKelas, tahunAjaran) {
        document.getElementById('deleteMessage').textContent = 
            `Apakah Anda yakin ingin menghapus kelas ${namaKelas} (${tahunAjaran})? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.`;
        document.getElementById('deleteForm').action = `/admin/kelas/${kelasId}`;
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