@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <!-- Header -->
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $rombel->nama_rombel }}</h1>
            <p class="text-gray-600">Detail rombongan belajar</p>
            <div class="flex items-center mt-2 space-x-4">
                @if($rombel->status == 'aktif')
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        Aktif
                    </span>
                @else
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                        Tidak Aktif
                    </span>
                @endif
                <span class="text-sm text-gray-500">{{ $rombel->tahun_ajaran }}</span>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.rombel.edit', $rombel->rombel_id) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.rombel.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <button onclick="confirmDelete('{{ $rombel->rombel_id }}', '{{ $rombel->nama_rombel }}')" 
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Hapus
            </button>
        </div>
    </div>

    <!-- Rombel Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Kelas Info -->
        <div class="bg-blue-50 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Kelas</p>
                    @if($rombel->kelas)
                        <p class="text-lg font-semibold text-gray-900">{{ $rombel->kelas->nama_kelas }}</p>
                        <p class="text-sm text-gray-500">Tingkat {{ $rombel->kelas->tingkat }}</p>
                    @else
                        <p class="text-lg font-semibold text-red-500">Tidak ada</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Student Count -->
        <div class="bg-green-50 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Jumlah Siswa</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $rombel->siswas->count() }} siswa</p>
                    @if($rombel->kapasitas_maksimal)
                        <p class="text-sm text-gray-500">dari {{ $rombel->kapasitas_maksimal }} maksimal</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Wali Kelas -->
        <div class="bg-purple-50 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-600">Wali Kelas</p>
                    @if($rombel->waliKelas)
                        <p class="text-lg font-semibold text-gray-900">{{ $rombel->waliKelas->nama_lengkap }}</p>
                        <p class="text-sm text-gray-500">{{ $rombel->waliKelas->nip ?? 'Tidak ada NIP' }}</p>
                    @else
                        <p class="text-lg font-semibold text-gray-500">Belum ditentukan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Capacity -->
        <div class="bg-orange-50 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-orange-600">Kapasitas</p>
                    @if($rombel->kapasitas_maksimal)
                        <p class="text-lg font-semibold text-gray-900">{{ $rombel->kapasitas_maksimal }}</p>
                        @php
                            $percentage = ($rombel->siswas->count() / $rombel->kapasitas_maksimal) * 100;
                            $colorClass = $percentage >= 90 ? 'bg-red-500' : ($percentage >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                        @endphp
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                            <div class="{{ $colorClass }} h-2 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                        <p class="text-sm text-gray-500">{{ number_format($percentage, 1) }}% terisi</p>
                    @else
                        <p class="text-lg font-semibold text-gray-900">Tidak terbatas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    @if($rombel->deskripsi)
        <div class="bg-gray-50 rounded-lg p-4 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Deskripsi</h3>
            <p class="text-gray-700">{{ $rombel->deskripsi }}</p>
        </div>
    @endif

    <!-- Students Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Daftar Siswa</h2>
            @if($rombel->status == 'aktif')
                <button onclick="showAddStudentModal()" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Siswa
                </button>
            @endif
        </div>

        @if($rombel->siswas->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rombel->siswas as $index => $siswa)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $siswa->nama_lengkap }}</div>
                                    <div class="text-sm text-gray-500">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->nisn ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $siswa->pivot->tanggal_masuk ? \Carbon\Carbon::parse($siswa->pivot->tanggal_masuk)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($siswa->pivot->status == 'aktif')
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
                                        <a href="{{ route('admin.siswa.show', $siswa->siswa_id) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition duration-200" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        @if($siswa->pivot->status == 'aktif' && $rombel->status == 'aktif')
                                            <button onclick="showRemoveStudentModal('{{ $siswa->siswa_id }}', '{{ $siswa->nama_lengkap }}')" 
                                                    class="text-red-600 hover:text-red-900 transition duration-200" title="Keluarkan dari Rombel">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900 mb-2">Belum ada siswa</p>
                <p class="text-gray-500 mb-4">Mulai dengan menambahkan siswa ke rombel ini</p>
                @if($rombel->status == 'aktif')
                    <button onclick="showAddStudentModal()" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        Tambah Siswa
                    </button>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Add Student Modal -->
