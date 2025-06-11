@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Rombel</h1>
            <p class="text-gray-600">Perbarui data rombongan belajar "{{ $rombel->nama_rombel }}"</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.rombel.show', $rombel->rombel_id) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat Detail
            </a>
            <a href="{{ route('admin.rombel.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Current Student Count Warning -->
    @if($rombel->siswas->count() > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Perhatian:</strong> Rombel ini memiliki {{ $rombel->siswas->count() }} siswa aktif. 
                        Kapasitas maksimal tidak boleh kurang dari jumlah siswa saat ini.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.rombel.update', $rombel->rombel_id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Rombel -->
            <div>
                <label for="nama_rombel" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Rombel <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama_rombel" 
                       name="nama_rombel" 
                       value="{{ old('nama_rombel', $rombel->nama_rombel) }}"
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
                                {{ old('kelas_id', $rombel->kelas_id) == $kelasItem->kelas_id ? 'selected' : '' }}>
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
                                {{ old('tahun_ajaran', $rombel->tahun_ajaran) == $tahunAjaran ? 'selected' : '' }}>
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
                       value="{{ old('kapasitas_maksimal', $rombel->kapasitas_maksimal) }}"
                       min="{{ $rombel->siswas->count() }}" 
                       max="50"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kapasitas_maksimal') border-red-500 @enderror"
                       placeholder="Maksimal 50 siswa">
                @error('kapasitas_maksimal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if($rombel->siswas->count() > 0)
                    <p class="mt-1 text-sm text-gray-500">
                        Minimal {{ $rombel->siswas->count() }} (jumlah siswa saat ini)
                    </p>
                @else
                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ada batasan</p>
                @endif
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
                                {{ old('wali_kelas_id', $rombel->wali_kelas_id) == $guru->guru_id ? 'selected' : '' }}>
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
                @if($rombel->waliKelas)
                    <p class="mt-1 text-sm text-blue-600">
                        Wali kelas saat ini: {{ $rombel->waliKelas->nama_lengkap }}
                    </p>
                @endif
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>
                <select id="status" 
                        name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                    <option value="aktif" {{ old('status', $rombel->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status', $rombel->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if($rombel->status == 'tidak_aktif' && $rombel->siswas->count() > 0)
                    <p class="mt-1 text-sm text-yellow-600">
                        <strong>Perhatian:</strong> Mengubah status menjadi tidak aktif akan mempengaruhi siswa yang terdaftar.
                    </p>
                @endif
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
                      placeholder="Deskripsi atau catatan tambahan tentang rombel ini...">{{ old('deskripsi', $rombel->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Current Information Summary -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Informasi Saat Ini</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-700">Jumlah Siswa:</span>
                    <span class="text-gray-900">{{ $rombel->siswas->count() }} siswa</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Kelas Saat Ini:</span>
                    <span class="text-gray-900">{{ $rombel->kelas->nama_kelas ?? 'Tidak ada' }}</span>
                </div>
                <div>
                    <span class="font-medium text-gray-700">Dibuat:</span>
                    <span class="text-gray-900">{{ $rombel->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.rombel.show', $rombel->rombel_id) }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Perbarui Rombel
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate capacity against current student count
    const kapasitasInput = document.getElementById('kapasitas_maksimal');
    const currentStudentCount = {{ $rombel->siswas->count() }};
    
    kapasitasInput.addEventListener('input', function() {
        const value = parseInt(this.value);
        if (value > 50) {
            this.value = 50;
        } else if (value < currentStudentCount && this.value !== '') {
            this.value = currentStudentCount;
            alert(`Kapasitas tidak boleh kurang dari ${currentStudentCount} (jumlah siswa saat ini)`);
        }
    });
    
    // Warn about status change
    const statusSelect = document.getElementById('status');
    const originalStatus = '{{ $rombel->status }}';
    
    statusSelect.addEventListener('change', function() {
        if (originalStatus === 'aktif' && this.value === 'tidak_aktif' && currentStudentCount > 0) {
            if (!confirm(`Mengubah status menjadi tidak aktif akan mempengaruhi ${currentStudentCount} siswa yang terdaftar. Lanjutkan?`)) {
                this.value = originalStatus;
            }
        }
    });
});
</script>
@endsection