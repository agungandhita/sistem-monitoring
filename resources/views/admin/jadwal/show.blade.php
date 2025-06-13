@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Jadwal Pelajaran</h1>
            <p class="text-gray-600">Informasi lengkap jadwal pelajaran</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.jadwal.edit', $jadwal->jadwal_id) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.jadwal.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Informasi Jadwal -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v9a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                </svg>
                Informasi Jadwal
            </h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Hari:</span>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        {{ $jadwal->hari }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Jam Ke:</span>
                    <span class="text-gray-900 font-semibold">{{ $jadwal->jam_ke }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Waktu:</span>
                    <span class="text-gray-900 font-semibold">
                        {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Tahun Ajaran:</span>
                    <span class="text-gray-900 font-semibold">{{ $jadwal->tahun_ajaran }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600 font-medium">Status:</span>
                    @if($jadwal->status == 'aktif')
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                            Aktif
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                            Tidak Aktif
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Mata Pelajaran -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                Mata Pelajaran & Kurikulum
            </h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Mata Pelajaran:</span>
                    <span class="text-gray-900 font-semibold">{{ $jadwal->mapel->nama_mapel ?? '-' }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Kode Mapel:</span>
                    <span class="text-gray-900 font-semibold">{{ $jadwal->mapel->kode_mapel ?? '-' }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Kurikulum:</span>
                    <span class="text-gray-900 font-semibold">{{ $jadwal->kurikulum->nama_kurikulum ?? '-' }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600 font-medium">Kelas:</span>
                    <span class="text-gray-900 font-semibold">{{ $jadwal->kelas->nama_kelas ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Informasi Guru -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Informasi Guru
            </h2>
            
            @if($jadwal->guru)
                <div class="flex items-center mb-4">
                    @if($jadwal->guru->foto)
                        <img class="h-16 w-16 rounded-full object-cover mr-4" src="{{ asset('uploads/guru/' . $jadwal->guru->foto) }}" alt="Foto Guru">
                    @else
                        <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                            <svg class="h-8 w-8 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $jadwal->guru->nama_guru }}</h3>
                        <p class="text-gray-600">{{ $jadwal->guru->jabatan ?? 'Guru' }}</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600 font-medium">NIP:</span>
                        <span class="text-gray-900 font-semibold">{{ $jadwal->guru->nip ?? '-' }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600 font-medium">Email:</span>
                        <span class="text-gray-900">{{ $jadwal->guru->email ?? '-' }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600 font-medium">No. Telepon:</span>
                        <span class="text-gray-900">{{ $jadwal->guru->no_telepon ?? '-' }}</span>
                    </div>
                </div>
            @else
                <p class="text-gray-500 italic">Data guru tidak tersedia</p>
            @endif
        </div>

        <!-- Catatan -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Catatan
            </h2>
            
            @if($jadwal->catatan)
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-700 leading-relaxed">{{ $jadwal->catatan }}</p>
                </div>
            @else
                <p class="text-gray-500 italic">Tidak ada catatan untuk jadwal ini</p>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-500">
                <p>Dibuat: {{ $jadwal->created_at ? $jadwal->created_at->format('d M Y H:i') : '-' }}</p>
                <p>Diperbarui: {{ $jadwal->updated_at ? $jadwal->updated_at->format('d M Y H:i') : '-' }}</p>
            </div>
            
            <div class="flex space-x-3">
                <form action="{{ route('admin.jadwal.destroy', $jadwal->jadwal_id) }}" method="POST" class="inline" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Jadwal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection