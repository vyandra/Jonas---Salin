@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">





<div class="row">

    <a href="dashboard-add"><button style="color: #f5f5f5; background-color: #F88105; width:100px; height: 50px; border: none; border-radius: 10px;">Add List</button></a>
</div>
<br>
<table class="table table-bordered table-dark">
  <thead>
    <tr>
      <th scope="col"  style="text-align: center;">ID</th>
      <th scope="col"  style="text-align: center;">Sekolah/Universitas</th>
     
      <th scope="col"  style="text-align: center;">Alamat</th>
      <th scope="col" style="width: 340px; text-align: center;">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($studentList as $student )

    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$student->sekolah}}</td>
        <td>{{$student->alamat}}</td>

        <td>
        <button style="color: #f5f5f5; background-color: #F88105; width:100px; height: 50px; border: none; border-radius: 10px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#studentDetailModal-{{ $student->id }}">Details</button>
        <a href="{{ route('students.edit', $student->id) }}"><button style="color: #f5f5f5; background-color: #027a6a; width:100px; height: 50px; border: none; border-radius: 10px;">Edit</button></a>
        <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?');">
            @csrf
            @method('DELETE')
            <button style="color: #f5f5f5; background-color: #B0160c; width:100px; height: 50px; border: none; border-radius: 10px; margin-top: 5px;">Delete</button>
        </form>
        </td>
      </tr>

    <!-- Modal for Student Details -->
<div class="modal fade" id="studentDetailModal-{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="studentDetailModalLabel-{{ $student->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="studentDetailModalLabel-{{ $student->id }}">Detail Siswa</h5>
            </div>
            <div class="modal-body">
                <div class="pl-3 pr-3">
                    @if($student)
                    <p><strong>Sekolah/Universitas:</strong> {{ $student->sekolah }}</p>
                    <p><strong>Jurusan:</strong> {{ implode(', ', $student->jurusans->pluck('name')->toArray()) }}</p>
                    @else
                    <p>Data siswa tidak ditemukan.</p>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

    @endforeach
</table>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="{{ route('admin.restore') }}" class="restore-icon">
                    <i class="fas fa-trash-restore" style="color: #252525;"></i>
                    <span style="color: #252525; text-decoration: none;">Restore Data</span>
                </a>
            </div>
        </div>
    </div>
</footer>

@endsection