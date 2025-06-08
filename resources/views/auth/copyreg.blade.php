@extends('auth.layouts.main')

@section('container')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-900 via-blue-900 to-blue-800 relative overflow-hidden px-4 sm:px-6 lg:px-8">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIHN0cm9rZS13aWR0aD1cIjFcIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD1cIjEwMCVcIiBoZWlnaHQ9XCIxMDAlXCIgZmlsbD1cInVybCgjZ3JpZClcIi8+PC9zdmc+')] opacity-30"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/50 to-transparent"></div>
    <div class="w-full max-w-7xl mx-auto relative z-10 py-12">
        <div class="grid lg:grid-cols-2 gap-8 items-center max-w-6xl mx-auto">
            <div class="order-2 lg:order-1 flex items-center justify-center relative">
                <div class="absolute inset-0 bg-blue-500 rounded-full blur-3xl opacity-20"></div>
                <div class="relative w-full max-w-[400px] aspect-square flex items-center justify-center p-4">
                    <img src="{{ asset('img/kemenag.png') }}" class="w-full h-full object-contain hover:scale-105 transition-transform duration-300" alt="Kemenag Logo" />
                </div>
            </div>

            <div class="order-1 lg:order-2 backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.12)] w-full max-w-md mx-auto">
                <div class="flex justify-center relative">
                    <div class="absolute inset-0 bg-blue-500 rounded-full blur-2xl opacity-20"></div>
                    <img class="relative h-28 w-auto" src="{{ asset('img/logo MIM.png') }}" alt="Logo" />
                </div>

                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-white">
                    Daftar Akun
                </h2>

                <form class="mt-8 space-y-6" action="/register/akun" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-white">Nama</label>
                            <div class="mt-1">
                                <input id="nama" name="nama" type="text" required
                                    class="w-full text-sm text-white bg-white/10 border border-white/20 px-4 py-3.5 rounded-lg outline-blue-400 transition-colors focus:border-blue-400 placeholder-blue-200/70" />
                            </div>
                            @error('nama')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-white">Email</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" required
                                    class="w-full text-sm text-white bg-white/10 border border-white/20 px-4 py-3.5 rounded-lg outline-blue-400 transition-colors focus:border-blue-400 placeholder-blue-200/70" />
                            </div>
                            @error('email')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telepon" class="block text-sm font-medium text-white">Telepon</label>
                            <div class="mt-1">
                                <input id="telepon" name="telepon" type="tel" required
                                    class="w-full text-sm text-white bg-white/10 border border-white/20 px-4 py-3.5 rounded-lg outline-blue-400 transition-colors focus:border-blue-400 placeholder-blue-200/70" />
                            </div>
                            @error('telepon')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="alamat" class="block text-sm font-medium text-white">Alamat</label>
                            <div class="mt-1">
                                <input id="alamat" name="alamat" type="text" placeholder="Kepohbaru"
                                    class="w-full text-sm text-white bg-white/10 border border-white/20 px-4 py-3.5 rounded-lg outline-blue-400 transition-colors focus:border-blue-400 placeholder-blue-200/70" />
                            </div>
                            @error('alamat')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-white">Password</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" required
                                    class="w-full text-sm text-white bg-white/10 border border-white/20 px-4 py-3.5 rounded-lg outline-blue-400 transition-colors focus:border-blue-400 placeholder-blue-200/70" />
                            </div>
                            @error('password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 py-3.5 px-4 text-[15px] font-medium tracking-wide rounded-lg text-white shadow-lg shadow-blue-500/25 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-blue-900 transition-all duration-300">
                            Daftar Akun
                        </button>
                        <p class="text-sm mt-6 text-center text-blue-100">Sudah punya akun? <a href="{{ route('beranda') }}" class="text-blue-300 font-medium hover:text-blue-200 ml-1 whitespace-nowrap transition-colors">Masuk di sini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
