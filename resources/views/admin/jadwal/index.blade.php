@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Jadwal Pelajaran</h1>
            <p class="text-gray-600">Kelola jadwal pelajaran berdasarkan hari, kelas, dan tahun ajaran</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.jadwal.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Jadwal
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <form action="{{ route('admin.jadwal.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select id="kelas_id" name="kelas_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->kelas_id }}" {{ request('kelas_id') == $k->kelas_id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="hari" class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                <select id="hari" name="hari" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Semua Hari</option>
                    @foreach($hari as $h)
                        <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                <select id="tahun_ajaran" name="tahun_ajaran" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tahunAjaran as $ta)
                        <option value="{{ $ta }}" {{ request('tahun_ajaran') == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Jadwal Cards by Day -->
    <div class="mb-6">
        @php
            $jadwalByDay = $jadwals->groupBy('hari');
            $daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($daysOrder as $day)
                @if($jadwalByDay->has($day))
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-blue-500 text-white px-4 py-3">
                            <h3 class="text-lg font-semibold">{{ $day }}</h3>
                        </div>
                        <div class="p-4">
                            @php
                                $dayJadwals = $jadwalByDay[$day]->sortBy('jam_ke');
                                $jadwalCount = $dayJadwals->count();
                            @endphp
                            
                            <div class="text-sm text-gray-600 mb-3">
                                <span class="font-medium">{{ $jadwalCount }}</span> jadwal pelajaran
                            </div>
                            
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                @foreach($dayJadwals->take(5) as $jadwal)
                                    <div class="border-l-4 border-blue-400 pl-3 py-1">
                                        <div class="font-medium text-gray-800">{{ $jadwal->mapel->nama_mapel }}</div>
                                        <div class="text-sm text-gray-600">Jam ke-{{ $jadwal->jam_ke }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})</div>
                                        <div class="text-sm text-gray-600">{{ $jadwal->kelas->nama_kelas }} | {{ $jadwal->guru->nama_guru }}</div>
                                    </div>
                                @endforeach
                                
                                @if($jadwalCount > 5)
                                    <div class="text-center pt-2">
                                        <span class="text-sm text-gray-500">+{{ $jadwalCount - 5 }} jadwal lainnya</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('admin.jadwal.by-day') }}?hari={{ $day }}&kelas_id={{ request('kelas_id') }}&tahun_ajaran={{ request('tahun_ajaran') }}" 
                                   class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-4 rounded-md transition duration-200 inline-block text-center">
                                    Lihat Detail
                                </a>
                            </div>
                        
                        </div>
                    </div>
                @else
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="bg-gray-500 text-white px-4 py-3">
                            <h3 class="text-lg font-semibold">{{ $day }}</h3>
                        </div>
                        <div class="p-4 text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <p class="text-gray-500">Tidak ada jadwal</p>
                            <div class="mt-4">
                                <a href="{{ route('admin.jadwal.create') }}?hari={{ $day }}" 
                                   class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md transition duration-200">
                                    Tambah Jadwal
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

 
</div>

@endsection