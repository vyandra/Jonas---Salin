<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Student;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class DashboardController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function karyawan() {
        $files = File::all();
        $studentList = Student::all(); // Assuming you have a Student model
        $jurusans = Jurusan::all();
    
        return view('admin.master_karyawan', compact('files', 'studentList', 'jurusans'));
    }


    public function showFileDetail($id)
    {
        $file = File::findOrFail($id);
        $fileUrl = asset('storage/files/' . $file->filename);
        $filename = $file->filename;
    
        // Check the file extension to determine the conversion method
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
    
        if ($extension === 'docx') {
            // Convert DOCX to PDF
            $docxFilePath = storage_path('app/public/files/' . $filename);
            $pdfFilePath = storage_path('app/public/files/' . pathinfo($filename, PATHINFO_FILENAME) . '.pdf');
            $conversionSuccess = $this->convertDocxToPdf($docxFilePath, $pdfFilePath);
    
            if ($conversionSuccess) {
                $fileUrl = asset('storage/files/' . pathinfo($filename, PATHINFO_FILENAME) . '.pdf');
            } else {
                // Handle the conversion error here
                return response()->json(['error' => 'Conversion failed'], 500);
            }
        }
    
        return view('admin.file_detail', compact('fileUrl', 'filename'));
    }


    public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:doc,docx,pdf|max:2048', // Validate file type and size
    ]);

    $file = $request->file('file');
    $fileName = time() . '_' . $file->getClientOriginalName();

    // Store the file in the 'public/files' directory
    Storage::putFileAs('public/files', $file, $fileName);

    File::create([
        'filename' => $fileName,
    ]);

    return redirect()->back()->with('success', 'File uploaded successfully.');
}

public function editFile($id)
{
    $file = File::findOrFail($id);
    $studentList = Student::all();
    $jurusans = Jurusan::all();
    $selectedJurusans = $file->jurusans->pluck('id')->toArray();

    return view('admin.edit_file', compact('file', 'studentList', 'jurusans', 'selectedJurusans'));
}

public function updateFile(Request $request, $id)
{
    $file = File::findOrFail($id);

    $validatedData = $request->validate([
        'nama' => 'nullable|string',
        'tempat' => 'nullable|string',
        'tgl_lahir' => 'nullable|string',
        'posisi' => 'nullable|string',
        'tgl_join' => 'nullable|date',
        'tgl_keluar' => 'nullable|date',
        'alasan_keluar' => 'nullable|string',
        'new_file' => 'nullable|mimes:doc,docx,pdf|max:2048', // Validate new file type and size
        'student_id' => 'nullable|exists:students,id', // Validate student_id exists in the students table
        'jurusan' => 'array', // Validate jurusan as an array
        'jurusan.*' => ['nullable', Rule::exists('jurusans', 'id')], // Validate each jurusan in the array
    ]);

    // Update file details
    $file->update([
        'nama' => $request->input('nama', $file->nama),    
        'tempat' => $request->input('tempat', $file->tempat),
        'tgl_lahir' => $request->input('tgl_lahir', $file->tgl_lahir),
        'posisi' => $request->input('posisi', $file->posisi),
        'tgl_join' => $request->input('tgl_join', $file->tgl_join),
        'tgl_keluar' => $request->input('tgl_keluar', $file->tgl_keluar),
        'alasan_keluar' => $request->input('alasan_keluar', $file->alasan_keluar),
        $file->student_id = $validatedData['student_id'],
    ]);

    // Handle new file upload (if provided)
    if ($request->hasFile('new_file')) {
        // Delete the old file from storage
        Storage::delete('public/files/' . $file->filename);

        // Store the new file in the 'public/files' directory
        $newFile = $request->file('new_file');
        $newFileName = time() . '_' . $newFile->getClientOriginalName();
        Storage::putFileAs('public/files', $newFile, $newFileName);

        // Update the database record with the new filename
        $file->update(['filename' => $newFileName]);
    }

    // Update the jurusan relationship if jurusan is provided
    $file->jurusans()->sync($request->jurusan);

    return redirect()->route('admin.master_karyawan')->with('success', 'File updated successfully.');
}




public function deleteFile($id)
{
    $file = File::findOrFail($id);

    // Soft delete the file
    $file->delete();

    return redirect()->back()->with('success', 'File deleted successfully.');
}


public function showPdfViewer(Request $request, $id)
{
    // Retrieve the $file from the database using the $id
    $file = File::findOrFail($id);

    // Get the file URL and filename
    $fileUrl = asset('storage/files/' . $file->filename);
    $filename = $file->filename;

    // Check the file extension to determine the conversion method
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    if ($extension === 'docx') {
        // Convert DOCX to PDF
        $docxFilePath = storage_path('app/public/files/' . $filename);
        $pdfFilePath = storage_path('app/public/files/' . pathinfo($filename, PATHINFO_FILENAME) . '.pdf');
        $conversionSuccess = $this->convertDocxToPdf($docxFilePath, $pdfFilePath);

        if ($conversionSuccess) {
            $fileUrl = asset('storage/files/' . pathinfo($filename, PATHINFO_FILENAME) . '.pdf');
        } else {
            // Handle the conversion error here
            return response()->json(['error' => 'Conversion failed'], 500);
        }
    }

    // Remove the "public/files/" prefix from $fileUrl
    $fileUrl = str_replace('public/files/', '', $fileUrl);

    // Pass the $fileUrl and $filename variables to the view
    return view ('admin.pdf-viewer', compact('fileUrl', 'filename'));
}   

public function createEmployeeForm()
{
    $jurusans = Jurusan::all();
    return view('admin.create_employee_form', ['jurusans' => $jurusans]);
}

public function storeEmployee(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'tempat' => 'required|string|max:255',
        'tgl_lahir' => 'required|date',
        'posisi' => 'required|string|max:255',
        'tgl_join' => 'required|date',
        'student_id' => 'required|exists:students,id',
        'filename' => 'required|mimes:doc,docx,pdf|max:2048',
        'jurusan' => 'array', 
        'jurusan.*' => ['required', Rule::exists('jurusans', 'id')],
    ]);

    
    if ($request->hasFile('filename')) {
        $file = $request->file('filename');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/files', $fileName);
    } else {
       
        $fileName = null;
    }

    
    $file = new File();
    $file->nama = $validatedData['nama'];
    $file->tempat = $validatedData['tempat'];
    $file->tgl_lahir = $validatedData['tgl_lahir'];
    $file->posisi = $validatedData['posisi'];
    $file->tgl_join = $validatedData['tgl_join'];
    $file->student_id = $validatedData['student_id'];
    $file->alasan_keluar = $request->input('alasan_keluar');
    $file->filename = $fileName; // Set the filename
    $file->save();

    // Associate selected jurusan(s) with the karyawan
    $file->jurusans()->attach($validatedData['jurusan']);

    return redirect()->route('admin.master_karyawan')->with('success', 'Employee has been added successfully.');
}

public function restoreAll()
    {
        File::onlyTrashed()->restore();
    
        return redirect()->route('admin.master_karyawan')->with('success', 'All files restored successfully.');
    }

    public function showStudentDetails($id)
    {
        $student = Student::with('jurusans')->find($id);
    
        return view('admin.student-details', ['student' => $student]);
    }
}
