@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Guru</h1>
                <p class="text-gray-600">Informasi lengkap guru {{ $guru->nama }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.guru.edit', $guru->guru_id) }}" 
                   class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.guru.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Photo -->
        <div class="lg:col-span-1">
            <div class="bg-gray-50 rounded-lg p-6 text-center">
                @if($guru->foto)
                    <img src="{{ asset('uploads/guru/' . $guru->foto) }}" alt="Foto {{ $guru->nama }}" 
                         class="w-32 h-32 object-cover rounded-full mx-auto border-4 border-white shadow-lg">
                @else
                    <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto flex items-center justify-center border-4 border-white shadow-lg">
                        <i class="fas fa-user text-4xl text-gray-500"></i>
                    </div>
                @endif
                <h3 class="mt-4 text-xl font-semibold text-gray-800">{{ $guru->nama }}</h3>
                <p class="text-gray-600">{{ $guru->jabatan }}</p>
                <div class="mt-4 space-y-2">
                    @if($guru->nip)
                        <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                            NIP: {{ $guru->nip }}
                        </div>
                    @endif
                    @if($guru->nuptk)
                        <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                            NUPTK: {{ $guru->nuptk }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detailed Information -->
        <div class="lg:col-span-2">
            <!-- Personal Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-user mr-2"></i>Informasi Pribadi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                        <p class="text-gray-800 font-medium">{{ $guru->nama }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Lahir</label>
                        <p class="text-gray-800 font-medium">
                            {{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d F Y') : '-' }}
                            @if($guru->tanggal_lahir)
                                <span class="text-sm text-gray-500">
                                    ({{ \Carbon\Carbon::parse($guru->tanggal_lahir)->age }} tahun)
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nomor HP</label>
                        <p class="text-gray-800 font-medium">
                            <a href="tel:{{ $guru->nomor_hp }}" class="text-blue-600 hover:text-blue-800">
                                {{ $guru->nomor_hp }}
                            </a>
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                        <p class="text-gray-800 font-medium">
                            <a href="mailto:{{ $guru->email }}" class="text-blue-600 hover:text-blue-800">
                                {{ $guru->email }}
                            </a>
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Alamat</label>
                        <p class="text-gray-800 font-medium">{{ $guru->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-briefcase mr-2"></i>Informasi Kepegawaian
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jabatan</label>
                        <p class="text-gray-800 font-medium">{{ $guru->jabatan }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Tahun Masuk</label>
                        <p class="text-gray-800 font-medium">
                            {{ $guru->tahun_masuk }}
                            <span class="text-sm text-gray-500">
                                ({{ date('Y') - $guru->tahun_masuk }} tahun mengajar)
                            </span>
                        </p>
                    </div>
                    @if($guru->nip)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-600 mb-1">NIP</label>
                            <p class="text-gray-800 font-medium">{{ $guru->nip }}</p>
                        </div>
                    @endif
                    @if($guru->nuptk)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-600 mb-1">NUPTK</label>
                            <p class="text-gray-800 font-medium">{{ $guru->nuptk }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Account Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    <i class="fas fa-cog mr-2"></i>Informasi Akun
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Status Akun</label>
                        <p class="text-gray-800 font-medium">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                Aktif
                            </span>
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Terdaftar Sejak</label>
                        <p class="text-gray-800 font-medium">
                            {{ $guru->created_at ? $guru->created_at->format('d F Y') : '-' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Terakhir Diperbarui</label>
                        <p class="text-gray-800 font-medium">
                            {{ $guru->updated_at ? $guru->updated_at->format('d F Y H:i') : '-' }}
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
                <a href="{{ route('admin.guru.edit', $guru->guru_id) }}" 
                   class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Data
                </a>
                {{-- <button type="button" onclick="printProfile()" 
                        class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-200">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button> --}}
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
                Apakah Anda yakin ingin menghapus data guru <strong>{{ $guru->nama }}</strong>? 
                Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeDeleteModal()" 
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Batal
            </button>
            <form action="{{ route('admin.guru.destroy', $guru->guru_id) }}" method="POST" class="inline">
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

    function printProfile() {
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

@endsection