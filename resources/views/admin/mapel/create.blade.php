@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Mata Pelajaran</h1>
        <p class="text-gray-600">Lengkapi form di bawah untuk menambahkan mata pelajaran baru</p>
    </div>

    <form action="{{ route('admin.mapel.store') }}" method="POST" id="mapelForm">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Mata Pelajaran</h3>
            </div>
            
            <div>
                <label for="kurikulum_id" class="block text-sm font-medium text-gray-700 mb-2">Kurikulum *</label>
                <select name="kurikulum_id" id="kurikulum_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kurikulum_id') border-red-500 @enderror" required>
                    <option value="">Pilih Kurikulum</option>
                    @foreach($kurikulums as $kurikulum)
                        <option value="{{ $kurikulum->kurikulum_id }}" {{ old('kurikulum_id') == $kurikulum->kurikulum_id ? 'selected' : '' }}>
                            {{ $kurikulum->nama_kurikulum }} - {{ $kurikulum->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
                @error('kurikulum_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="kode_mapel" class="block text-sm font-medium text-gray-700 mb-2">Kode Mata Pelajaran *</label>
                <input type="text" name="kode_mapel" id="kode_mapel" value="{{ old('kode_mapel') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kode_mapel') border-red-500 @enderror" 
                       placeholder="Contoh: MTK, IPA, IPS" maxlength="10" required>
                <p class="mt-1 text-xs text-gray-500">Maksimal 10 karakter, gunakan singkatan yang mudah diingat</p>
                @error('kode_mapel')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="mapel" class="block text-sm font-medium text-gray-700 mb-2">Nama Mata Pelajaran *</label>
                <input type="text" name="mapel" id="mapel" value="{{ old('mapel') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('mapel') border-red-500 @enderror" 
                       placeholder="Contoh: Matematika, Ilmu Pengetahuan Alam" required>
                @error('mapel')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror" 
                          placeholder="Deskripsi singkat tentang mata pelajaran ini (opsional)">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Preview Section -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg" id="previewSection" style="display: none;">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Preview</h3>
            <div class="flex items-center space-x-4">
                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <span class="text-sm font-medium text-blue-800" id="previewIcon">--</span>
                </div>
                <div>
                    <div class="text-lg font-medium text-gray-900" id="previewNama">Nama Mata Pelajaran</div>
                    <div class="text-sm text-gray-600" id="previewKode">Kode Mata Pelajaran</div>
                    <div class="text-sm text-gray-500" id="previewDeskripsi">Deskripsi mata pelajaran</div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3 pt-6 border-t">
            <a href="{{ route('admin.mapel.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Auto-generate kode from nama mapel
    document.getElementById('mapel').addEventListener('input', function() {
        const namaMapel = this.value;
        const kodeInput = document.getElementById('kode_mapel');
        
        if (namaMapel && !kodeInput.value) {
            // Generate kode from first letters of each word
            const words = namaMapel.split(' ');
            let kode = '';
            
            words.forEach(word => {
                if (word.length > 0) {
                    kode += word.charAt(0).toUpperCase();
                }
            });
            
            // Limit to 10 characters
            kode = kode.substring(0, 10);
            kodeInput.value = kode;
        }
        
        updatePreview();
    });

    // Update preview when inputs change
    document.getElementById('kode_mapel').addEventListener('input', updatePreview);
    document.getElementById('deskripsi').addEventListener('input', updatePreview);

    function updatePreview() {
        const kode = document.getElementById('kode_mapel').value;
        const nama = document.getElementById('mapel').value;
        const deskripsi = document.getElementById('deskripsi').value;
        
        const previewSection = document.getElementById('previewSection');
        const previewIcon = document.getElementById('previewIcon');
        const previewNama = document.getElementById('previewNama');
        const previewKode = document.getElementById('previewKode');
        const previewDeskripsi = document.getElementById('previewDeskripsi');
        
        if (kode || nama) {
            previewSection.style.display = 'block';
            previewIcon.textContent = kode ? kode.substring(0, 2) : '--';
            previewNama.textContent = nama || 'Nama Mata Pelajaran';
            previewKode.textContent = kode || 'Kode Mata Pelajaran';
            previewDeskripsi.textContent = deskripsi || 'Deskripsi mata pelajaran';
        } else {
            previewSection.style.display = 'none';
        }
    }

    // Form validation
    document.getElementById('mapelForm').addEventListener('submit', function(e) {
        const kode = document.getElementById('kode_mapel').value.trim();
        const nama = document.getElementById('mapel').value.trim();
        
        if (!kode || !nama) {
            e.preventDefault();
            alert('Kode mata pelajaran dan nama mata pelajaran wajib diisi');
            return;
        }
        
        if (kode.length > 10) {
            e.preventDefault();
            alert('Kode mata pelajaran maksimal 10 karakter');
            return;
        }
    });

    // Auto uppercase for kode
    document.getElementById('kode_mapel').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Character counter for kode
    document.getElementById('kode_mapel').addEventListener('input', function() {
        const maxLength = 10;
        const currentLength = this.value.length;
        const parent = this.parentNode;
        
        // Remove existing counter
        const existingCounter = parent.querySelector('.char-counter');
        if (existingCounter) {
            existingCounter.remove();
        }
        
        // Add new counter
        const counter = document.createElement('p');
        counter.className = 'mt-1 text-xs text-gray-500 char-counter';
        counter.textContent = `${currentLength}/${maxLength} karakter`;
        
        if (currentLength > maxLength) {
            counter.className = 'mt-1 text-xs text-red-500 char-counter';
        }
        
        parent.appendChild(counter);
    });
</script>
@endsection