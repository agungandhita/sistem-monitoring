@extends('wali.layouts.app')

@section('title', 'Catatan Perkembangan ' . $siswa->nama . ' - Wali')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4 sm:py-6">
                <div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('wali.catatan-perkembangan.index') }}" 
                           class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-1">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Catatan Perkembangan</h1>
                            <p class="text-sm sm:text-base text-gray-600">{{ $siswa->nama }} - {{ $siswa->kelas->nama_kelas ?? 'Belum ditentukan' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        <!-- Student Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-indigo-600 font-semibold text-lg sm:text-xl">
                            {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                        </span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900">{{ $siswa->nama }}</h2>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 text-xs sm:text-sm text-gray-600 mt-1 space-y-1 sm:space-y-0">
                            <span>NIS: {{ $siswa->nis }}</span>
                            <span class="hidden sm:inline">•</span>
                            <span>Kelas: {{ $siswa->kelas->nama_kelas ?? 'Belum ditentukan' }}</span>
                            <span class="hidden sm:inline">•</span>
                            <span>Jenis Kelamin: {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Development Notes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900">Catatan Perkembangan</h3>
                <p class="text-xs sm:text-sm text-gray-600">Riwayat catatan perkembangan dari guru</p>
            </div>
            
            @if($catatanPerkembangan->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($catatanPerkembangan as $catatan)
                        <div class="p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row sm:items-start space-y-4 sm:space-y-0 sm:space-x-4">
                                <!-- Date Badge -->
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex flex-col items-center justify-center">
                                        <span class="text-xs font-medium text-blue-600">{{ $catatan->tanggal->format('M') }}</span>
                                        <span class="text-sm font-bold text-blue-600">{{ $catatan->tanggal->format('d') }}</span>
                                    </div>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 space-y-2 sm:space-y-0">
                                        <div class="flex flex-col sm:flex-row sm:items-center space-y-1 sm:space-y-0 sm:space-x-2">
                                            <h4 class="text-sm font-medium text-gray-900">
                                                {{ $catatan->guru->nama ?? 'Guru tidak ditemukan' }}
                                            </h4>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium w-fit
                                                @if($catatan->kategori == 'akademik') bg-blue-100 text-blue-800
                                                @elseif($catatan->kategori == 'perilaku') bg-green-100 text-green-800
                                                @elseif($catatan->kategori == 'kehadiran') bg-yellow-100 text-yellow-800
                                                @elseif($catatan->kategori == 'prestasi') bg-purple-100 text-purple-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($catatan->kategori) }}
                                            </span>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $catatan->tanggal->format('d F Y') }}</span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-700 leading-relaxed mb-2">{{ $catatan->catatan }}</p>
                                    
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 text-xs text-gray-500 space-y-1 sm:space-y-0">
                                        <span>Semester {{ $catatan->semester }}</span>
                                        <span class="hidden sm:inline">•</span>
                                        <span>{{ $catatan->tahun_ajaran }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                

            @else
                <!-- Empty State -->
                <div class="p-8 sm:p-12 text-center">
                    <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada catatan</h3>
                    <p class="mt-1 text-xs sm:text-sm text-gray-500">Belum ada catatan perkembangan untuk siswa ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection