@extends('layouts.app')

@section('title', 'Edit Biji Ide')

@section('contents')
<div class="container">
    <h2 class="my-4 text-success">Edit Biji Ide</h2>
    <form action="{{ route('guru.update-biji', $biji->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nama">Nama Murid</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ $biji->nama }}" required>
        </div>

        <div class="form-group">
            <label for="ide">Ide</label>
            <input type="text" name="ide" id="ide" class="form-control" value="{{ $biji->ide }}" required>
        </div>

        <div class="form-group">
            <label for="cita_cita">Cita-cita</label>
            <input type="text" name="cita_cita" id="cita_cita" class="form-control" value="{{ $biji->cita_cita }}" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required>{{ $biji->deskripsi }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('guru.biji-ide') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
