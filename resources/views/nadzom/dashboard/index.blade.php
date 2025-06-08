@extends('nadzom.layouts.main')

@section('container')
    <section>
        @include('nadzom.dashboard._header')

        {{-- isi --}}
        <div class="px-4 mt-20 pt-6 bg-slate-200 dark:bg-gray-800 h-screen max-h-full">

            @php
                use Carbon\Carbon;
                $currentTime = Carbon::now();

                $currentHour = $currentTime->hour;

            @endphp

            {{-- @dd($currentHour) --}}

            <div class="dark:bg-slate-800 shadow-best bg-white rounded-md justify-between mb-4">
                <div class="flex justify-between">
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
                    <div class=" justify-end">
                        <img src="{{ asset('img/logo2.png') }}" class="object-contain w-16" alt="">
                    </div>
                </div>


                <p class="text-3xl font-serif pb-4 mx-4 uppercase text-black">
                    Selamat datang di dashboard Penilaian {{ auth()->user()->role }}
                </p>
            </div>


            <div class="dark:bg-slate-800 shadow-best bg-white rounded-md justify-between mb-8">
                <div class="flex">
                    <h1>
                        
                    </h1>
                </div>

                <p class="text-xl font-inter pb-4 mx-4 uppercase text-black">
                    Tegakan Amar Ma'ruf Nahi mungkar diatas Ahlusunnah Waljamaah
                </p>
            </div>

        </div>



        {{-- card-1 start --}}
        {{-- <div class="grid w-full grid-cols-1 gap-4 mt-4 xl:grid-cols-2 2xl:grid-cols-3 pb-4 ">
        
                    <div
                        class="items-center justify-between p-4 bg-yellow-300 border border-gray-200 relative rounded-lg shadow-sm dark:border-gray-700 sm:p-6 ">
                        <div class="w-full">
        
                            <div class="flex justify-between pt-4 pb-12">
                                <div>
                                    <h1 class="font-bold text-6xl text-black">8</h1>
                                    <h1 class="text-black">Total Pesanan</h1>
                                </div>
        
        
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-28 opacity-50 text-black" viewBox="0 0 24 24">
                                    <path
                                        d="M6 7V4C6 3.44772 6.44772 3 7 3H13.4142L15.4142 5H21C21.5523 5 22 5.44772 22 6V16C22 16.5523 21.5523 17 21 17H18V20C18 20.5523 17.5523 21 17 21H3C2.44772 21 2 20.5523 2 20V8C2 7.44772 2.44772 7 3 7H6ZM6 9H4V19H16V17H6V9Z"
                                        fill="currentColor"></path>
                                </svg>
        
                            </div>
        
                            <a href=""
                                class="absolute bottom-0  left-0 right-0 bg-yellow-400/50 font-semibold text-lg text-center rounded-b-md p-2 text-black">Lihat
                                Detail</a>
        
        
                        </div>
                        <div class="w-full" id="new-products-chart"></div>
                    </div> --}}
        {{-- card-1 end --}}



        {{-- <div
                        class="items-center justify-between p-4 bg-cyan-500 text-black border border-gray-200 relative rounded-lg shadow-sm dark:border-gray-700 sm:p-6 ">
                        <div class="w-full">
        
                            <div class="flex justify-between pt-4 pb-12">
                                <div>
                                    <h1 class="font-bold text-6xl text-black">9</h1>
                                    <h1 class="text-black">Stok Total</h1>
                                </div>
        
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-28 opacity-50 text-black" >
                                    <path
                                        d="M5 3C4.5313 3 4.12549 3.32553 4.02381 3.78307L2.02381 12.7831C2.00799 12.8543 2 12.927 2 13V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V13C22 12.927 21.992 12.8543 21.9762 12.7831L19.9762 3.78307C19.8745 3.32553 19.4687 3 19 3H5ZM19.7534 12H15C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12H4.24662L5.80217 5H18.1978L19.7534 12Z"
                                        fill="currentColor"></path>
                                </svg>
                            </div>
        
                            <a href=""
                                class="absolute bottom-0 left-0 right-0 bg-cyan-600/50 font-semibold text-lg text-center rounded-b-md p-2">Lihat
                                Detail</a>
        
        
                        </div>
                        <div class="w-full" id="new-products-chart"></div>
                    </div> --}}
        {{-- card-2 end --}}


        {{-- card-3 start --}}

        {{-- <div
                        class="items-center justify-between p-4 bg-green-500 border border-gray-200 relative rounded-lg shadow-sm dark:border-gray-700 sm:p-6 ">
                        <div class="w-full">
        
                            <div class="flex justify-between pt-4 pb-12">
                                <div>
                                    <h1 class="font-bold text-6xl">20</h1>
                                    <h1>Total User</h1>
                                </div>
        
        
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 opacity-50" fill="currentcolor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z">
                                    </path>
                                </svg>
        
        
                            </div>
        
                            <a href=""
                                class="absolute bottom-0 left-0 right-0 bg-green-600/50 font-semibold text-lg text-center rounded-b-md p-2">Lihat
                                Detail</a>
        
        
                        </div>
                        <div class="w-full" id="new-products-chart"></div>
                    </div> --}}
        {{-- card-3 end --}}
        </div>

        {{-- <div class="w-full max-w-full mb-4 ">
                    <div
                        class="border-black/12.5 shadow-soft-xl relative z-20 shadow-best4 flex w-full flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border dark:bg-gray-800">
                        <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-[#FF8400] p-2 pb-0">
                            <h1 class="text-white font-semibold text-lg">Laporan Order Bulanan</h1>
                            <p class="leading-normal text-md mt-1">
                                <i class="fa fa-arrow-up text-lime-500"></i>
                                <span class="font-semibold">4% more</span> in 2021
                            </p>
                        </div>
                        <div class="flex-auto p-4">
                            <div>
                                <canvas id="chart-line" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div> --}}
        </div>
    </section>
@endsection
