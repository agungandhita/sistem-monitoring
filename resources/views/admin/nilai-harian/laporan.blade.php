@extends('admin.layouts.main')

@section('title', 'Laporan Nilai Harian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Nilai Harian</h3>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.nilai-harian.laporan') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="kelas_id" class="form-label">Kelas</label>
                                <select name="kelas_id" id="kelas_id" class="form-select" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($kelasOptions as $kelas)
                                        <option value="{{ $kelas->kelas_id }}" {{ request('kelas_id') == $kelas->kelas_id ? 'selected' : '' }}>
                                            {{ $kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select name="semester" id="semester" class="form-select">
                                    <option value="">Pilih Semester</option>
                                    @foreach($semesterOptions as $sem)
                                        <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>
                                            {{ $sem }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                                <select name="tahun_ajaran" id="tahun_ajaran" class="form-select">
                                    <option value="">Pilih Tahun Ajaran</option>
                                    @foreach($tahunAjaranOptions as $tahun)
                                        <option value="{{ $tahun }}" {{ request('tahun_ajaran') == $tahun ? 'selected' : '' }}>
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(request('kelas_id') && !empty($laporanData))
                        <!-- Tombol Export -->
                        <div class="mb-3">
                            <a href="{{ route('admin.nilai-harian.export') }}?{{ http_build_query(request()->query()) }}" 
                               class="btn btn-success">
                                <i class="fas fa-download"></i> Export Laporan
                            </a>
                        </div>

                        <!-- Laporan Per Siswa -->
                        @foreach($laporanData as $siswaData)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ $siswaData['siswa']->nama }}</h5>
                                    <small class="text-muted">NIS: {{ $siswaData['siswa']->nis }}</small>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Mata Pelajaran</th>
                                                    <th>Jumlah Nilai</th>
                                                    <th>Rata-rata</th>
                                                    <th>Detail Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalRataRata = 0;
                                                    $jumlahMapel = 0;
                                                @endphp
                                                @foreach($siswaData['mapel'] as $mapelNama => $mapelData)
                                                    <tr>
                                                        <td>{{ $mapelData['mapel_info']->nama_mapel }}</td>
                                                        <td>{{ $mapelData['total_nilai'] }}</td>
                                                        <td>
                                                            @if($mapelData['rata_rata'])
                                                                <span class="badge {{ $mapelData['rata_rata'] >= 75 ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ number_format($mapelData['rata_rata'], 1) }}
                                                                </span>
                                                                @php
                                                                    $totalRataRata += $mapelData['rata_rata'];
                                                                    $jumlahMapel++;
                                                                @endphp
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($mapelData['nilai_list']->count() > 0)
                                                                @foreach($mapelData['nilai_list']->take(5) as $nilai)
                                                                    <small class="badge bg-light text-dark me-1">
                                                                        {{ $nilai->nilai }} ({{ \Carbon\Carbon::parse($nilai->tanggal)->format('d/m') }})
                                                                    </small>
                                                                @endforeach
                                                                @if($mapelData['nilai_list']->count() > 5)
                                                                    <small class="text-muted">... dan {{ $mapelData['nilai_list']->count() - 5 }} lainnya</small>
                                                                @endif
                                                            @else
                                                                <small class="text-muted">Belum ada nilai</small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="table-dark">
                                                <tr>
                                                    <th>Rata-rata Keseluruhan</th>
                                                    <th>-</th>
                                                    <th>
                                                        @if($jumlahMapel > 0)
                                                            @php $rataKeseluruhan = $totalRataRata / $jumlahMapel; @endphp
                                                            <span class="badge {{ $rataKeseluruhan >= 75 ? 'bg-success' : 'bg-danger' }}">
                                                                {{ number_format($rataKeseluruhan, 1) }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </th>
                                                    <th>-</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @elseif(request('kelas_id') && empty($laporanData))
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i>
                            Tidak ada data laporan untuk filter yang dipilih.
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle"></i>
                            Silakan pilih kelas untuk melihat laporan nilai harian.
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