<div id="addStudentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Siswa ke Rombel</h3>
            <form id="addStudentForm" action="{{ route('admin.rombel.add-student', $rombel->rombel_id) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="siswa_id" class="block text-sm font-medium text-gray-700 mb-2">Siswa</label>
                        <select id="siswa_id" name="siswa_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Pilih Siswa</option>
                            <!-- Options will be loaded via JavaScript -->
                        </select>
                    </div>
                    <div>
                        <label for="tahun_ajaran_add" class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
                        <input type="text" id="tahun_ajaran_add" name="tahun_ajaran" value="{{ $rombel->tahun_ajaran }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" readonly>
                    </div>
                    <div>
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk</label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ date('Y-m-d') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="keterangan_add" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea id="keterangan_add" name="keterangan" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                  placeholder="Keterangan tambahan (opsional)"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeAddStudentModal()" 
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Tambah Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Remove Student Modal -->
<div id="removeStudentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Keluarkan Siswa dari Rombel</h3>
            <form id="removeStudentForm" method="POST">
                @csrf
                <div class="space-y-4">
                    <p id="removeStudentMessage" class="text-sm text-gray-600"></p>
                    <div>
                        <label for="tanggal_keluar" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Keluar</label>
                        <input type="date" id="tanggal_keluar" name="tanggal_keluar" value="{{ date('Y-m-d') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="keterangan_remove" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea id="keterangan_remove" name="keterangan" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                                  placeholder="Alasan keluarkan siswa (opsional)"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeRemoveStudentModal()" 
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                        Keluarkan Siswa
                    </button>
                </div>
            </form>
        </div>
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
// Add Student Modal
function showAddStudentModal() {
    // Load available students
    fetch('/admin/siswa/available')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('siswa_id');
            select.innerHTML = '<option value="">Pilih Siswa</option>';
            data.forEach(siswa => {
                const option = document.createElement('option');
                option.value = siswa.siswa_id;
                option.textContent = `${siswa.nama_lengkap} - ${siswa.nisn || 'Tanpa NISN'}`;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error loading students:', error);
            alert('Gagal memuat data siswa');
        });
    
    document.getElementById('addStudentModal').classList.remove('hidden');
}

function closeAddStudentModal() {
    document.getElementById('addStudentModal').classList.add('hidden');
}

// Remove Student Modal
function showRemoveStudentModal(siswaId, siswaName) {
    document.getElementById('removeStudentMessage').textContent = `Apakah Anda yakin ingin mengeluarkan ${siswaName} dari rombel ini?`;
    document.getElementById('removeStudentForm').action = `{{ route('admin.rombel.remove-student', [$rombel->rombel_id, '__SISWA_ID__']) }}`.replace('__SISWA_ID__', siswaId);
    document.getElementById('removeStudentModal').classList.remove('hidden');
}

function closeRemoveStudentModal() {
    document.getElementById('removeStudentModal').classList.add('hidden');
}

// Delete confirmation
function confirmDelete(rombelId, rombelName) {
    const studentCount = {{ $rombel->siswas->count() }};
    let message = `Apakah Anda yakin ingin menghapus rombel "${rombelName}"?`;
    
    if (studentCount > 0) {
        message += ` Rombel ini memiliki ${studentCount} siswa aktif. Tindakan ini tidak dapat dibatalkan.`;
    }
    
    document.getElementById('deleteMessage').textContent = message;
    document.getElementById('deleteForm').action = `{{ route('admin.rombel.destroy', '__ROMBEL_ID__') }}`.replace('__ROMBEL_ID__', rombelId);
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.id === 'addStudentModal') closeAddStudentModal();
    if (e.target.id === 'removeStudentModal') closeRemoveStudentModal();
    if (e.target.id === 'deleteModal') closeDeleteModal();
});
</script>
@endsection