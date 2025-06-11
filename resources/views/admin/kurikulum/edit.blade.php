@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Kurikulum</h1>
            <p class="text-gray-600">Perbarui informasi kurikulum</p>
        </div>
        <div>
            <a href="{{ route('admin.kurikulum.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="max-w-2xl">
        <form method="post" action="{{ route('admin.kurikulum.update', $kurikulum->kurikulum_id) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Nama Kurikulum -->
            <div>
                <label for="nama_kurikulum" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kurikulum <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_kurikulum') border-red-500 @enderror" 
                       id="nama_kurikulum" 
                       name="nama_kurikulum" 
                       required 
                       autofocus 
                       value="{{ old('nama_kurikulum', $kurikulum->nama_kurikulum) }}"
                       placeholder="Contoh: Kurikulum 2013, Kurikulum Merdeka">
                @error('nama_kurikulum')
                    <div class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Masukkan nama kurikulum yang akan digunakan</p>
            </div>

            <!-- Tahun Ajaran -->
            <div>
                <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun Ajaran <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tahun_ajaran') border-red-500 @enderror" 
                       id="tahun_ajaran" 
                       name="tahun_ajaran" 
                       required 
                       value="{{ old('tahun_ajaran', $kurikulum->tahun_ajaran) }}"
                       placeholder="Contoh: 2023/2024, 2024/2025">
                @error('tahun_ajaran')
                    <div class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Format: YYYY/YYYY (contoh: 2023/2024)</p>
            </div>

            <!-- Current Data Info -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-800 mb-3">Informasi Saat Ini</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Dibuat pada:</span>
                        <span class="font-medium text-gray-900">{{ $kurikulum->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Terakhir diupdate:</span>
                        <span class="font-medium text-gray-900">{{ $kurikulum->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    @if($kurikulum->gurus && $kurikulum->gurus->count() > 0)
                    <div>
                        <span class="text-gray-600">Guru terdaftar:</span>
                        <span class="font-medium text-gray-900">{{ $kurikulum->gurus->count() }} guru</span>
                    </div>
                    @endif
                    @if($kurikulum->mapels && $kurikulum->mapels->count() > 0)
                    <div>
                        <span class="text-gray-600">Mata pelajaran:</span>
                        <span class="font-medium text-gray-900">{{ $kurikulum->mapels->count() }} mapel</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Warning Box -->
            @if(($kurikulum->gurus && $kurikulum->gurus->count() > 0) || ($kurikulum->mapels && $kurikulum->mapels->count() > 0))
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Kurikulum ini sudah memiliki data terkait (guru dan/atau mata pelajaran). Perubahan yang Anda lakukan akan mempengaruhi data tersebut.</p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Setelah mengupdate kurikulum, Anda dapat menambahkan guru dan mata pelajaran melalui halaman detail kurikulum.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.kurikulum.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Batal
                </a>
                <a href="{{ route('admin.kurikulum.show', $kurikulum->kurikulum_id) }}" 
                   class="px-6 py-3 border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50 transition duration-200">
                    Lihat Detail
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Kurikulum
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto format tahun ajaran input
    document.getElementById('tahun_ajaran').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        
        if (value.length >= 4) {
            let year1 = value.substring(0, 4);
            let year2 = value.substring(4, 8);
            
            if (year2) {
                e.target.value = year1 + '/' + year2;
            } else {
                e.target.value = year1;
            }
        } else {
            e.target.value = value;
        }
    });

    // Validate form before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const namaKurikulum = document.getElementById('nama_kurikulum').value.trim();
        const tahunAjaran = document.getElementById('tahun_ajaran').value.trim();
        
        if (!namaKurikulum) {
            e.preventDefault();
            alert('Nama kurikulum harus diisi!');
            document.getElementById('nama_kurikulum').focus();
            return;
        }
        
        if (!tahunAjaran) {
            e.preventDefault();
            alert('Tahun ajaran harus diisi!');
            document.getElementById('tahun_ajaran').focus();
            return;
        }
        
        // Validate tahun ajaran format
        const tahunPattern = /^\d{4}\/\d{4}$/;
        if (!tahunPattern.test(tahunAjaran)) {
            e.preventDefault();
            alert('Format tahun ajaran tidak valid! Gunakan format YYYY/YYYY (contoh: 2023/2024)');
            document.getElementById('tahun_ajaran').focus();
            return;
        }
        
        // Confirm update if there are related data
        @if(($kurikulum->gurus && $kurikulum->gurus->count() > 0) || ($kurikulum->mapels && $kurikulum->mapels->count() > 0))
        if (!confirm('Kurikulum ini memiliki data terkait. Apakah Anda yakin ingin mengupdate?')) {
            e.preventDefault();
            return;
        }
        @endif
    });
</script>
@endsection