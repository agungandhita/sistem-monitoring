@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Mata Pelajaran</h1>
                <p class="text-gray-600">Informasi lengkap mata pelajaran {{ $mapel->mapel }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.mapel.edit', $mapel->mapel_id) }}" 
                   class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.mapel.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Subject Icon & Basic Info -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-6 text-center">
                <div class="w-24 h-24 bg-blue-500 rounded-full mx-auto flex items-center justify-center mb-4 shadow-lg">
                    <span class="text-2xl font-bold text-white">{{ substr($mapel->kode_mapel, 0, 2) }}</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $mapel->mapel }}</h3>
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium inline-block">
                    {{ $mapel->kode_mapel }}
                </div>
                
                <!-- Quick Stats -->
                <div class="mt-6 space-y-3">
                    <div class="bg-white rounded-lg p-3 shadow-sm">
                        <div class="text-2xl font-bold text-blue-600">{{ $mapel->gurus ? $mapel->gurus->count() : 0 }}</div>
                        <div class="text-sm text-gray-600">Guru Pengampu</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information -->
        <div class="lg:col-span-2">
            <!-- Basic Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Dasar
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Kode Mata Pelajaran</label>
                        <p class="text-gray-800 font-medium text-lg">{{ $mapel->kode_mapel }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Mata Pelajaran</label>
                        <p class="text-gray-800 font-medium text-lg">{{ $mapel->mapel }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi</label>
                        <p class="text-gray-800">{{ $mapel->deskripsi ?: 'Tidak ada deskripsi untuk mata pelajaran ini.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Teachers Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>Guru Pengampu
                    <span class="text-sm font-normal text-gray-500">({{ $mapel->gurus ? $mapel->gurus->count() : 0 }} guru)</span>
                </h3>
                
                @if($mapel->gurus && $mapel->gurus->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($mapel->gurus as $guru)
                        <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-200">
                            <div class="flex items-center space-x-3">
                                @if($guru->foto)
                                    <img src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                @else
                                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-gray-500"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $guru->nama }}</h4>
                                    <p class="text-sm text-gray-600">{{ $guru->jabatan }}</p>
                                    @if($guru->email)
                                        <p class="text-xs text-blue-600">
                                            <a href="mailto:{{ $guru->email }}" class="hover:underline">{{ $guru->email }}</a>
                                        </p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    @if($guru->nip)
                                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                            NIP: {{ $guru->nip }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-slash text-2xl text-gray-400"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Guru Pengampu</h4>
                        <p class="text-gray-500 mb-4">Mata pelajaran ini belum memiliki guru pengampu.</p>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Guru Pengampu
                        </button>
                    </div>
                @endif
            </div>

            <!-- System Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-cog mr-2"></i>Informasi Sistem
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">ID Mata Pelajaran</label>
                        <p class="text-gray-800 font-medium">#{{ $mapel->mapel_id }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                            Aktif
                        </span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Dibuat</label>
                        <p class="text-gray-800 font-medium">
                            {{ $mapel->created_at ? $mapel->created_at->format('d F Y H:i') : '-' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Terakhir Diperbarui</label>
                        <p class="text-gray-800 font-medium">
                            {{ $mapel->updated_at ? $mapel->updated_at->format('d F Y H:i') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 pt-6 border-t">
        <div class="flex justify-between items-center">
            <div class="flex space-x-3">
                <a href="{{ route('admin.mapel.edit', $mapel->mapel_id) }}" 
                   class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Data
                </a>
                <button type="button" onclick="printDetail()" 
                        class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button>
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="confirmDelete()" 
                        class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-200">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
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
            <p class="text-sm text-gray-500">
                Apakah Anda yakin ingin menghapus mata pelajaran <strong>{{ $mapel->mapel }}</strong>? 
                @if($mapel->gurus && $mapel->gurus->count() > 0)
                    <br><br>
                    <span class="text-orange-600 font-medium">
                        Peringatan: Mata pelajaran ini memiliki {{ $mapel->gurus->count() }} guru pengampu. 
                        Menghapus mata pelajaran akan memutus hubungan dengan guru-guru tersebut.
                    </span>
                @endif
                <br><br>
                Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeDeleteModal()" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Batal
            </button>
            <form action="{{ route('admin.mapel.destroy', $mapel->mapel_id) }}" method="POST" class="inline">
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
    function confirmDelete() {
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
    }
</style>
@endsection