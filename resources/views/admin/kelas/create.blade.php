@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.kelas.index') }}" 
               class="text-gray-600 hover:text-gray-800 transition duration-200 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Kelas Baru</h1>
                <p class="text-gray-600">Isi form di bawah untuk menambahkan kelas baru</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Kelas -->
            <div class="col-span-1">
                <label for="nama_kelas" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kelas <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama_kelas" 
                       name="nama_kelas" 
                       value="{{ old('nama_kelas') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_kelas') border-red-500 @enderror"
                       placeholder="Contoh: A, B, IPA 1, IPS 1"
                       required>
                @error('nama_kelas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Nama kelas harus unik untuk setiap tingkat dan tahun ajaran</p>
            </div>

            <!-- Tingkat -->
            <div class="col-span-1">
                <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-2">
                    Tingkat <span class="text-red-500">*</span>
                </label>
                <select id="tingkat" 
                        name="tingkat" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tingkat') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Tingkat</option>
                    @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ old('tingkat') == $i ? 'selected' : '' }}>
                            Kelas {{ $i }}
                        </option>
                    @endfor
                </select>
                @error('tingkat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tahun Ajaran -->
            <div class="col-span-1">
                <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun Ajaran <span class="text-red-500">*</span>
                </label>
                <select id="tahun_ajaran" 
                        name="tahun_ajaran" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tahun_ajaran') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Tahun Ajaran</option>
                    @php
                        $currentYear = date('Y');
                        $startYear = $currentYear - 2;
                        $endYear = $currentYear + 3;
                    @endphp
                    @for($year = $startYear; $year <= $endYear; $year++)
                        @php
                            $tahunAjaran = $year . '/' . ($year + 1);
                        @endphp
                        <option value="{{ $tahunAjaran }}" {{ old('tahun_ajaran') == $tahunAjaran ? 'selected' : '' }}>
                            {{ $tahunAjaran }}
                        </option>
                    @endfor
                </select>
                @error('tahun_ajaran')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kapasitas Maksimal -->
            <div class="col-span-1">
                <label for="kapasitas_maksimal" class="block text-sm font-medium text-gray-700 mb-2">
                    Kapasitas Maksimal
                </label>
                <input type="number" 
                       id="kapasitas_maksimal" 
                       name="kapasitas_maksimal" 
                       value="{{ old('kapasitas_maksimal') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kapasitas_maksimal') border-red-500 @enderror"
                       placeholder="Kosongkan jika tidak terbatas"
                       min="1">
                @error('kapasitas_maksimal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Batas maksimal jumlah rombel dalam kelas ini</p>
            </div>

            <!-- Status -->
            <div class="col-span-1">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" 
                        name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                        required>
                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi
            </label>
            <textarea id="deskripsi" 
                      name="deskripsi" 
                      rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                      placeholder="Deskripsi tambahan tentang kelas ini (opsional)">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.kelas.index') }}" 
               class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Kelas
            </button>
        </div>
    </form>
</div>

<!-- Preview Card -->
<div class="bg-white rounded-lg shadow-md p-6 mt-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Preview Kelas</h3>
    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-12 w-12">
                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-blue-600 font-medium" id="previewIcon">
                        --
                    </span>
                </div>
            </div>
            <div class="ml-4">
                <div class="text-lg font-medium text-gray-900" id="previewNama">
                    Nama Kelas
                </div>
                <div class="text-sm text-gray-500">
                    <span id="previewTingkat">Tingkat</span> • 
                    <span id="previewTahun">Tahun Ajaran</span> • 
                    <span id="previewStatus">Status</span>
                </div>
                <div class="text-sm text-gray-600 mt-1" id="previewDeskripsi">
                    Deskripsi kelas
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Live preview functionality
    function updatePreview() {
        const namaKelas = document.getElementById('nama_kelas').value || 'Nama Kelas';
        const tingkat = document.getElementById('tingkat').value;
        const tahunAjaran = document.getElementById('tahun_ajaran').value || 'Tahun Ajaran';
        const status = document.getElementById('status').value || 'aktif';
        const deskripsi = document.getElementById('deskripsi').value || 'Deskripsi kelas';
        
        // Update preview elements
        document.getElementById('previewNama').textContent = namaKelas;
        document.getElementById('previewTingkat').textContent = tingkat ? `Kelas ${tingkat}` : 'Tingkat';
        document.getElementById('previewTahun').textContent = tahunAjaran;
        document.getElementById('previewStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ');
        document.getElementById('previewDeskripsi').textContent = deskripsi;
        
        // Update icon
        const icon = tingkat && namaKelas ? `${tingkat}${namaKelas.charAt(0).toUpperCase()}` : '--';
        document.getElementById('previewIcon').textContent = icon;
    }
    
    // Add event listeners for live preview
    document.getElementById('nama_kelas').addEventListener('input', updatePreview);
    document.getElementById('tingkat').addEventListener('change', updatePreview);
    document.getElementById('tahun_ajaran').addEventListener('change', updatePreview);
    document.getElementById('status').addEventListener('change', updatePreview);
    document.getElementById('deskripsi').addEventListener('input', updatePreview);
    
    // Initialize preview
    updatePreview();
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const namaKelas = document.getElementById('nama_kelas').value.trim();
        const tingkat = document.getElementById('tingkat').value;
        const tahunAjaran = document.getElementById('tahun_ajaran').value;
        
        if (!namaKelas || !tingkat || !tahunAjaran) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }
    });
</script>
@endsection