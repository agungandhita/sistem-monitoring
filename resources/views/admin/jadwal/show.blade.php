@extends('admin.layouts.main')

@section('container')
<div class="bg-white rounded-lg shadow-md p-6 mt-24">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Jadwal Pelajaran</h1>
                <p class="text-gray-600">Informasi lengkap jadwal pelajaran</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.jadwal.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('admin.jadwal.edit', $jadwal->jadwal_id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form action="{{ route('admin.jadwal.destroy', $jadwal->jadwal_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    Jadwal ini {{ $jadwal->status === 'aktif' ? 'aktif' : 'tidak aktif' }} untuk tahun ajaran {{ $jadwal->tahun_ajaran }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Jadwal</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Hari</h3>
                    <p class="text-base text-gray-900">{{ $jadwal->hari }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Jam Ke</h3>
                    <p class="text-base text-gray-900">{{ $jadwal->jam_ke }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Waktu</h3>
                    <p class="text-base text-gray-900">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Status</h3>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $jadwal->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $jadwal->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Tahun Ajaran</h3>
                    <p class="text-base text-gray-900">{{ $jadwal->tahun_ajaran }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Akademik</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Mata Pelajaran</h3>
                    <p class="text-base text-gray-900">{{ $jadwal->mapel->nama_mapel }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Guru Pengajar</h3>
                    <p class="text-base text-gray-900">{{ $jadwal->guru->nama_guru }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Kelas</h3>
                    <p class="text-base text-gray-900">{{ $jadwal->kelas->nama_kelas }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Kurikulum</h3>
                    <p class="text-base text-gray-900">{{ $jadwal->kurikulum->nama_kurikulum }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($jadwal->catatan)
    <div class="mt-6 bg-gray-50 rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Catatan</h2>
        <p class="text-base text-gray-900">{{ e($jadwal->catatan) }}</p>
    </div>
    @endif

    <div class="mt-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Lain pada Hari yang Sama</h2>
        @php
            $relatedJadwals = App\Models\Jadwal::where('hari', $jadwal->hari)
                ->where('kelas_id', $jadwal->kelas_id)
                ->where('tahun_ajaran', $jadwal->tahun_ajaran)
                ->where('jadwal_id', '!=', $jadwal->jadwal_id)
                ->orderBy('jam_ke')
                ->get();
        @endphp

        @if($relatedJadwals->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Ke</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($relatedJadwals as $relatedJadwal)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $relatedJadwal->jam_ke }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $relatedJadwal->jam_mulai }} - {{ $relatedJadwal->jam_selesai }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $relatedJadwal->mapel->nama_mapel }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $relatedJadwal->guru->nama_guru }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.jadwal.show', $relatedJadwal->jadwal_id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-gray-50 p-4 rounded-lg text-center">
                <p class="text-gray-500">Tidak ada jadwal lain pada hari yang sama untuk kelas ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection