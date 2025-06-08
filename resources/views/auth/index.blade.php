@extends('auth.layouts.main')

@section('container')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-900 via-blue-900 to-blue-800 relative overflow-hidden px-4 sm:px-6 lg:px-8"> 
  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMSkiIHN0cm9rZS13aWR0aD1cIjFcIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD1cIjEwMCVcIiBoZWlnaHQ9XCIxMDAlXCIgZmlsbD1cInVybCgjZ3JpZClcIi8+PC9zdmc+')] opacity-30"></div>
  <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/50 to-transparent"></div>
  <div class="w-full max-w-7xl mx-auto relative z-10 py-12"> 
    <div class="grid lg:grid-cols-2 gap-8 items-center max-w-6xl mx-auto"> 
      <div class="order-2 lg:order-1 backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.12)] w-full max-w-md mx-auto"> 
        <div class="flex justify-center space-x-4 mb-6">
          <img src="{{ asset('img/kemenag.png') }}" class="h-16 w-auto object-contain" alt="Logo Kemenag" />
          <img src="{{ asset('img/logo MIM.png') }}" class="h-16 w-auto object-contain" alt="Logo MIM" />
        </div>
        <div class="text-center mb-8">
          <h1 class="text-white text-4xl font-bold mb-2">SISMO</h1>
          <p class="text-blue-100 text-lg">Sistem Informasi Sekolah Modern</p>
        </div>
        <form class="space-y-6" action="/masuk" method="POST"> 
          @csrf
          <div class="space-y-5"> 
            <div>
              <label class="text-white text-sm font-medium mb-2 block">Email</label> 
              <div class="relative flex items-center"> 
                <input name="email" type="email" required class="w-full text-sm text-white bg-white/10 border border-white/20 pl-4 pr-10 py-3.5 rounded-lg outline-blue-400 transition-colors focus:border-blue-400 placeholder-blue-200/70 @error('email') border-red-500 @enderror" placeholder="Masukkan email Anda" value="{{ old('email') }}" /> 
                <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" stroke="#fff" class="w-[18px] h-[18px] absolute right-4 opacity-70" viewBox="0 0 24 24"> 
                  <circle cx="10" cy="7" r="6"></circle> 
                  <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z"></path> 
                </svg> 
              </div>
              @error('email')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div> 

            <div>
              <label class="text-white text-sm font-medium mb-2 block">Kata Sandi</label> 
              <div class="relative flex items-center"> 
                <input name="password" type="password" required class="w-full text-sm text-white bg-white/10 border border-white/20 pl-4 pr-10 py-3.5 rounded-lg outline-blue-400 transition-colors focus:border-blue-400 placeholder-blue-200/70 @error('password') border-red-500 @enderror" placeholder="Masukkan kata sandi" /> 
                <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" stroke="#fff" class="w-[18px] h-[18px] absolute right-4 cursor-pointer opacity-70" viewBox="0 0 128 128"> 
                  <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"></path> 
                </svg> 
              </div>
              @error('password')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div> 

          <div class="flex flex-wrap items-center justify-between gap-4 mt-6"> 
            <div class="flex items-center"> 
              <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 bg-white/10 border-white/20 rounded text-blue-500 focus:ring-blue-400 focus:ring-offset-0" /> 
              <label for="remember-me" class="ml-3 block text-sm text-white">Ingat saya</label> 
            </div> 
            <div class="text-sm"> 
              <a href="javascript:void(0);" class="text-blue-300 hover:text-blue-200 font-medium transition-colors">Lupa kata sandi?</a> 
            </div> 
          </div> 

          <div class="mt-8"> 
            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 py-3.5 px-4 text-[15px] font-medium tracking-wide rounded-lg text-white shadow-lg shadow-blue-500/25 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-blue-900 transition-all duration-300">Masuk</button> 
            <p class="text-sm mt-6 text-center text-blue-100">Belum punya akun? <a href="/register" class="text-blue-300 font-medium hover:text-blue-200 ml-1 whitespace-nowrap transition-colors">Daftar di sini</a></p> 
          </div> 
        </form> 
      </div> 

      <div class="order-1 lg:order-2 flex items-center justify-center relative"> 
        <div class="absolute inset-0 bg-blue-500 rounded-full blur-3xl opacity-20"></div>
        <div class="relative w-full max-w-[400px] aspect-square flex items-center justify-center p-4">
            <div class="w-full h-full relative overflow-hidden rounded-lg">
                <img src="{{ asset('img/gambar.jpg') }}" alt="Foto Lembaga" class="absolute inset-0 w-full h-full object-cover z-0">
                <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 to-gray-800/80 z-10"></div>
            </div>
        </div>
      </div> 
    </div> 
  </div> 
</div>
@endsection