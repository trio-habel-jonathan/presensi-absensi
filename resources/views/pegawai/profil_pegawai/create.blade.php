@extends('layouts.pegawai')

@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Isi Data Diri Kamu</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pegawai.profil.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-xs font-weight-bold">Name</label>
                            <input type="text" name="nama_pegawai" class="form-control" value="{{ old('nama_pegawai') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-xs font-weight-bold">Identity Number</label>
                            <input type="text" name="no_identitas" class="form-control" value="{{ old('no_identitas') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-xs font-weight-bold">Place of Birth</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-xs font-weight-bold">Date of Birth</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-xs font-weight-bold">Gender</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Male</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-xs font-weight-bold">Phone Number</label>
                            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon') }}" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label text-xs font-weight-bold">Address</label>
                            <textarea name="alamat" class="form-control" rows="4" required>{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    {{-- Hidden Fields (Set by Controller) --}}
                    {{-- id_user, id_jenis_pegawai, id_golongan will be set in controller --}}

                    <div class="d-flex justify-content-end">
                        {{-- <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm me-2">Cancel</a> --}}
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
