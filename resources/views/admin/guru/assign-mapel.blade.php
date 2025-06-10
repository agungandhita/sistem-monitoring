@extends('admin.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Assign Mata Pelajaran ke Guru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.guru.index') }}" class="btn btn-sm btn-outline-secondary">
                <span data-feather="arrow-left"></span>
                Kembali
            </a>
        </div>
    </div>
</div>

@if(session()->has('success'))
    <div class="alert alert-success col-lg-8" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger col-lg-8" role="alert">
        {{ session('error') }}
    </div>
@endif

<div class="col-lg-8">
    <form method="post" action="{{ route('admin.guru.store-assign-mapel') }}">
        @csrf
        <div class="mb-3">
            <label for="guru_id" class="form-label">Pilih Guru</label>
            <select class="form-select @error('guru_id') is-invalid @enderror" id="guru_id" name="guru_id" required>
                <option value="">-- Pilih Guru --</option>
                @foreach($gurus as $guru)
                    <option value="{{ $guru->guru_id }}" {{ old('guru_id') == $guru->guru_id ? 'selected' : '' }}>
                        {{ $guru->nama }} ({{ $guru->nip }})
                    </option>
                @endforeach
            </select>
            @error('guru_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="mapel_id" class="form-label">Pilih Mata Pelajaran</label>
            <select class="form-select @error('mapel_id') is-invalid @enderror" id="mapel_id" name="mapel_id" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->mapel_id }}" {{ old('mapel_id') == $mapel->mapel_id ? 'selected' : '' }}>
                        {{ $mapel->nama_mapel }} ({{ $mapel->kode_mapel }})
                    </option>
                @endforeach
            </select>
            @error('mapel_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas') }}" required>
            @error('kelas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
            <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', '2023/2024') }}" required>
            @error('tahun_ajaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="">-- Pilih Status --</option>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
            @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan (Opsional)</label>
            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
            @error('catatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Assign Mata Pelajaran</button>
    </form>
</div>

<div class="col-lg-12 mt-5">
    <h3>Daftar Assignment Saat Ini</h3>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Guru</th>
                    <th scope="col">Mata Pelajaran</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Tahun Ajaran</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $assignment->guru->nama }}</td>
                    <td>{{ $assignment->mapel->nama_mapel }}</td>
                    <td>{{ $assignment->kelas }}</td>
                    <td>{{ $assignment->tahun_ajaran }}</td>
                    <td>
                        <span class="badge {{ $assignment->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($assignment->status) }}
                        </span>
                    </td>
                    <td>
                        <form class="d-inline" action="{{ route('admin.guru.remove-assign-mapel', $assignment->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')">
                                <span data-feather="x-circle"></span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection