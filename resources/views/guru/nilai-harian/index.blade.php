@extends('guru.layouts.main')

@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Nilai Harian</h1>
        <p class="text-gray-600 mt-2">Input dan kelola nilai harian siswa</p>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Kelas dan Mapel</h3>
        <form method="GET" action="{{ route('guru.nilai-harian.index') }}" id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Kelas -->
            <div>
                <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Kelas</option>
                    @if(isset($kelasOptions))
                        @foreach($kelasOptions as $kelas)
                            <option value="{{ $kelas->kelas_id }}" {{ request('kelas_id') == $kelas->kelas_id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Mapel -->
            <div>
                <label for="mapel_id" class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Mapel</option>
                    @if(isset($mapelOptions) && $mapelOptions->count() > 0)
                        @foreach($mapelOptions as $mapel)
                            <option value="{{ $mapel->mapel_id }}" {{ request('mapel_id') == $mapel->mapel_id ? 'selected' : '' }}>
                                {{ $mapel->mapel }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filter
                </button>
            </div>
        </form>
    </div>

    @if(request('kelas_id') && request('mapel_id'))
        <!-- Input Nilai Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Input Nilai Harian</h3>
                <div class="text-sm text-gray-600">
                    <span class="font-medium">Kelas:</span> {{ $selectedKelas->nama_kelas ?? 'N/A' }} |
                    <span class="font-medium">Mapel:</span> {{ $selectedMapel->mapel ?? 'N/A' }}
                </div>
            </div>

            <form action="{{ route('guru.nilai-harian.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ request('kelas_id') }}">
                <input type="hidden" name="mapel_id" value="{{ request('mapel_id') }}">
                
                <!-- Form Fields -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Tanggal -->
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    
                    <!-- Jenis Penilaian -->
                    <div>
                        <label for="jenis_penilaian" class="block text-sm font-medium text-gray-700 mb-2">Jenis Penilaian</label>
                        <select name="jenis_penilaian" id="jenis_penilaian" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Pilih Jenis Penilaian</option>
                            <option value="Tugas">Tugas</option>
                            <option value="Kuis">Kuis</option>
                            <option value="Ulangan Harian">Ulangan Harian</option>
                            <option value="Praktik">Praktik</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <!-- Keterangan -->
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan (Opsional)</label>
                        <input type="text" name="keterangan" id="keterangan" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Contoh: Tugas Matematika Bab 1">
                    </div>
                </div>

                <!-- Daftar Siswa -->
                @if(isset($siswaList) && $siswaList->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($siswaList as $index => $siswa)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $siswa->nama }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->nis }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="hidden" name="nilai[{{ $siswa->siswa_id }}][siswa_id]" value="{{ $siswa->siswa_id }}">
                                            <input type="number" name="nilai[{{ $siswa->siswa_id }}][nilai]" 
                                                min="0" max="100" step="0.1"
                                                class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="0-100">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Nilai
                        </button>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                        </svg>
                        <p class="text-gray-500">Tidak ada siswa ditemukan untuk kelas ini</p>
                    </div>
                @endif
            </form>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Pilih Kelas dan Mata Pelajaran</h3>
            <p class="text-gray-500">Silakan pilih kelas dan mata pelajaran terlebih dahulu untuk mulai input nilai harian siswa.</p>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kelasSelect = document.getElementById('kelas_id');
    const mapelSelect = document.getElementById('mapel_id');
    const filterForm = document.getElementById('filterForm');
    
    // Auto submit when kelas is selected to load mapel options
    kelasSelect.addEventListener('change', function() {
        if (this.value) {
            // Clear mapel selection
            mapelSelect.value = '';
            // Submit form to reload mapel options
            filterForm.submit();
        } else {
            // Clear mapel options if no kelas selected
            mapelSelect.innerHTML = '<option value="">Pilih Mapel</option>';
        }
    });
});
</script>
@endsection