@extends('admin.layouts.main')

@section('container')
    <section>
        {{-- @include('admin.dashboard._header') --}}

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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
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
                
                {{-- Card Santri --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-green-500">
                    <div class="flex justify-between">
                        <div>
                            {{-- <p class="text-3xl font-bold text-gray-800">{{ $totalSantri }}</p> --}}
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
                            <p class="text-3xl font-bold text-gray-800"></p>
                            <p class="text-gray-500 mt-1">Total Wali</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Card Kelas --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-purple-500">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-800"></p>
                            <p class="text-gray-500 mt-1">Total Kelas</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts & Statistics --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik Guru</h2>
                    <div class="h-[300px] flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <p class="mt-4">Data statistik akan tersedia segera</p>
                        </div>
                    </div>
                </div>
                
                {{-- Card Aktivitas Terbaru --}}
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h2>
                    <div class="h-[300px] flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-4">Aktivitas terbaru akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
