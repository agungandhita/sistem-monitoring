@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.kelas.show', $kelas->kelas_id) }}" 
               class="text-gray-600 hover:text-gray-800 mr-4 transition duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Kelas {{ $kelas->nama_kelas }}</h1>
                <p class="text-gray-600">Perbarui informasi kelas</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.kelas.update', $kelas->kelas_id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Kelas -->
            <div>
                <label for="nama_kelas" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kelas <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama_kelas" 
                       name="nama_kelas" 
                       value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
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
                        <option value="{{ $i }}" {{ old('tingkat', $kelas->tingkat) == $i ? 'selected' : '' }}>
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
                       value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}"
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
                                {{ old('kurikulum_id', $kelas->kurikulum_id) == $kurikulum->kurikulum_id ? 'selected' : '' }}>
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
                       value="{{ old('kapasitas', $kelas->kapasitas) }}"
                       min="1" 
                       max="50"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kapasitas') border-red-500 @enderror"
                       required>
                @error('kapasitas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">
                    Maksimal 50 siswa per kelas. 
                    @if($kelas->total_siswa > 0)
                        <span class="text-orange-600 font-medium">Saat ini ada {{ $kelas->total_siswa }} siswa di kelas ini.</span>
                    @endif
                </p>
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
                    <option value="aktif" {{ old('status', $kelas->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $kelas->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
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
                      placeholder="Keterangan tambahan tentang kelas (opsional)">{{ old('keterangan', $kelas->keterangan) }}</textarea>
            @error('keterangan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Current vs New Comparison -->
        <div id="comparisonCard" class="bg-gray-50 border border-gray-200 rounded-lg p-4 hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Perbandingan Perubahan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-medium text-gray-700 mb-2">Data Saat Ini</h4>
                    <div class="bg-white p-3 rounded border text-sm space-y-1">
                        <div><span class="text-gray-600">Nama:</span> <span class="font-medium">{{ $kelas->nama_kelas }}</span></div>
                        <div><span class="text-gray-600">Tingkat:</span> <span class="font-medium">Kelas {{ $kelas->tingkat }}</span></div>
                        <div><span class="text-gray-600">Tahun:</span> <span class="font-medium">{{ $kelas->tahun_ajaran }}</span></div>
                        <div><span class="text-gray-600">Kapasitas:</span> <span class="font-medium">{{ $kelas->kapasitas }} siswa</span></div>
                    </div>
                </div>
                <div>
                    <h4 class="font-medium text-gray-700 mb-2">Data Baru</h4>
                    <div class="bg-blue-50 p-3 rounded border text-sm space-y-1">
                        <div><span class="text-gray-600">Nama:</span> <span id="new-nama" class="font-medium">-</span></div>
                        <div><span class="text-gray-600">Tingkat:</span> <span id="new-tingkat" class="font-medium">-</span></div>
                        <div><span class="text-gray-600">Tahun:</span> <span id="new-tahun" class="font-medium">-</span></div>
                        <div><span class="text-gray-600">Kapasitas:</span> <span id="new-kapasitas" class="font-medium">-</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning for Capacity Reduction -->
        <div id="capacityWarning" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 hidden">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-yellow-800">Peringatan Kapasitas</h3>
                    <p class="text-sm text-yellow-700 mt-1">
                        Kapasitas baru lebih kecil dari jumlah siswa saat ini ({{ $kelas->total_siswa }} siswa). 
                        Pastikan untuk memindahkan siswa terlebih dahulu sebelum mengurangi kapasitas.
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.kelas.show', $kelas->kelas_id) }}" 
               class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Kelas
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const originalData = {
        nama_kelas: '{{ $kelas->nama_kelas }}',
        tingkat: '{{ $kelas->tingkat }}',
        tahun_ajaran: '{{ $kelas->tahun_ajaran }}',
        kapasitas: {{ $kelas->kapasitas }},
        total_siswa: {{ $kelas->total_siswa }}
    };

    // Auto-generate nama kelas based on tingkat
    document.getElementById('tingkat').addEventListener('change', function() {
        const tingkat = this.value;
        const namaKelasInput = document.getElementById('nama_kelas');
        const currentNama = namaKelasInput.value;
        
        // Only auto-generate if current name follows the pattern or is empty
        if (tingkat && (!currentNama || /^[1-6][A-Z]?$/.test(currentNama))) {
            const suffix = currentNama ? currentNama.slice(1) : 'A';
            namaKelasInput.value = tingkat + suffix;
        }
        updateComparison();
    });

    // Format tahun ajaran input
    document.getElementById('tahun_ajaran').addEventListener('input', function() {
        let value = this.value.replace(/[^0-9]/g, '');
        if (value.length >= 4) {
            value = value.substring(0, 4) + '/' + value.substring(4, 8);
        }
        this.value = value;
        updateComparison();
    });

    // Check capacity changes
    document.getElementById('kapasitas').addEventListener('input', function() {
        const newCapacity = parseInt(this.value);
        const warningDiv = document.getElementById('capacityWarning');
        
        if (newCapacity && newCapacity < originalData.total_siswa) {
            warningDiv.classList.remove('hidden');
        } else {
            warningDiv.classList.add('hidden');
        }
        updateComparison();
    });

    // Update comparison on input changes
    ['nama_kelas', 'tingkat', 'tahun_ajaran', 'kapasitas'].forEach(function(fieldId) {
        document.getElementById(fieldId).addEventListener('input', updateComparison);
    });

    function updateComparison() {
        const nama = document.getElementById('nama_kelas').value;
        const tingkat = document.getElementById('tingkat').value;
        const tahun = document.getElementById('tahun_ajaran').value;
        const kapasitas = document.getElementById('kapasitas').value;
        
        // Check if any field has changed
        const hasChanges = nama !== originalData.nama_kelas ||
                          tingkat !== originalData.tingkat.toString() ||
                          tahun !== originalData.tahun_ajaran ||
                          kapasitas !== originalData.kapasitas.toString();
        
        const comparisonCard = document.getElementById('comparisonCard');
        
        if (hasChanges) {
            comparisonCard.classList.remove('hidden');
            document.getElementById('new-nama').textContent = nama || '-';
            document.getElementById('new-tingkat').textContent = tingkat ? 'Kelas ' + tingkat : '-';
            document.getElementById('new-tahun').textContent = tahun || '-';
            document.getElementById('new-kapasitas').textContent = kapasitas ? kapasitas + ' siswa' : '-';
        } else {
            comparisonCard.classList.add('hidden');
        }
    }

    // Validate form before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const namaKelas = document.getElementById('nama_kelas').value;
        const tingkat = document.getElementById('tingkat').value;
        const tahunAjaran = document.getElementById('tahun_ajaran').value;
        const kapasitas = parseInt(document.getElementById('kapasitas').value);
        
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
        
        // Warn about capacity reduction
        if (kapasitas && kapasitas < originalData.total_siswa) {
            const confirmed = confirm(
                `Kapasitas baru (${kapasitas}) lebih kecil dari jumlah siswa saat ini (${originalData.total_siswa}). ` +
                'Pastikan Anda telah memindahkan siswa yang berlebih. Lanjutkan?'
            );
            if (!confirmed) {
                e.preventDefault();
                return false;
            }
        }
    });

    // Initialize comparison on page load
    updateComparison();
</script>
@endsection