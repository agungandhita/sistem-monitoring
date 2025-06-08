@extends('wali.layouts.main')

@section('container')
    <section>
        @include('wali.dashboard._header')

        {{-- isi --}}

        <div class="pt-24 bg-slate-200 container w-full max-h-screen md:h-screen overflow-auto">


            <div class="dark:bg-slate-800 shadow-best bg-white rounded-md justify-between">
                <p class="mb-2 text-md md:text-2xl font-semibold py-2 mx-4 text-blue-500 capitalize">
                    hallo, {{ auth()->user()->nama }}
                </p>
                <p class="text-black font-semibold px-4 text-md pb-2">
                    dalam dashboard bapak ibu bisa memantau perkembangan putra putri anda
                </p>
            </div>



            {{-- card 1 --}}
            <div class="grid w-full grid-cols-1 gap-4 mt-4 xl:grid-cols-2 2xl:grid-cols-3 pb-4 ">
                @foreach ($santri as $no => $item)
                    <div
                        class="items-center justify-between p-4 bg-yellow-300 border border-gray-200 relative rounded-lg shadow-sm sm:p-6 ">
                        <div class="w-full">

                            <div class="flex justify-between pt-8 pb-12">
                                <div class="pt-6">
                                    <h1 class="font-bold text-4xl text-black">Santri</h1>
                                    <h1 class="text-black font-semibold">{{ $item->kelas->nama_kelas }}</h1>
                                </div>

                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 mx-auto  opacity-50" fill="black"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z">
                                        </path>
                                    </svg>
                                    <h1 class="text-black font-semibold text-sm ">{{ $item->nama }}</h1>
                                </div>

                            </div>

                            <button onclick="document.getElementById('modaledit_{{ $no }}').showModal()"
                                class="absolute bottom-0 left-0 right-0 bg-yellow-400/50 font-semibold text-lg text-center rounded-b-md p-2 text-black">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            @foreach ($santri as $lihat => $cek)
                <dialog id="modaledit_{{ $lihat }}" class="modal">
                    <div class="modal-box bg-white">
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>

                        <label class="items-center gap-2">
                            @php
                                $nilaiQuran = $cek->nilai_quran ?? null;
                                $nilaiNadzom = $cek->nilai_nadzom ?? null;
                            @endphp

                            @if ($nilaiQuran !== null)
                                <p class="text-black font-semibold">Nilai Quran: {{ $nilaiQuran }}</p>
                            @endif

                            @if ($nilaiNadzom !== null)
                                <p class="text-black font-semibold">Nilai Nadzom: {{ $nilaiNadzom }}</p>
                            @endif

                            @if ($nilaiQuran === null && $nilaiNadzom === null)
                                <p class="text-black font-semibold"> Nilai belum tersedia.</p>
                            @endif
                        </label>

                    </div>
                </dialog>
            @endforeach

    </section>
@endsection
