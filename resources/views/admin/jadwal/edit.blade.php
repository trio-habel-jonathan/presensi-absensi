@extends('layouts.app')

@section('content')
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Form Edit Jadwal</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('jadwal.update', $jadwal) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="text-sm font-weight-bold">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $jadwal->tanggal) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-sm font-weight-bold">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="kerja" {{ old('status', $jadwal->status) == 'kerja' ? 'selected' : '' }}>Kerja</option>
                                <option value="libur" {{ old('status', $jadwal->status) == 'libur' ? 'selected' : '' }}>Libur</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="text-sm font-weight-bold">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan', $jadwal->keterangan) }}">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection