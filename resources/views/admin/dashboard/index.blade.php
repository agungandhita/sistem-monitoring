@extends('admin.layouts.main')

@section('container')
    <section>
        @include('admin.dashboard._header')

        {{-- isi --}}
        <div class="pt-24 bg-slate-200 container w-full">

            @php
                use Carbon\Carbon;
                $currentTime = Carbon::now();
                $currentHour = $currentTime->hour;
            @endphp
            
            <div class="dark:bg-slate-800 shadow-best bg-white rounded-md justify-between mb-8">
                <div class="flex">
                    <p class="text-4xl capitalize font-semibold py-4 mx-4 text-blue-500">
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
                    <img src="{{ asset('img/hello.png') }}" class="object-contain w-16 justify-end" alt="">
                </div>
            
                <p class="text-3xl font-serif pb-4 mx-4 uppercase text-black">
                    Selamat datang di dashboard admin {{ auth()->user()->role }}
                </p>
            </div>

            {{-- Statistik Utama --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
                {{-- Card Guru --}}
                <div class="bg-blue-400 border-[1px] border-main3 rounded-md h-36 p-2 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex justify-between pt-4 pb-12">
                        <div>
                            <h1 class="font-bold text-6xl text-slate-800 text-center">{{ $totalGuru }}</h1>
                            <h1 class="text-slate-800 font-bold">Total Guru</h1>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-20 opacity-50 text-black"
                            fill="currentColor">
                            <path
                                d="M8 4C8 5.10457 7.10457 6 6 6 4.89543 6 4 5.10457 4 4 4 2.89543 4.89543 2 6 2 7.10457 2 8 2.89543 8 4ZM5 16V22H3V10C3 8.34315 4.34315 7 6 7 6.82059 7 7.56423 7.32946 8.10585 7.86333L10.4803 10.1057 12.7931 7.79289 14.2073 9.20711 10.5201 12.8943 9 11.4587V22H7V16H5ZM10 5H19V14H10V16H14.3654L17.1889 22H19.3993L16.5758 16H20C20.5523 16 21 15.5523 21 15V4C21 3.44772 20.5523 3 20 3H10V5Z">
                            </path>
                        </svg>
                    </div>
                </div>

                {{-- Card Santri (Placeholder) --}}
                <div class="bg-green-400 border-[1px] border-main3 rounded-md h-36 p-2 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex justify-between pt-4 pb-12">
                        <div>
                            <h1 class="font-bold text-6xl text-slate-800 text-center">0</h1>
                            <h1 class="text-slate-800 font-bold">Total Santri</h1>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-20 opacity-50 text-black"
                            fill="currentColor">
                            <path
                                d="M12 2 0 9 12 16 22 10.1667V17.5H24V9L12 2ZM3.99902 13.4905V18.0001C5.82344 20.429 8.72812 22.0001 11.9998 22.0001 15.2714 22.0001 18.1761 20.429 20.0005 18.0001L20.0001 13.4913 12.0003 18.1579 3.99902 13.4905Z">
                            </path>
                        </svg>
                    </div>
                </div>

                {{-- Card Wali (Placeholder) --}}
                <div class="bg-yellow-400 border-[1px] border-main3 rounded-md h-36 p-2 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex justify-between pt-4 pb-12">
                        <div>
                            <h1 class="font-bold text-6xl text-slate-800 text-center">0</h1>
                            <h1 class="text-slate-800 font-bold">Total Wali</h1>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-20 opacity-50 text-black"
                            fill="currentColor">
                            <path
                                d="M7 11C4.51472 11 2.5 8.98528 2.5 6.5C2.5 4.01472 4.51472 2 7 2C9.48528 2 11.5 4.01472 11.5 6.5C11.5 8.98528 9.48528 11 7 11ZM17.5 15C15.2909 15 13.5 13.2091 13.5 11C13.5 8.79086 15.2909 7 17.5 7C19.7091 7 21.5 8.79086 21.5 11C21.5 13.2091 19.7091 15 17.5 15ZM17.5 16C19.9853 16 22 18.0147 22 20.5V21H13V20.5C13 18.0147 15.0147 16 17.5 16ZM7 12C9.76142 12 12 14.2386 12 17V21H2V17C2 14.2386 4.23858 12 7 12Z">
                            </path>
                        </svg>
                    </div>
                </div>

                {{-- Card Kelas (Placeholder) --}}
                <div class="bg-purple-400 border-[1px] border-main3 rounded-md h-36 p-2 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex justify-between pt-4 pb-12">
                        <div>
                            <h1 class="font-bold text-6xl text-slate-800 text-center">0</h1>
                            <h1 class="text-slate-800 font-bold">Total Kelas</h1>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-20 opacity-50 text-black"
                            fill="currentColor">
                            <path
                                d="M2 4.00087C2 2.8954 2.89543 1.99997 4 1.99997H20C21.1046 1.99997 22 2.8954 22 4.00087V6.00197H2V4.00087ZM2 8.00197H22V20.0009C22 21.1055 21.1046 22.0009 20 22.0009H4C2.89543 22.0009 2 21.1055 2 20.0009V8.00197ZM11 12.0009H8V15.0009H11V12.0009ZM7 12.0009H4V15.0009H7V12.0009ZM11 16.0009H8V19.0009H11V16.0009ZM7 16.0009H4V19.0009H7V16.0009ZM15 12.0009H12V15.0009H15V12.0009ZM19 12.0009H16V15.0009H19V12.0009ZM15 16.0009H12V19.0009H15V16.0009ZM19 16.0009H16V19.0009H19V16.0009Z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Grafik dan Statistik --}}
            <div class="grid gap-4 grid-cols-1 lg:grid-cols-2 mt-4">
                <div class="bg-white border-[1px] border-main3 rounded-md h-[400px] p-4 shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Statistik Guru</h2>
                    <div class="flex items-center justify-center h-[320px]">
                        <div class="text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <p class="mt-2">Data statistik guru akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border-[1px] border-main3 rounded-md h-[400px] p-4 shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Aktivitas Terbaru</h2>
                    <div class="flex items-center justify-center h-[320px]">
                        <div class="text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2">Aktivitas terbaru akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Tambahan --}}
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-4">
                <div class="bg-white border-[1px] border-main3 rounded-md h-[200px] p-4 shadow-md hover:shadow-lg transition-all duration-300">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Pengumuman</h3>
                    <p class="text-gray-600">Belum ada pengumuman terbaru.</p>
                </div>
                <div class="bg-white border-[1px] border-main3 rounded-md h-[200px] p-4 shadow-md hover:shadow-lg transition-all duration-300">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Jadwal Kegiatan</h3>
                    <p class="text-gray-600">Belum ada jadwal kegiatan terbaru.</p>
                </div>
                <div class="bg-white border-[1px] border-main3 rounded-md h-[200px] p-4 shadow-md hover:shadow-lg transition-all duration-300">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Kalender Akademik</h3>
                    <p class="text-gray-600">Belum ada informasi kalender akademik.</p>
                </div>
            </div>

            {{-- Tabel Data --}}
            <div class="bg-white border-[1px] border-main3 rounded-md h-auto w-full mt-4 p-4 shadow-md mb-8">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Daftar Guru</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b text-left">No</th>
                                <th class="py-2 px-4 border-b text-left">Nama</th>
                                <th class="py-2 px-4 border-b text-left">Email</th>
                                <th class="py-2 px-4 border-b text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b text-gray-500" colspan="4">Belum ada data guru</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
