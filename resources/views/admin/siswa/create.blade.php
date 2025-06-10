@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Siswa Baru</h1>
        <p class="text-gray-600">Lengkapi form di bawah untuk menambahkan siswa baru</p>
    </div>

    <form action="{{ route('admin.siswa.store') }}" method="POST" id="siswaForm">
        @csrf
        
        <!-- Student Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Siswa</h3>
            </div>
            
            <div>
                <label for="nis" class="block text-sm font-medium text-gray-700 mb-2">NIS *</label>
                <input type="text" name="nis" id="nis" value="{{ old('nis') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nis') border-red-500 @enderror" 
                       placeholder="Nomor Induk Siswa" required>
                @error('nis')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror" 
                       placeholder="Nama lengkap siswa" required>
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                <select name="jenis_kelamin" id="jenis_kelamin" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_kelamin') border-red-500 @enderror" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tempat_lahir') border-red-500 @enderror" 
                       placeholder="Tempat lahir" required>
                @error('tempat_lahir')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_lahir') border-red-500 @enderror" required>
                @error('tanggal_lahir')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="kelas" class="block text-sm font-medium text-gray-700 mb-2">Kelas *</label>
                <input type="text" name="kelas" id="kelas" value="{{ old('kelas') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kelas') border-red-500 @enderror" 
                       placeholder="Contoh: VII-A, VIII-B" required>
                @error('kelas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="tahun_masuk" class="block text-sm font-medium text-gray-700 mb-2">Tahun Masuk *</label>
                <input type="text" name="tahun_masuk" id="tahun_masuk" value="{{ old('tahun_masuk', date('Y')) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tahun_masuk') border-red-500 @enderror" 
                       placeholder="{{ date('Y') }}" required>
                @error('tahun_masuk')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select name="status" id="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="lulus" {{ old('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('telepon') border-red-500 @enderror" 
                       placeholder="Nomor telepon siswa">
                @error('telepon')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                <textarea name="alamat" id="alamat" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror" 
                          placeholder="Alamat lengkap siswa" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea name="catatan" id="catatan" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('catatan') border-red-500 @enderror" 
                          placeholder="Catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Guardian Information -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Wali</h3>
                <a href="{{ route('admin.siswa.create-wali') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition duration-200">
                    + Tambah Wali Baru
                </a>
            </div>
            
            <div id="waliContainer">
                <div class="wali-item border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-gray-700">Wali 1</h4>
                        <button type="button" class="remove-wali text-red-500 hover:text-red-700 hidden" onclick="removeWali(this)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Wali</label>
                            <select name="wali_ids[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Wali</option>
                                @foreach($walis as $wali)
                                    <option value="{{ $wali->wali_id }}">{{ $wali->nama }} ({{ $wali->user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hubungan</label>
                            <select name="hubungan[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="ayah">Ayah</option>
                                <option value="ibu">Ibu</option>
                                <option value="kakek">Kakek</option>
                                <option value="nenek">Nenek</option>
                                <option value="paman">Paman</option>
                                <option value="bibi">Bibi</option>
                                <option value="kakak">Kakak</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="button" id="addWali" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                + Tambah Wali Lain
            </button>
        </div>
        
        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.siswa.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                Simpan Siswa
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
let waliCount = 1;

document.getElementById('addWali').addEventListener('click', function() {
    waliCount++;
    const container = document.getElementById('waliContainer');
    
    const newWaliItem = document.createElement('div');
    newWaliItem.className = 'wali-item border border-gray-200 rounded-lg p-4 mb-4';
    newWaliItem.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <h4 class="font-medium text-gray-700">Wali ${waliCount}</h4>
            <button type="button" class="remove-wali text-red-500 hover:text-red-700" onclick="removeWali(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Wali</label>
                <select name="wali_ids[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Wali</option>
                    @foreach($walis as $wali)
                        <option value="{{ $wali->wali_id }}">{{ $wali->nama }} ({{ $wali->user->email }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hubungan</label>
                <select name="hubungan[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="ayah">Ayah</option>
                    <option value="ibu">Ibu</option>
                    <option value="kakek">Kakek</option>
                    <option value="nenek">Nenek</option>
                    <option value="paman">Paman</option>
                    <option value="bibi">Bibi</option>
                    <option value="kakak">Kakak</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
        </div>
    `;
    
    container.appendChild(newWaliItem);
    updateRemoveButtons();
});

function removeWali(button) {
    button.closest('.wali-item').remove();
    updateWaliNumbers();
    updateRemoveButtons();
}

function updateWaliNumbers() {
    const waliItems = document.querySelectorAll('.wali-item');
    waliItems.forEach((item, index) => {
        const title = item.querySelector('h4');
        title.textContent = `Wali ${index + 1}`;
    });
    waliCount = waliItems.length;
}

function updateRemoveButtons() {
    const removeButtons = document.querySelectorAll('.remove-wali');
    const waliItems = document.querySelectorAll('.wali-item');
    
    if (waliItems.length > 1) {
        removeButtons.forEach(button => {
            button.classList.remove('hidden');
        });
    } else {
        removeButtons.forEach(button => {
            button.classList.add('hidden');
        });
    }
}

// Form validation
document.getElementById('siswaForm').addEventListener('submit', function(e) {
    const waliSelects = document.querySelectorAll('select[name="wali_ids[]"]');
    const selectedWalis = [];
    let hasValidWali = false;
    
    waliSelects.forEach(select => {
        if (select.value) {
            if (selectedWalis.includes(select.value)) {
                e.preventDefault();
                alert('Wali yang sama tidak boleh dipilih lebih dari sekali!');
                return;
            }
            selectedWalis.push(select.value);
            hasValidWali = true;
        }
    });
    
    if (!hasValidWali) {
        e.preventDefault();
        alert('Minimal pilih satu wali untuk siswa!');
    }
});
</script>
@endsection