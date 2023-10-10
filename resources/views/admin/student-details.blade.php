@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Student Details</h1>
    @if ($student)
        <p><strong>Sekolah/Universitas:</strong> {{ $student->sekolah }}</p>
        <p><strong>Jurusan:</strong> {{ implode(', ', $student->jurusans->pluck('name')->toArray()) }}</p>
    @else
        <p>Data siswa tidak ditemukan.</p>
    @endif
</div>
@endsection