@extends('auth.layouts.main')

@section('container')
<div class="min-h-screen flex items-center justify-center bg-gray-100 relative overflow-hidden px-4 sm:px-6 lg:px-8"> 
  <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-gray-200"></div>
  <div class="w-full max-w-7xl mx-auto relative z-10 py-12"> 
    <div class="grid lg:grid-cols-2 gap-8 items-center max-w-6xl mx-auto"> 
      <div class="order-2 lg:order-1 bg-white border border-gray-200 rounded-2xl p-8 shadow-lg w-full max-w-md mx-auto"> 
        <div class="flex justify-center space-x-4 mb-6">
          <img src="{{ asset('img/kemenag.png') }}" class="h-16 w-auto object-contain" alt="Logo Kemenag" />
          <img src="{{ asset('img/logo MIM.png') }}" class="h-16 w-auto object-contain" alt="Logo MIM" />
        </div>
        <div class="text-center mb-8">
          <h1 class="text-gray-800 text-4xl font-bold mb-2">SISMO</h1>
          <p class="text-gray-600 text-lg">Sistem Informasi Sekolah Modern</p>
        </div>
        <form class="space-y-6" action="/masuk" method="POST"> 
          @csrf
          <div class="space-y-5"> 
            <div>
              <label class="text-gray-700 text-sm font-medium mb-2 block">Email</label> 
              <div class="relative flex items-center"> 
                <input name="email" type="email" required class="w-full text-sm text-gray-800 bg-gray-50 border border-gray-300 pl-4 pr-10 py-3.5 rounded-lg outline-blue-600 transition-colors focus:border-blue-600 focus:bg-white placeholder-gray-500 @error('email') border-red-500 @enderror" placeholder="Masukkan email Anda" value="{{ old('email') }}" /> 
                <svg xmlns="http://www.w3.org/2000/svg" fill="#6b7280" stroke="#6b7280" class="w-[18px] h-[18px] absolute right-4 opacity-70" viewBox="0 0 24 24"> 
                  <circle cx="10" cy="7" r="6"></circle> 
                  <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z"></path> 
                </svg> 
              </div>
              @error('email')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div> 

            <div>
              <label class="text-gray-700 text-sm font-medium mb-2 block">Kata Sandi</label> 
              <div class="relative flex items-center"> 
                <input name="password" type="password" required class="w-full text-sm text-gray-800 bg-gray-50 border border-gray-300 pl-4 pr-10 py-3.5 rounded-lg outline-blue-600 transition-colors focus:border-blue-600 focus:bg-white placeholder-gray-500 @error('password') border-red-500 @enderror" placeholder="Masukkan kata sandi" /> 
                <svg xmlns="http://www.w3.org/2000/svg" fill="#6b7280" stroke="#6b7280" class="w-[18px] h-[18px] absolute right-4 cursor-pointer opacity-70" viewBox="0 0 128 128"> 
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
              <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 bg-gray-50 border-gray-300 rounded text-blue-600 focus:ring-blue-500 focus:ring-offset-0" /> 
              <label for="remember-me" class="ml-3 block text-sm text-gray-700">Ingat saya</label> 
            </div> 
            <div class="text-sm"> 
              <a href="javascript:void(0);" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">Lupa kata sandi?</a> 
            </div> 
          </div> 

          <div class="mt-8"> 
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 py-3.5 px-4 text-[15px] font-medium tracking-wide rounded-lg text-white shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300">Masuk</button> 
            <p class="text-sm mt-6 text-center text-gray-600">Belum punya akun? <a href="/register" class="text-blue-600 font-medium hover:text-blue-700 ml-1 whitespace-nowrap transition-colors">Daftar di sini</a></p> 
          </div> 
        </form> 
      </div> 

      <div class="order-1 lg:order-2 flex items-center justify-center relative"> 
        <div class="absolute inset-0 bg-blue-600 rounded-full blur-3xl opacity-10"></div>
        <div class="relative w-full max-w-[500px] aspect-square flex items-center justify-center p-4">
            <div class="w-full h-full relative overflow-hidden rounded-2xl shadow-2xl">
                <img src="{{ asset('img/gambar.jpg') }}" alt="Foto Lembaga" class="absolute inset-0 w-full h-full object-cover z-0">
                <div class="absolute inset-0 bg-gradient-to-br from-gray-900/60 to-gray-800/60 z-10"></div>
                <div class="absolute bottom-6 left-6 right-6 z-20">
                    <h3 class="text-white text-xl font-bold mb-2">Madrasah Ibtidaiyah Muhammadiyah</h3>
                    <p class="text-gray-200 text-sm">Pendidikan Berkualitas dengan Nilai-Nilai Islami</p>
                </div>
            </div>
        </div>
      </div> 
    </div> 
  </div> 
</div>
@endsection