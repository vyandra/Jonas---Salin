    @extends('layouts.admin')

    @section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">

<script>
    $('#pendidikanModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var pendidikan = button.data('pendidikan'); // Extract pendidikan from data-pendidikan attribute
        
        $('#namaSekolah').text(pendidikan);
    });

    $(document).ready(function () {
        // Listen for changes to the "sekolah" dropdown
        $('#sekolah').on('change', function () {
            // Get the selected value
            var selectedSekolah = $(this).val();
            
            // Set the selected value as the "student_id"
            $('#student_id').val(selectedSekolah);
        });
    });

 
</script>
   
<style>
@media (max-width: 767px) {
    .custom-table table tbody tr {
        display: block;
        margin-bottom: 20px;
    }
    
    .custom-table table tbody tr td {
        display: flex;
        flex-direction: column;
        text-align: center;
    }
    
    .custom-table table thead {
        display: none;
    }
    
    .custom-table table td:before {
        content: attr(data-label);
        font-weight: bold;
    }
}

.custom-select {
    position: relative;
    width: 200px; /* Adjust the width as needed */
    cursor: pointer;
}

.selected-option {
    display: block;
    padding: 10px;
    background-color: #ffffff;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.options {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: none;
    position: absolute;
    width: 100%;
    background-color: #ffffff;
    border: 1px solid #ccc;
    border-top: none;
    border-radius: 0 0 5px 5px;
}

.options li {
    padding: 10px;
    cursor: pointer;
    border-top: 1px solid #ccc;
}

.options li:first-child {
    border-top: none;
}

.selected {
    background-color: #1E4DBA; /* Customize the selected option's background color */
    color: #ffffff; /* Customize the selected option's text color */
}
</style>

    <button class="btn btn-dark" data-toggle="modal" data-target="#createEmployeeModal">Add New Karyawan</button>

    <div class="modal fade" id="createEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEmployeeModalLabel">Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for creating a new employee -->
                <form action="{{ route('dashboard.storeEmployee') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="nama">Nama:</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
               
                        <div class="col-md-6">
        <label for="student_id" class="col-form-label" style="margin-top: -5px; color: #252525;">Sekolah/Universitas:</label>
        <select name="student_id" id="student_id" class="form-control" style="margin-top: -12px; color: #252525;">
        <option value="" style="color: #252525;">Select Sekolah</option> 
    @foreach ($studentList as $student)
        <option value="{{ $student->id }}" style="color:#252525;">{{ $student->sekolah }}</option>
    @endforeach
</select> 
    </div>
<script> $(document).ready(function() {
    $('#sekolah').select2();
});</script>

                    </div>
                    <div class="form-group row">
                    <div class="col-md-6">
        <label for="jurusan" class="col-form-label" style="margin-top: -6px;">Jurusan:</label>
        
        <select multiple name="jurusan[]" id="jurusan" class="form-control">
            @foreach ($jurusans as $jurusan)
                <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
            @endforeach
        </select>
    </div>
                        <div class="col-md-6">
                            <label for="tempat">Tempat Lahir:</label>
                            <input type="text" name="tempat" id="tempat" class="form-control" required>
                        </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-md-6">
                            <label for="tgl_lahir">Tgl Lahir:</label>
                            <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="posisi">Posisi:</label>
                            <input type="text" name="posisi" id="posisi" class="form-control" required>
                        </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-md-6">
                            <label for="tgl_join">Tanggal Join:</label>
                            <input type="date" name="tgl_join" id="tgl_join" class="form-control" required>
                        </div>
                        </div>
                    <div class="form-group">
                        <label for="filename">Upload CV (doc,docx, pdf only.)</label>
                        <input type="file" name="filename" id="filename" accept=".doc, .docx, .pdf" class="form-control-file" required>
                    </div>
                    <!-- Add more form fields for other employee information -->
                
            </div>

            <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>

<script>
    new MultiSelectTag('jurusan')  // id
</script>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="pendidikanModal" tabindex="-1" role="dialog" aria-labelledby="pendidikanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pendidikanModalLabel">Pendidikan (Sekolah) & Jurusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            @foreach ($files as $file)
    <strong>Nama Sekolah:</strong> <p>{{ $file->students }}</p>
    <strong>Jurusan:</strong> <p>{{ $file->file_jurusan }}</p>
@endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<br><br>

    <div class="table-responsive custom-table">
    <table class="table table-bordered table-dark">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Sekolah/Universitas</th>
                <th>Tempat Lahir</th>
                <th>Tgl Lahir</th>
                <th>Posisi</th>
                <th>Tgl Join</th>
                <th>Tgl Keluar</th>
                <th>Alasan Keluar</th>
                <th scope="col">CV</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$file->nama}}</td>
                <td>{{ $file->student->sekolah ?? 'No data' }}<br>
                    <p>Jurusan: {{ implode(', ', $file->jurusans->pluck('name')->toArray()) }}</p>
                </td>
                <td>{{$file->tempat}}</td>
                <td>{{$file->tgl_lahir}}</td>
                <td>{{$file->posisi}}</td>
                <td>{{$file->tgl_join}}</td>
                <td>{{$file->tgl_keluar}}</td>
                <td>{{$file->alasan_keluar}}</td>
                <td>
                    <a href="{{ route('pdf-viewer', $file->id) }}" style="text-decoration:none; color: #f5f5f5;"> <button type="submit" style="color: #f5f5f5; background-color: #F88105; width:100px; height: 30px; border: none; border-radius: 10px;">Show CV</button></a>
                </td>
                <div class="d-flex flex-column">
                <td>
                    <a href="{{ route('dashboard.editFile', $file->id) }}">
                        <button style="color: #f5f5f5; background-color: #027a6a; width:100px; height: 50px; border: none; border-radius: 10px;">Edit</button>
                    </a>
                    <p style="margin-bottom: 5px;"></p>
                    <form action="{{ route('dashboard.deleteFile', $file->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: #f5f5f5; background-color: #8A0000; width:100px; height: 50px; border: none; border-radius: 10px;">Delete</button>
                    </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="{{ route('admin.restoreAll') }}" class="restore-icon">
                    <i class="fas fa-trash-restore" style="color: #252525;"></i>
                    <span style="color: #252525; text-decoration: none;">Restore Data</span>
                </a>
            </div>
        </div>
    </div>
</footer>


    @endsection
