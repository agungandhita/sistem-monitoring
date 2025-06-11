@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Rombel</h1>
            <p class="text-gray-600">Buat rombongan belajar baru</p>
        </div>
        <div>
            <a href="{{ route('admin.rombel.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('admin.rombel.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Rombel -->
            <div>
                <label for="nama_rombel" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Rombel <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama_rombel" 
                       name="nama_rombel" 
                       value="{{ old('nama_rombel') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_rombel') border-red-500 @enderror"
                       placeholder="Contoh: 7A, 8B, 9C"
                       required>
                @error('nama_rombel')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kelas -->
            <div>
                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Kelas <span class="text-red-500">*</span>
                </label>
                <select id="kelas_id" 
                        name="kelas_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kelas_id') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $kelasItem)
                        <option value="{{ $kelasItem->kelas_id }}" 
                                {{ old('kelas_id') == $kelasItem->kelas_id ? 'selected' : '' }}>
                            {{ $kelasItem->nama_kelas }} - Tingkat {{ $kelasItem->tingkat }}
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tahun Ajaran -->
            <div>
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
                        <option value="{{ $tahunAjaran }}" 
                                {{ old('tahun_ajaran') == $tahunAjaran ? 'selected' : '' }}>
                            {{ $tahunAjaran }}
                        </option>
                    @endfor
                </select>
                @error('tahun_ajaran')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kapasitas Maksimal -->
            <div>
                <label for="kapasitas_maksimal" class="block text-sm font-medium text-gray-700 mb-2">
                    Kapasitas Maksimal
                </label>
                <input type="number" 
                       id="kapasitas_maksimal" 
                       name="kapasitas_maksimal" 
                       value="{{ old('kapasitas_maksimal', 30) }}"
                       min="1" 
                       max="50"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kapasitas_maksimal') border-red-500 @enderror"
                       placeholder="Maksimal 50 siswa">
                @error('kapasitas_maksimal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ada batasan</p>
            </div>

            <!-- Wali Kelas -->
            <div>
                <label for="wali_kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Wali Kelas
                </label>
                <select id="wali_kelas_id" 
                        name="wali_kelas_id" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('wali_kelas_id') border-red-500 @enderror">
                    <option value="">Pilih Wali Kelas (Opsional)</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->guru_id }}" 
                                {{ old('wali_kelas_id') == $guru->guru_id ? 'selected' : '' }}>
                            {{ $guru->nama_lengkap }} 
                            @if($guru->nip)
                                - {{ $guru->nip }}
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('wali_kelas_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>
                <select id="status" 
                        name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
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
                      placeholder="Deskripsi atau catatan tambahan tentang rombel ini...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.rombel.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Rombel
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate rombel name based on selected class
    const kelasSelect = document.getElementById('kelas_id');
    const namaRombelInput = document.getElementById('nama_rombel');
    
    kelasSelect.addEventListener('change', function() {
        if (this.value && !namaRombelInput.value) {
            const selectedOption = this.options[this.selectedIndex];
            const kelasName = selectedOption.text.split(' - ')[0];
            
            // Suggest a name based on class (e.g., "7" becomes "7A")
            const tingkat = kelasName.replace(/[^0-9]/g, '');
            if (tingkat) {
                namaRombelInput.value = tingkat + 'A';
            }
        }
    });
    
    // Validate capacity
    const kapasitasInput = document.getElementById('kapasitas_maksimal');
    kapasitasInput.addEventListener('input', function() {
        const value = parseInt(this.value);
        if (value > 50) {
            this.value = 50;
        } else if (value < 1 && this.value !== '') {
            this.value = 1;
        }
    });
});
</script>
@endsection