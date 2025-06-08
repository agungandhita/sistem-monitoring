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

        {{-- @dd($currentHour) --}}
        
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
        




            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

                <div class="bg-blue-400 border-[1px] border-main3 rounded-md h-36 p-2">

                    <div class="flex justify-between pt-4 pb-12">
                        <div>
                            <h1 class="font-bold text-6xl text-slate-800 text-center">{{ $totaldata }}</h1>
                            <h1 class=" text-slate-800 font-bold">Total Wali Santri</h1>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-20 opacity-50 text-gray-950">
                            <path
                                d="M7 11C4.51472 11 2.5 8.98528 2.5 6.5C2.5 4.01472 4.51472 2 7 2C9.48528 2 11.5 4.01472 11.5 6.5C11.5 8.98528 9.48528 11 7 11ZM17.5 15C15.2909 15 13.5 13.2091 13.5 11C13.5 8.79086 15.2909 7 17.5 7C19.7091 7 21.5 8.79086 21.5 11C21.5 13.2091 19.7091 15 17.5 15ZM17.5 16C19.9853 16 22 18.0147 22 20.5V21H13V20.5C13 18.0147 15.0147 16 17.5 16ZM7 12C9.76142 12 12 14.2386 12 17V21H2V17C2 14.2386 4.23858 12 7 12Z">
                            </path>
                        </svg>
                    </div>

                </div>

                <div class="bg-yellow-400 border-[1px] border-main3 rounded-md h-36 p-2">

                    <div class="flex justify-between pt-4 pb-12">
                        <div>
                            <h1 class="font-bold text-6xl text-slate-800 text-center">{{ $semua }}</h1>
                            <h1 class=" text-slate-800 font-bold">Total Guru</h1>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-20 opacity-50 text-black"
                            fill="currentColor">
                            <path
                                d="M8 4C8 5.10457 7.10457 6 6 6 4.89543 6 4 5.10457 4 4 4 2.89543 4.89543 2 6 2 7.10457 2 8 2.89543 8 4ZM5 16V22H3V10C3 8.34315 4.34315 7 6 7 6.82059 7 7.56423 7.32946 8.10585 7.86333L10.4803 10.1057 12.7931 7.79289 14.2073 9.20711 10.5201 12.8943 9 11.4587V22H7V16H5ZM10 5H19V14H10V16H14.3654L17.1889 22H19.3993L16.5758 16H20C20.5523 16 21 15.5523 21 15V4C21 3.44772 20.5523 3 20 3H10V5Z">
                            </path>
                        </svg>
                    </div>

                </div>


                <div class="bg-green-400 border-[1px] border-main3 rounded-md h-36 p-2">

                    <div class="flex justify-between pt-4 pb-12">
                        <div>
                            <h1 class="font-bold text-6xl text-slate-800 text-center">{{ $santri }}</h1>
                            <h1 class=" text-slate-800 font-bold">Total santri</h1>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-20 opacity-50 text-black"
                            fill="currentColor">
                            <path
                                d="M12 2 0 9 12 16 22 10.1667V17.5H24V9L12 2ZM3.99902 13.4905V18.0001C5.82344 20.429 8.72812 22.0001 11.9998 22.0001 15.2714 22.0001 18.1761 20.429 20.0005 18.0001L20.0001 13.4913 12.0003 18.1579 3.99902 13.4905Z">
                            </path>
                        </svg>
                    </div>

                </div>




                {{-- <div class="bg-white border-[1px] border-main3 rounded-md h-36">

                </div>

                <div class="bg-white border-[1px] border-main3 rounded-md h-36">

                </div>

                <div class="bg-white border-[1px] border-main3 rounded-md h-36">

                </div> --}}
            </div>

            <div class="grid gap-4 grid-cols-1 lg:grid-cols-2 mt-4">
                <div class="bg-white border-[1px] border-main3 rounded-md h-[400px]">

                </div>
                <div class="bg-white border-[1px] border-main3 rounded-md h-[400px]">

                </div>
            </div>

            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-4">
                <div class="bg-white border-[1px] border-main3 rounded-md h-[200px]">

                </div>
                <div class="bg-white border-[1px] border-main3 rounded-md h-[200px]">

                </div>
                <div class="bg-white border-[1px] border-main3 rounded-md h-[200px]">

                </div>
                <div class="bg-white border-[1px] border-main3 rounded-md h-[200px]">

                </div>
                <div class="bg-white border-[1px] border-main3 rounded-md h-[200px]">

                </div>
                <div class="bg-white border-[1px] border-main3 rounded-md h-[200px]">

                </div>
            </div>

            <div class="bg-white border-[1px] border-main3 rounded-md h-[400px] w-full mt-4">

            </div>
        </div>

    </section>
@endsection
