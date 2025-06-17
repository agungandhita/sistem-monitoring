@extends('admin.layouts.main')

@section('title', 'Nilai Harian Siswa')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nilai Harian Siswa</h3>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.nilai-harian.index') }}" class="mb-4">
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
                                <label for="mapel_id" class="form-label">Mata Pelajaran</label>
                                <select name="mapel_id" id="mapel_id" class="form-select">
                                    <option value="">Semua Mata Pelajaran</option>
                                    @foreach($mapels as $mapel)
                                        <option value="{{ $mapel->mapel_id }}" {{ request('mapel_id') == $mapel->mapel_id ? 'selected' : '' }}>
                                            {{ $mapel->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="bulan" class="form-label">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select">
                                    <option value="">Semua Bulan</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                    @endfor
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

                    @if(request('kelas_id'))
                        <!-- Statistik Kelas -->
                        @if($statistik)
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h5>Total Nilai</h5>
                                            <h3>{{ $statistik['total_nilai'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h5>Rata-rata Kelas</h5>
                                            <h3>{{ number_format($statistik['rata_rata'], 1) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h5>Nilai Tertinggi</h5>
                                            <h3>{{ $statistik['nilai_tertinggi'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h5>Nilai Terendah</h5>
                                            <h3>{{ $statistik['nilai_terendah'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Tabel Nilai Harian -->
                        @if($nilaiHarian->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Siswa</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Jenis Penilaian</th>
                                            <th>Nilai</th>
                                            <th>Keterangan</th>
                                            <th>Guru</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($nilaiHarian as $index => $nilai)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $nilai->tanggal->format('d/m/Y') }}</td>
                                                <td>{{ $nilai->siswa->nama }}</td>
                                                <td>{{ $nilai->mapel->nama_mapel }}</td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $nilai->jenis_penilaian }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $nilai->nilai >= 75 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $nilai->nilai }}
                                                    </span>
                                                </td>
                                                <td>{{ $nilai->keterangan ?? '-' }}</td>
                                                <td>{{ $nilai->guru->nama }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $nilaiHarian->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i>
                                Tidak ada data nilai harian untuk filter yang dipilih.
                            </div>
                        @endif

                        <!-- Tombol Export -->
                        @if($nilaiHarian->count() > 0)
                            <div class="mt-3">
                                <a href="{{ route('admin.nilai-harian.export') }}?{{ http_build_query(request()->query()) }}" 
                                   class="btn btn-success">
                                    <i class="fas fa-download"></i> Export Data
                                </a>
                                <a href="{{ route('admin.nilai-harian.laporan') }}?{{ http_build_query(request()->query()) }}" 
                                   class="btn btn-info">
                                    <i class="fas fa-chart-bar"></i> Lihat Laporan
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle"></i>
                            Silakan pilih kelas untuk melihat data nilai harian.
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