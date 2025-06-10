@extends('admin.layouts.main')

@section('container')
    <section>
        {{-- isi --}}
        <div class="pt-20 px-4 md:px-6 lg:px-8 bg-gray-100 min-h-screen">
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-semibold text-gray-800">
                            @if ($currentHour >= 0 && $currentHour < 12)
                                Selamat pagi, {{ auth()->user()->nama }}
                            @elseif ($currentHour >= 12 && $currentHour < 15)
                                Selamat siang, {{ auth()->user()->nama }}
                            @elseif ($currentHour >= 15 && $currentHour < 17)
                                Selamat sore, {{ auth()->user()->nama }}
                            @else
                                Selamat malam, {{ auth()->user()->nama }}
                            @endif
                        </p>
                        <p class="text-gray-500 mt-1">Selamat datang kembali di dashboard admin</p>
                    </div>
                    <img src="{{ asset('img/kemenag.png') }}" class="w-20 h-20 object-contain" alt="">
                </div>
            </div>

            {{-- Statistik Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
                {{-- Card Guru --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-blue-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalGuru }}</p>
                            <p class="text-gray-500 mt-1">Total Guru</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                {{-- Card Siswa --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-green-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalSiswa }}</p>
                            <p class="text-gray-500 mt-1">Total Siswa</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Card Wali --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-yellow-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalWali }}</p>
                            <p class="text-gray-500 mt-1">Total Wali</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Card Mapel --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-purple-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalMapel }}</p>
                            <p class="text-gray-500 mt-1">Total Mapel</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Card Total User --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-red-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalUser }}</p>
                            <p class="text-gray-500 mt-1">Total User</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts & Statistics --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                {{-- Statistik Berdasarkan Jenis Kelamin --}}
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik Berdasarkan Jenis Kelamin</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-md font-medium text-gray-700 mb-2">Guru</h3>
                            <div class="space-y-2">
                                @foreach($guruByGender as $data)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">{{ ucfirst($data->jenis_kelamin) }}</span>
                                    <span class="text-sm font-medium text-gray-800">{{ $data->count }} orang</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                        <div>
                            <h3 class="text-md font-medium text-gray-700 mb-2">Siswa</h3>
                            <div class="space-y-2">
                                @foreach($siswaByGender as $data)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">{{ ucfirst($data->jenis_kelamin) }}</span>
                                    <span class="text-sm font-medium text-gray-800">{{ $data->count }} orang</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Statistik Siswa per Kelas --}}
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Siswa per Kelas</h2>
                    <div class="space-y-3">
                        @foreach($siswaByKelas as $data)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Kelas {{ $data->kelas }}</span>
                            <span class="text-sm font-bold text-blue-600">{{ $data->count }} siswa</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Recent Activities --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                {{-- Recent Siswa --}}
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Siswa Terbaru</h2>
                    <div class="space-y-3">
                        @forelse($recentSiswa as $siswa)
                        <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 text-xs font-medium">{{ substr($siswa->nama, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">{{ $siswa->nama }}</p>
                                <p class="text-xs text-gray-500">NIS: {{ $siswa->nis }} | Kelas {{ $siswa->kelas }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada data siswa</p>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Guru --}}
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Guru Terbaru</h2>
                    <div class="space-y-3">
                        @forelse($recentGuru as $guru)
                        <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 text-xs font-medium">{{ substr($guru->nama, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">{{ $guru->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $guru->jabatan }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada data guru</p>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Wali --}}
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Wali Terbaru</h2>
                    <div class="space-y-3">
                        @forelse($recentWali as $wali)
                        <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                <span class="text-yellow-600 text-xs font-medium">{{ substr($wali->nama, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">{{ $wali->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $wali->pekerjaan }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada data wali</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
