@extends('layouts.app')

@section('title', 'Penambahan Biji Ide',)

@section('contents')
<div class="card shadow mb-4" id="wrapper-task">
    <div class="card-body">
        <form action="{{ route('guru.store-task') }}" method="POST">
            @csrf
            <!-- Wrapper div untuk Nama Murid dengan checkbox -->
            <div class="form-group">
                <label>Nama Murid</label>
                <div class="d-flex flex-wrap gap-4" role="group" aria-label="Checkbox nama murid">
                    <!-- Loop untuk data murid -->
                    @foreach($students as $student)
                    <div class="position-relative">
                        <input type="checkbox" class="btn-check" id="student_{{ $student->id }}" name="assignee[]" value="{{ $student->id }}" autocomplete="off">
                        <label class="btn" for="student_{{ $student->id }}" style="background-color: #526E48; color: #C2FFC7;">{{ $student->name }}</label>
                        <button type="button" class="btn-close position-absolute top-0 end-0 me-1 mt-1" aria-label="Close" style="font-size: 8px" onclick="removeCheckbox('student_{{ $student->id }}')"></button>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select id="input-status" name="status" class="form-control">
                    <option value="not_started">Belum</option>
                    <option value="in_progress">Proses</option>
                    <option value="completed">Selesai</option>
                </select>
            </div>
            <div class="form-group">
                <label id="text-waktu">Waktu Pengumpulan</label>
                <div class="container">
                    <div class="row">
                        <label for="date" class="col-1 col-form-label">Tanggal</label>
                        <div class="col">
                            <div class="input-group date" id="datepicker">
                                <input type="text" id="datepicker" class="form-control" placeholder="Pilih tanggal">
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar" id="icon-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <label for="date" class="col-1 col-form-label">Pukul</label>
                        <div class="col">
                            <div class="input-group clockpicker" data-placement="bottom" data-align="bottom" data-autoclose="true">
                                <input type="text" class="form-control clockpicker" placeholder="Pilih jam">
                                <span class="input-group-addon">
                                    <i class="bi bi-clock"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Prioritas</label>
                <select id="input-prio" name="priority" class="form-control">
                    <option value="low">Rendah</option>
                    <option value="medium">Menengah</option>
                    <option value="high">Tinggi</option>
                </select>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="input-deks" name="description" class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" class="btn" id="btn-simpan-tgs">Simpan Tugas</button>
        </form>
    </div>
</div>
@endsection