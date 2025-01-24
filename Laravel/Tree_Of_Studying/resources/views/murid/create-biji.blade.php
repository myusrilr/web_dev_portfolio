@extends('layouts.app')

@section('title', 'Tambah Biji Ide')

@section('contents')
<div class="d-flex align-items-center justify-content-between">
</div>
<hr />

@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif

<form action="{{ route('murid.store-biji') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="ide">Ide:</label>
        <input type="text" name="ide" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="cita_cita">Cita-cita:</label>
        <input type="text" name="cita_cita" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Biji Ide</button>
</form>

@endsection
