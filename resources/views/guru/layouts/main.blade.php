<!DOCTYPE html>
<html>
<head>
    @include('guru.partials.start')
</head>
<body>
    @include('guru.partials.header')
    
    @include('guru.partials.sidebar')
    
    <div id="main-content" class="relative overflow-y-auto md:ml-64 px-4 min-h-screen pb-10">
        <main class="relative max-w-full">
            @yield('container')
        </main>
    </div>
    
    @include('guru.partials.end')
    @include('sweetalert::alert')
    @yield('scripts')
</body>
</html>