@extends('wali.layouts.app')

@section('title', 'Jadwal Pelajaran - Wali')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4 sm:py-6">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Jadwal Pelajaran</h1>
                    <p class="text-sm sm:text-base text-gray-600">Lihat jadwal pelajaran anak Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
        @if($siswas->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($siswas as $siswa)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                        <div class="p-4 sm:p-6">
                            <!-- Student Avatar -->
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-emerald-600 font-semibold text-sm sm:text-lg">
                                        {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="ml-3 sm:ml-4 min-w-0 flex-1">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 truncate">{{ $siswa->nama }}</h3>
                                    <p class="text-xs sm:text-sm text-gray-600">NIS: {{ $siswa->nis }}</p>
                                </div>
                            </div>
                            
                            <!-- Student Info -->
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"></path>
                                    </svg>
                                    <span class="truncate">Kelas: {{ $siswa->kelas->nama_kelas ?? 'Belum ditentukan' }}</span>
                                </div>
                                <div class="flex items-center text-xs sm:text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="truncate">Hubungan: {{ ucfirst($siswa->pivot->hubungan) }}</span>
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            <div class="flex justify-center">
                                <a href="{{ route('wali.jadwal.show', $siswa->siswa_id) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200 w-full justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Lihat Jadwal
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-8 sm:p-12 text-center">
                    <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada siswa</h3>
                    <p class="mt-1 text-xs sm:text-sm text-gray-500">Belum ada siswa yang terdaftar di bawah perwalian Anda.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection