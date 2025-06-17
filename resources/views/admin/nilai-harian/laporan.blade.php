@extends('admin.layouts.main')

@section('title', 'Laporan Nilai Harian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Nilai Harian</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.nilai-harian.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.nilai-harian.laporan') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="kelas_id" class="form-label">Kelas</label>
                                <select name="kelas_id" id="kelas_id" class="form-select" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->kelas_id }}" {{ request('kelas_id') == $k->kelas_id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select name="semester" id="semester" class="form-select">
                                    <option value="">Semua Semester</option>
                                    <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                                    <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                                <select name="tahun_ajaran" id="tahun_ajaran" class="form-select">
                                    <option value="">Semua Tahun</option>
                                    @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                                        @php
                                            $tahunAjaran = $year . '/' . ($year + 1);
                                        @endphp
                                        <option value="{{ $tahunAjaran }}" {{ request('tahun_ajaran') == $tahunAjaran ? 'selected' : '' }}>
                                            {{ $tahunAjaran }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Generate Laporan</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(request('kelas_id') && isset($laporan))
                        <!-- Info Laporan -->
                        <div class="alert alert-info">
                            <strong>Laporan Nilai Harian</strong><br>
                            Kelas: {{ $kelasInfo->nama_kelas }}<br>
                            @if(request('semester'))
                                Semester: {{ request('semester') }}<br>
                            @endif
                            @if(request('tahun_ajaran'))
                                Tahun Ajaran: {{ request('tahun_ajaran') }}<br>
                            @endif
                            Total Siswa: {{ count($laporan) }}
                        </div>

                        @if(count($laporan) > 0)
                            <!-- Tabel Laporan -->
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">NIS</th>
                                            <th rowspan="2">Nama Siswa</th>
                                            @foreach($mapels as $mapel)
                                                <th colspan="2" class="text-center">{{ $mapel->nama_mapel }}</th>
                                            @endforeach
                                            <th rowspan="2">Rata-rata</th>
                                        </tr>
                                        <tr>
                                            @foreach($mapels as $mapel)
                                                <th class="text-center">Jumlah Nilai</th>
                                                <th class="text-center">Rata-rata</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($laporan as $index => $siswa)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $siswa['nis'] }}</td>
                                                <td>{{ $siswa['nama'] }}</td>
                                                @foreach($mapels as $mapel)
                                                    @php
                                                        $nilaiMapel = $siswa['nilai_per_mapel'][$mapel->mapel_id] ?? null;
                                                    @endphp
                                                    <td class="text-center">
                                                        {{ $nilaiMapel ? $nilaiMapel['jumlah'] : 0 }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if($nilaiMapel && $nilaiMapel['rata_rata'] > 0)
                                                            <span class="badge {{ $nilaiMapel['rata_rata'] >= 75 ? 'bg-success' : 'bg-danger' }}">
                                                                {{ number_format($nilaiMapel['rata_rata'], 1) }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">-</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                                <td class="text-center">
                                                    @if($siswa['rata_rata_keseluruhan'] > 0)
                                                        <span class="badge {{ $siswa['rata_rata_keseluruhan'] >= 75 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ number_format($siswa['rata_rata_keseluruhan'], 1) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-secondary">
                                        <tr>
                                            <th colspan="3">Rata-rata Kelas</th>
                                            @foreach($mapels as $mapel)
                                                @php
                                                    $totalNilai = 0;
                                                    $jumlahSiswa = 0;
                                                    foreach($laporan as $siswa) {
                                                        if(isset($siswa['nilai_per_mapel'][$mapel->mapel_id]) && $siswa['nilai_per_mapel'][$mapel->mapel_id]['rata_rata'] > 0) {
                                                            $totalNilai += $siswa['nilai_per_mapel'][$mapel->mapel_id]['rata_rata'];
                                                            $jumlahSiswa++;
                                                        }
                                                    }
                                                    $rataRataMapel = $jumlahSiswa > 0 ? $totalNilai / $jumlahSiswa : 0;
                                                @endphp
                                                <th class="text-center">-</th>
                                                <th class="text-center">
                                                    @if($rataRataMapel > 0)
                                                        <span class="badge {{ $rataRataMapel >= 75 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ number_format($rataRataMapel, 1) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">-</span>
                                                    @endif
                                                </th>
                                            @endforeach
                                            <th class="text-center">
                                                @php
                                                    $totalKeseluruhan = 0;
                                                    $jumlahSiswaKeseluruhan = 0;
                                                    foreach($laporan as $siswa) {
                                                        if($siswa['rata_rata_keseluruhan'] > 0) {
                                                            $totalKeseluruhan += $siswa['rata_rata_keseluruhan'];
                                                            $jumlahSiswaKeseluruhan++;
                                                        }
                                                    }
                                                    $rataRataKelas = $jumlahSiswaKeseluruhan > 0 ? $totalKeseluruhan / $jumlahSiswaKeseluruhan : 0;
                                                @endphp
                                                @if($rataRataKelas > 0)
                                                    <span class="badge {{ $rataRataKelas >= 75 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ number_format($rataRataKelas, 1) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Tombol Export -->
                            <div class="mt-3">
                                <a href="{{ route('admin.nilai-harian.export') }}?{{ http_build_query(request()->query()) }}" 
                                   class="btn btn-success">
                                    <i class="fas fa-download"></i> Export Laporan
                                </a>
                            </div>
                        @else
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle"></i>
                                Tidak ada data nilai harian untuk filter yang dipilih.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle"></i>
                            Silakan pilih kelas untuk generate laporan nilai harian.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto submit form when kelas changes
    $('#kelas_id').change(function() {
        if ($(this).val()) {
            $(this).closest('form').submit();
        }
    });
});
</script>
@endpush