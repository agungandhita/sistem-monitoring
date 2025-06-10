@extends('admin.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Guru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.guru.assign-mapel') }}" class="btn btn-sm btn-outline-secondary">
                <span data-feather="plus"></span>
                Assign Mata Pelajaran
            </a>
        </div>
    </div>
</div>

@if(session()->has('success'))
    <div class="alert alert-success col-lg-8" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="table-responsive col-lg-12">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NUPTK</th>
                <th scope="col">NIP</th>
                <th scope="col">Nama</th>
                <th scope="col">Jabatan</th>
                <th scope="col">Email</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Telepon</th>
                <th scope="col">Mata Pelajaran</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gurus as $guru)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $guru->nuptk }}</td>
                <td>{{ $guru->nip }}</td>
                <td>{{ $guru->nama }}</td>
                <td>{{ $guru->jabatan }}</td>
                <td>{{ $guru->email }}</td>
                <td>{{ $guru->jenis_kelamin }}</td>
                <td>{{ $guru->telepon }}</td>
                <td>
                    @if($guru->mapels->count() > 0)
                        @foreach($guru->mapels as $mapel)
                            <span class="badge bg-primary me-1">{{ $mapel->nama_mapel }}</span>
                        @endforeach
                    @else
                        <span class="text-muted">Belum ada mata pelajaran</span>
                    @endif
                </td>
                <td>
                    <a href="#" class="badge bg-info text-decoration-none">
                        <span data-feather="eye"></span>
                    </a>
                    <a href="#" class="badge bg-warning text-decoration-none">
                        <span data-feather="edit"></span>
                    </a>
                    <form class="d-inline" action="#" method="post">
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
@endsection