@extends('layouts.app')

@section('title', 'Biji ide ' . ucfirst($userRole))

@section('contents')
<div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('guru.create-task') }}" class="btn" style="background-color: #9EDF9C; color:#526E48">Tambah Biji Ide</a>
</div>
<hr />

@if(Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Tabel Data Biji Ide Murid</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Ide</th>
                        <th class="text-center">Cita-cita</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($biji->count() > 0)
                    @foreach($biji as $rs)
                    <tr>
                        <td class="align-middle">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $rs->nama }}</td>
                        <td class="align-middle">{{ $rs->ide }}</td>
                        <td class="align-middle">{{ $rs->cita_cita }}</td>
                        <td class="align-middle">{{ $rs->deskripsi }}</td>
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('guru.edit-biji', $rs->id) }}" type="button" class="btn btn-warning text-center">Edit</a>
                                <form action="{{ route('guru.destroy-biji', $rs->id) }}" method="POST" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0 text-center">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center" colspan="6">Ide belum ditambahkan</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <!-- Tambahkan JavaScript DataTables dan jQuery -->
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#dataTable').DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Indonesian.json"
                        }
                    });
                });
            </script>
            @endsection