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
                <h1 class="text-3xl font-bold text-gray-900">Catatan Perkembangan</h1>
                <p class="text-gray-600 mt-2">Riwayat catatan perkembangan siswa</p>
            </div>
        </div>
    </div>

    <!-- Student Info -->
    @if(isset($siswa))
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
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
                <a href="{{ route('guru.catatan-perkembangan.create', $siswa->siswa_id) }}" 
                    class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Catatan
                </a>
            </div>
        </div>
    @endif

    <!-- Catatan List -->
    @if(isset($catatanList) && $catatanList->count() > 0)
        <div class="space-y-6">
            @foreach($catatanList as $catatan)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($catatan->jenis_catatan == 'akademik') bg-blue-100 text-blue-800
                                    @elseif($catatan->jenis_catatan == 'perilaku') bg-yellow-100 text-yellow-800
                                    @elseif($catatan->jenis_catatan == 'sosial') bg-green-100 text-green-800
                                    @elseif($catatan->jenis_catatan == 'kehadiran') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($catatan->jenis_catatan) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $catatan->tanggal->format('d F Y') }}</p>
                            <p class="text-sm text-gray-500">Oleh: {{ $catatan->guru->nama ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="prose max-w-none">
                        <p class="text-gray-700">{{ $catatan->catatan }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Catatan</h3>
            <p class="text-gray-500 mb-4">Belum ada catatan perkembangan untuk siswa ini.</p>
            <a href="{{ route('guru.catatan-perkembangan.create', ['siswa_id' => $siswa->siswa_id]) }}" 
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Catatan Pertama
            </a>
        </div>
    @endif
</div>
@endsection