@extends('guru.layouts.main')

@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('guru.catatan-perkembangan.index') }}" class="text-blue-600 hover:text-blue-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Buat Catatan Perkembangan</h1>
                <p class="text-gray-600 mt-2">Buat catatan perkembangan untuk siswa</p>
            </div>
        </div>
    </div>

    <!-- Student Info -->
    @if(isset($siswa))
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12">
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-lg font-medium text-blue-600">{{ substr($siswa->nama, 0, 1) }}</span>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ $siswa->nama }}</h3>
                    <p class="text-sm text-gray-600">NIS: {{ $siswa->nis }} | Kelas: {{ $siswa->kelas->nama_kelas ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('guru.catatan-perkembangan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="siswa_id" value="{{ $siswa->siswa_id ?? '' }}">
            
            <!-- Tanggal -->
            <div class="mb-6">
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                    class="w-full md:w-auto px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal') border-red-500 @enderror" required>
                @error('tanggal')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Catatan -->
            <div class="mb-6">
                <label for="jenis_catatan" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Catatan <span class="text-red-500">*</span>
                </label>
                <select name="jenis_catatan" id="jenis_catatan" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis_catatan') border-red-500 @enderror" required>
                    <option value="">Pilih Jenis Catatan</option>
                    <option value="akademik" {{ old('jenis_catatan') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                    <option value="perilaku" {{ old('jenis_catatan') == 'perilaku' ? 'selected' : '' }}>Perilaku</option>
                    <option value="sosial" {{ old('jenis_catatan') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                    <option value="kehadiran" {{ old('jenis_catatan') == 'kehadiran' ? 'selected' : '' }}>Kehadiran</option>
                    <option value="lainnya" {{ old('jenis_catatan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('jenis_catatan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div class="mb-6">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan Perkembangan <span class="text-red-500">*</span>
                </label>
                <textarea name="catatan" id="catatan" rows="6"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('catatan') border-red-500 @enderror"
                    placeholder="Tuliskan catatan perkembangan siswa secara detail..." required>{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Jelaskan perkembangan, prestasi, atau hal-hal yang perlu diperhatikan dari siswa.</p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('guru.catatan-perkembangan.index') }}" 
                    class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection