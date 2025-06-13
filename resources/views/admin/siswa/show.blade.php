@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Siswa</h1>
            <p class="text-gray-600">Informasi lengkap siswa {{ $siswa->nama }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.siswa.edit', $siswa->siswa_id) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.siswa.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Student Information -->
        <div class="lg:col-span-2">
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Siswa</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">NIS</label>
                        <p class="text-gray-900 font-medium">{{ $siswa->nis }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                        <p class="text-gray-900 font-medium">{{ $siswa->nama }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jenis Kelamin</label>
                        <p class="text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $siswa->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Tempat, Tanggal Lahir</label>
                        <p class="text-gray-900">{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir->format('d F Y') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Umur</label>
                        <p class="text-gray-900">{{ $siswa->tanggal_lahir->age }} tahun</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Kelas</label>
                        <p class="text-gray-900 font-medium">
                            @if($siswa->kelas)
                                {{ $siswa->kelas->nama_kelas }} - {{ $siswa->kelas->tingkat }}
                                <span class="text-sm text-gray-500">({{ $siswa->kelas->kurikulum->nama_kurikulum }})</span>
                            @else
                                <span class="text-gray-500">Belum ada kelas</span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Tahun Masuk</label>
                        <p class="text-gray-900">{{ $siswa->tahun_masuk }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                        <p class="text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($siswa->status == 'aktif') bg-green-100 text-green-800
                                @elseif($siswa->status == 'tidak_aktif') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $siswa->status)) }}
                            </span>
                        </p>
                    </div>
                    
                    @if($siswa->telepon)
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Telepon</label>
                        <p class="text-gray-900">{{ $siswa->telepon }}</p>
                    </div>
                    @endif
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Alamat</label>
                        <p class="text-gray-900">{{ $siswa->alamat }}</p>
                    </div>
                    
                    @if($siswa->catatan)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Catatan</label>
                        <p class="text-gray-900">{{ $siswa->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Academic Progress Section (Placeholder) -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Progress Akademik</h3>
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-gray-500">Data progress akademik akan ditampilkan di sini</p>
                    <p class="text-sm text-gray-400 mt-2">Fitur ini dapat dikembangkan lebih lanjut</p>
                </div>
            </div>
        </div>
        
        <!-- Guardian Information -->
        <div>
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Wali</h3>
                    <a href="{{ route('admin.siswa.edit', $siswa->siswa_id) }}" 
                       class="text-blue-500 hover:text-blue-700 text-sm">
                        Edit Wali
                    </a>
                </div>
                
                @if($siswa->walis->count() > 0)
                    <div class="space-y-4">
                        @foreach($siswa->walis as $wali)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $wali->nama }}</h4>
                                        <p class="text-sm text-gray-600 capitalize">{{ $wali->pivot->hubungan }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        {{ $wali->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ $wali->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                    </span>
                                </div>
                                
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $wali->user->email }}
                                    </div>
                                    
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        {{ $wali->telepon }}
                                    </div>
                                    
                                    @if($wali->pekerjaan)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 00-2 2H10a2 2 0 00-2-2V6m8 0h2a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h2"></path>
                                        </svg>
                                        {{ $wali->pekerjaan }}
                                    </div>
                                    @endif
                                    
                                    <div class="flex items-start text-gray-600">
                                        <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="flex-1">{{ $wali->alamat }}</span>
                                    </div>
                                </div>
                                
                                <!-- Other Children -->
                                @php
                                    $otherChildren = $wali->siswas->where('siswa_id', '!=', $siswa->siswa_id);
                                @endphp
                                
                                @if($otherChildren->count() > 0)
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <p class="text-xs font-medium text-gray-600 mb-2">Anak lainnya:</p>
                                        <div class="space-y-1">
                                            @foreach($otherChildren as $child)
                                                <div class="flex justify-between items-center text-xs">
                                                    <span class="text-gray-700">{{ $child->nama }}</span>
                                                    <span class="text-gray-500">{{ $child->kelas }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-sm">Belum ada wali terdaftar</p>
                        <a href="{{ route('admin.siswa.edit', $siswa->siswa_id) }}" 
                           class="text-blue-500 hover:text-blue-700 text-sm mt-2 inline-block">
                            Tambah Wali
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Quick Stats -->
            <div class="bg-gray-50 rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Statistik</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Jumlah Wali</span>
                        <span class="font-medium text-gray-900">{{ $siswa->walis->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Lama Bersekolah</span>
                        <span class="font-medium text-gray-900">{{ date('Y') - $siswa->tahun_masuk }} tahun</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Terdaftar Sejak</span>
                        <span class="font-medium text-gray-900">{{ $siswa->created_at->format('d M Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Terakhir Update</span>
                        <span class="font-medium text-gray-900">{{ $siswa->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection