@extends('admin.layouts.main')

@section('title', 'Laporan Nilai Harian')

@section('container')
<div class="min-h-screen bg-gray-50 mt-24">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-full px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Laporan Nilai Harian</h1>
                    <p class="text-gray-600 mt-2">Laporan komprehensif nilai harian siswa per kelas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-full px-4 sm:px-6 lg:px-8 py-6">
        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Laporan</h3>
            <form method="GET" action="{{ route('admin.nilai-harian.laporan') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Kelas -->
                <div>
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($kelasOptions as $kelas)
                            <option value="{{ $kelas->kelas_id }}" {{ request('kelas_id') == $kelas->kelas_id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Semester -->
                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                    <select name="semester" id="semester" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Semester</option>
                        @foreach($semesterOptions as $sem)
                            <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>
                                {{ $sem }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun Ajaran -->
                <div>
                    <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
                    <select name="tahun_ajaran" id="tahun_ajaran" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach($tahunAjaranOptions as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun_ajaran') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
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

        @if(request('kelas_id') && !empty($laporanData))
            <!-- Export Button -->
            <div class="mb-6">
                <a href="{{ route('admin.nilai-harian.export') }}?{{ http_build_query(request()->query()) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Laporan
                </a>
            </div>

            <!-- Laporan Per Siswa -->
            <div class="space-y-6">
                @foreach($laporanData as $siswaData)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <!-- Student Header -->
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $siswaData['siswa']->nama }}</h3>
                                    <p class="text-sm text-gray-600">NIS: {{ $siswaData['siswa']->nis }}</p>
                                </div>
                                <div class="text-right">
                                    @php
                                        $totalRataRata = 0;
                                        $jumlahMapel = 0;
                                        foreach($siswaData['mapel'] as $mapelData) {
                                            if($mapelData['rata_rata']) {
                                                $totalRataRata += $mapelData['rata_rata'];
                                                $jumlahMapel++;
                                            }
                                        }
                                        $rataKeseluruhan = $jumlahMapel > 0 ? $totalRataRata / $jumlahMapel : 0;
                                    @endphp
                                    <div class="text-sm text-gray-600">Rata-rata Keseluruhan</div>
                                    @if($jumlahMapel > 0)
                                        <div class="text-2xl font-bold {{ $rataKeseluruhan >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($rataKeseluruhan, 1) }}
                                        </div>
                                    @else
                                        <div class="text-2xl font-bold text-gray-400">-</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Subject Details -->
                        <div class="p-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Nilai</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($siswaData['mapel'] as $mapelNama => $mapelData)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $mapelData['mapel_info']->mapel }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $mapelData['total_nilai'] }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($mapelData['rata_rata'])
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $mapelData['rata_rata'] >= 75 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ number_format($mapelData['rata_rata'], 1) }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if($mapelData['nilai_list']->count() > 0)
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($mapelData['nilai_list']->take(5) as $nilai)
                                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                                    {{ $nilai->nilai }} ({{ \Carbon\Carbon::parse($nilai->tanggal)->format('d/m') }})
                                                                </span>
                                                            @endforeach
                                                            @if($mapelData['nilai_list']->count() > 5)
                                                                <span class="text-xs text-gray-500">... +{{ $mapelData['nilai_list']->count() - 5 }} lainnya</span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-sm text-gray-400">Belum ada nilai</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(request('kelas_id') && empty($laporanData))
            <!-- No Data State -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Data</h3>
                <p class="text-gray-500">Tidak ada data laporan untuk filter yang dipilih.</p>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-yellow-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Pilih Kelas</h3>
                <p class="text-gray-500">Silakan pilih kelas untuk melihat laporan nilai harian.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto submit form when kelas changes
    const kelasSelect = document.getElementById('kelas_id');
    if (kelasSelect) {
        kelasSelect.addEventListener('change', function() {
            if (this.value) {
                this.closest('form').submit();
            }
        });
    }
});
</script>
@endpush
@endsection