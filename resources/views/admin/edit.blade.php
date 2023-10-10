@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

<h1>Edit Student</h1>

<form action="{{ route('students.update', ['student' => $student->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="sekolah">Sekolah:</label>
        <input type="text" id="sekolah" name="sekolah" value="{{ $student->sekolah }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" value="{{ $student->alamat }}" class="form-control">
    </div>
    <select name="jurusans[]"  id="jurusan" class="form-input" multiple required>
    @foreach($jurusans as $jurusan)
        <option value="{{ $jurusan->id }}" {{ in_array($jurusan->id, $student->jurusans->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $jurusan->name }}</option>
    @endforeach
</select>

<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>

<script>
    new MultiSelectTag('jurusan')  // id
</script>
<br>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-default">Cancel</a>
    </div>

</form>

@endsection
