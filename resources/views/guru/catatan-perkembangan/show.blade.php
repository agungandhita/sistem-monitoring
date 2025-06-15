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
                        <p class="text-sm text-gray-600">NIS: {{ $siswa->nis }} | Kelas: {{ $siswa->kelas->kelas ?? 'N/A' }}</p>
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
                    <!-- Header Catatan -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $catatan->judul ?? 'Catatan Perkembangan' }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($catatan->kategori == 'akademik') bg-blue-100 text-blue-800
                                    @elseif($catatan->kategori == 'perilaku') bg-green-100 text-green-800
                                    @elseif($catatan->kategori == 'sosial') bg-purple-100 text-purple-800
                                    @elseif($catatan->kategori == 'kehadiran') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($catatan->kategori ?? 'Lainnya') }}
                                </span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500 space-x-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $catatan->tanggal ? \Carbon\Carbon::parse($catatan->tanggal)->format('d M Y') : 'N/A' }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $catatan->guru->nama ?? 'Guru' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Isi Catatan -->
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Catatan:</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-800 leading-relaxed">{{ $catatan->catatan ?? 'Tidak ada catatan.' }}</p>
                        </div>
                    </div>

                    <!-- Tindak Lanjut -->
                    @if($catatan->tindak_lanjut)
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Tindak Lanjut:</h4>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-gray-800 leading-relaxed">{{ $catatan->tindak_lanjut }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination (if needed) -->
        @if(method_exists($catatanList, 'links'))
            <div class="mt-6">
                {{ $catatanList->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Catatan</h3>
            <p class="text-gray-500 mb-4">Belum ada catatan perkembangan untuk siswa ini.</p>
            @if(isset($siswa))
                <a href="{{ route('guru.catatan-perkembangan.create', $siswa->siswa_id) }}" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Catatan Pertama
                </a>
            @endif
        </div>
    @endif
</div>
@endsection