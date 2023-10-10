@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

<div class="container">
    <h2>Edit Page</h2>
    <form action="{{ route('dashboard.updateFile', $file->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- File Details -->
        <div class="form-group row">
            <div class="col-md-6">
                <label for="nama" class="col-form-label">Nama:</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ $file->nama }}">
            </div>
            <div class="col-md-6">
    <label for="student_id" class="col-form-label">Sekolah/Universitas:</label>
    <select name="student_id" id="student_id" class="form-control" style="color: #252525; height: 45px;"> 
    <option value="" style="color: #252525;">Select Sekolah</option>
        @foreach ($studentList as $student)
        <option value="{{ $student->id }}" style="color: #252525;">{{ $student->sekolah }}</option>
                {{ $student->sekolah }}
            </option>
        @endforeach
    </select>
</div>
            <div class="form-group row">
            <div class="col-md-6">
    <label for="jurusan" class="col-form-label">Jurusan:</label>
    <select multiple name="jurusan[]" id="jurusan" class="form-control">
        @foreach ($jurusans as $jurusan)
            <option value="{{ $jurusan->id }}" {{ in_array($jurusan->id, $selectedJurusans) ? 'selected' : '' }}>
                {{ $jurusan->name }}
            </option>
        @endforeach
    </select>
</div>

            <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>

<script>
    new MultiSelectTag('jurusan')  // id
</script>
       
            <div class="col-md-6">
                <label for="tempat" class="col-form-label">Tempat Lahir:</label>
                <input type="text" name="tempat" id="tempat" class="form-control" value="{{ $file->tempat }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="tgl_lahir" class="col-form-label">Tanggal Lahir:</label>
                <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control" value="{{ $file->tgl_lahir }}">
            </div>
            <div class="col-md-6">
                <label for="posisi" class="col-form-label">Posisi:</label>
                <input type="text" name="posisi" id="posisi" class="form-control" value="{{ $file->posisi }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="tgl_join" class="col-form-label">Tanggal Join:</label>
                <input type="date" name="tgl_join" id="tgl_join" class="form-control" value="{{ $file->tgl_join }}">
            </div>
            <div class="col-md-6">
                <label for="tgl_keluar" class="col-form-label">Tanggal Keluar:</label>
                <input type="date" name="tgl_keluar" id="tgl_keluar" class="form-control" value="{{ $file->tgl_keluar }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="alasan_keluar" class="col-form-label">Alasan Keluar:</label>
                <input type="text" name="alasan_keluar" id="alasan_keluar" class="form-control" value="{{ $file->alasan_keluar }}">
            </div>
        </div>
        
        <!-- File Upload -->
        <div class="form-group row">
            <div class="col-md-12">
                <label for="new_file" class="col-form-label">Upload New File:</label>
                <input type="file" name="new_file" id="new_file" accept=".doc, .docx, .pdf" class="form-control">
            </div>
        </div>
        
        <div class="form-group row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.master_karyawan') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection