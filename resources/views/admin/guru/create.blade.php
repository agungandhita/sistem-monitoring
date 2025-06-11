@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Guru Baru</h1>
        <p class="text-gray-600">Lengkapi form di bawah untuk menambahkan guru baru</p>
    </div>

    <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data" id="guruForm">
        @csrf
        
        <!-- Teacher Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Guru</h3>
            </div>
            
            <div>
                <label for="nuptk" class="block text-sm font-medium text-gray-700 mb-2">NUPTK</label>
                <input type="text" name="nuptk" id="nuptk" value="{{ old('nuptk') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nuptk') border-red-500 @enderror" 
                       placeholder="Nomor Unik Pendidik dan Tenaga Kependidikan">
                @error('nuptk')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                <input type="text" name="nip" id="nip" value="{{ old('nip') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nip') border-red-500 @enderror" 
                       placeholder="Nomor Induk Pegawai">
                @error('nip')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror" 
                       placeholder="Nama lengkap guru" required>
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                <input type="file" name="foto" id="foto" accept="image/*" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('foto') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maksimal 2MB</p>
                @error('foto')
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
                <label for="nomor_hp" class="block text-sm font-medium text-gray-700 mb-2">Nomor HP *</label>
                <input type="text" name="nomor_hp" id="nomor_hp" value="{{ old('nomor_hp') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nomor_hp') border-red-500 @enderror" 
                       placeholder="Contoh: 08123456789" required>
                @error('nomor_hp')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                <textarea name="alamat" id="alamat" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror" 
                          placeholder="Alamat lengkap" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Account Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Akun</h3>
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                       placeholder="email@example.com" required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                <input type="password" name="password" id="password" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" 
                       placeholder="Minimal 8 karakter" required>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Professional Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Kepegawaian</h3>
            </div>
            
            <div>
                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan *</label>
                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jabatan') border-red-500 @enderror" 
                       placeholder="Contoh: Guru Kelas, Kepala Sekolah" required>
                @error('jabatan')
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
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3 pt-6 border-t">
            <a href="{{ route('admin.guru.index') }}" 
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
    // Preview uploaded image
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create preview if doesn't exist
                let preview = document.getElementById('foto-preview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'foto-preview';
                    preview.className = 'mt-2 h-20 w-20 object-cover rounded-full border';
                    document.getElementById('foto').parentNode.appendChild(preview);
                }
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Form validation
    document.getElementById('guruForm').addEventListener('submit', function(e) {
        const requiredFields = ['nama', 'alamat', 'tanggal_lahir', 'nomor_hp', 'email', 'password', 'jabatan', 'tahun_masuk'];
        let isValid = true;

        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                isValid = false;
            } else {
                input.classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi');
        }
    });

    // Phone number formatting
    document.getElementById('nomor_hp').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.startsWith('0')) {
            e.target.value = value;
        } else if (value.startsWith('62')) {
            e.target.value = '0' + value.substring(2);
        }
    });
</script>
@endsection