@extends('wali.layouts.app')

@section('title', 'Jadwal ' . $siswa->nama . ' - Wali')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('wali.jadwal.index') }}" 
                           class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Jadwal Pelajaran</h1>
                            <p class="text-gray-600">{{ $siswa->nama }} - {{ $siswa->kelas->nama_kelas ?? 'Belum ditentukan' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Student Info Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center">
                        <span class="text-emerald-600 font-semibold text-xl">
                            {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $siswa->nama }}</h2>
                        <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                            <span>NIS: {{ $siswa->nis }}</span>
                            <span>•</span>
                            <span>Kelas: {{ $siswa->kelas->nama_kelas ?? 'Belum ditentukan' }}</span>
                            <span>•</span>
                            <span>Jenis Kelamin: {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule -->
        @if($jadwalsSorted->count() > 0)
            <div class="space-y-6">
                @foreach($jadwalsSorted as $hari => $jadwals)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $hari }}
                            </h3>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($jadwals as $jadwal)
                                <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <!-- Time Badge -->
                                            <div class="flex-shrink-0">
                                                <div class="w-16 h-16 bg-blue-100 rounded-lg flex flex-col items-center justify-center">
                                                    <span class="text-xs font-medium text-blue-600">Jam</span>
                                                    <span class="text-lg font-bold text-blue-600">{{ $jadwal->jam_ke }}</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Subject Info -->
                                            <div>
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $jadwal->mapel->nama_mapel ?? 'Mata Pelajaran tidak ditemukan' }}</h4>
                                                <div class="flex items-center space-x-4 text-sm text-gray-600 mt-1">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                        {{ $jadwal->guru->nama ?? 'Guru tidak ditemukan' }}
                                                    </span>
                                                    <span>•</span>
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Status Badge -->
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                @if($jadwal->status == 'aktif') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($jadwal->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if($jadwal->keterangan)
                                        <div class="mt-3 ml-20">
                                            <p class="text-sm text-gray-600 bg-gray-50 rounded-md p-3">
                                                <span class="font-medium">Keterangan:</span> {{ $jadwal->keterangan }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada jadwal</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada jadwal pelajaran untuk kelas ini.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection