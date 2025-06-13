@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.kelas.index') }}" 
               class="text-gray-600 hover:text-gray-800 mr-4 transition duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Kelas Baru</h1>
                <p class="text-gray-600">Lengkapi form di bawah untuk menambahkan kelas baru</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Kelas -->
            <div>
                <label for="nama_kelas" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kelas <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama_kelas" 
                       name="nama_kelas" 
                       value="{{ old('nama_kelas') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_kelas') border-red-500 @enderror"
                       placeholder="Contoh: 1A, 2B, 3C"
                       required>
                @error('nama_kelas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Format: [Tingkat][Huruf], contoh: 1A, 2B, 3C</p>
            </div>

            <!-- Tingkat -->
            <div>
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
            <div>
                <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun Ajaran <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="tahun_ajaran" 
                       name="tahun_ajaran" 
                       value="{{ old('tahun_ajaran', date('Y') . '/' . (date('Y') + 1)) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tahun_ajaran') border-red-500 @enderror"
                       placeholder="2024/2025"
                       pattern="[0-9]{4}/[0-9]{4}"
                       required>
                @error('tahun_ajaran')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Format: YYYY/YYYY, contoh: 2024/2025</p>
            </div>

            <!-- Kurikulum -->
            <div>
                <label for="kurikulum_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Kurikulum <span class="text-red-500">*</span>
                </label>
                <select id="kurikulum_id" 
                        name="kurikulum_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kurikulum_id') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Kurikulum</option>
                    @foreach($kurikulums as $kurikulum)
                        <option value="{{ $kurikulum->kurikulum_id }}" 
                                {{ old('kurikulum_id') == $kurikulum->kurikulum_id ? 'selected' : '' }}>
                            {{ $kurikulum->nama_kurikulum }} ({{ $kurikulum->tahun_kurikulum }})
                        </option>
                    @endforeach
                </select>
                @error('kurikulum_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kapasitas -->
            <div>
                <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-2">
                    Kapasitas Siswa <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="kapasitas" 
                       name="kapasitas" 
                       value="{{ old('kapasitas', 30) }}"
                       min="1" 
                       max="50"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kapasitas') border-red-500 @enderror"
                       required>
                @error('kapasitas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Maksimal 50 siswa per kelas</p>
            </div>

            <!-- Status -->
            <div>
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

        <!-- Keterangan -->
        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                Keterangan
            </label>
            <textarea id="keterangan" 
                      name="keterangan" 
                      rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('keterangan') border-red-500 @enderror"
                      placeholder="Keterangan tambahan tentang kelas (opsional)">{{ old('keterangan') }}</textarea>
            @error('keterangan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Preview Card -->
        <div id="previewCard" class="bg-gray-50 border border-gray-200 rounded-lg p-4 hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Preview Kelas</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Nama:</span>
                    <span id="preview-nama" class="font-medium ml-2">-</span>
                </div>
                <div>
                    <span class="text-gray-600">Tingkat:</span>
                    <span id="preview-tingkat" class="font-medium ml-2">-</span>
                </div>
                <div>
                    <span class="text-gray-600">Tahun:</span>
                    <span id="preview-tahun" class="font-medium ml-2">-</span>
                </div>
                <div>
                    <span class="text-gray-600">Kapasitas:</span>
                    <span id="preview-kapasitas" class="font-medium ml-2">-</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
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
@endsection

@section('scripts')
<script>
    // Auto-generate nama kelas based on tingkat
    document.getElementById('tingkat').addEventListener('change', function() {
        const tingkat = this.value;
        const namaKelasInput = document.getElementById('nama_kelas');
        
        if (tingkat && !namaKelasInput.value) {
            namaKelasInput.value = tingkat + 'A';
        }
        updatePreview();
    });

    // Format tahun ajaran input
    document.getElementById('tahun_ajaran').addEventListener('input', function() {
        let value = this.value.replace(/[^0-9]/g, '');
        if (value.length >= 4) {
            value = value.substring(0, 4) + '/' + value.substring(4, 8);
        }
        this.value = value;
        updatePreview();
    });

    // Update preview on input changes
    ['nama_kelas', 'tingkat', 'tahun_ajaran', 'kapasitas'].forEach(function(fieldId) {
        document.getElementById(fieldId).addEventListener('input', updatePreview);
    });

    function updatePreview() {
        const nama = document.getElementById('nama_kelas').value;
        const tingkat = document.getElementById('tingkat').value;
        const tahun = document.getElementById('tahun_ajaran').value;
        const kapasitas = document.getElementById('kapasitas').value;
        
        if (nama || tingkat || tahun || kapasitas) {
            document.getElementById('previewCard').classList.remove('hidden');
            document.getElementById('preview-nama').textContent = nama || '-';
            document.getElementById('preview-tingkat').textContent = tingkat ? 'Kelas ' + tingkat : '-';
            document.getElementById('preview-tahun').textContent = tahun || '-';
            document.getElementById('preview-kapasitas').textContent = kapasitas ? kapasitas + ' siswa' : '-';
        } else {
            document.getElementById('previewCard').classList.add('hidden');
        }
    }

    // Validate form before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const namaKelas = document.getElementById('nama_kelas').value;
        const tingkat = document.getElementById('tingkat').value;
        const tahunAjaran = document.getElementById('tahun_ajaran').value;
        
        // Check if nama kelas matches tingkat
        if (namaKelas && tingkat) {
            const expectedPrefix = tingkat;
            if (!namaKelas.startsWith(expectedPrefix)) {
                e.preventDefault();
                alert('Nama kelas harus dimulai dengan tingkat yang dipilih. Contoh: ' + tingkat + 'A');
                return false;
            }
        }
        
        // Validate tahun ajaran format
        const tahunPattern = /^[0-9]{4}\/[0-9]{4}$/;
        if (tahunAjaran && !tahunPattern.test(tahunAjaran)) {
            e.preventDefault();
            alert('Format tahun ajaran tidak valid. Gunakan format YYYY/YYYY');
            return false;
        }
        
        // Check if second year is exactly one year after first year
        if (tahunAjaran && tahunPattern.test(tahunAjaran)) {
            const [year1, year2] = tahunAjaran.split('/').map(Number);
            if (year2 !== year1 + 1) {
                e.preventDefault();
                alert('Tahun kedua harus tepat satu tahun setelah tahun pertama');
                return false;
            }
        }
    });

    // Initialize preview on page load
    updatePreview();
</script>
@endsection