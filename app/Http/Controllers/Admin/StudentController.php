<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jurusan;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;


class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Student::all();
        return view('admin.dashboard', ['studentList' => $student]);
    }


public function create()
{
    $jurusans = Jurusan::all();
    return view('admin.add', ['jurusans' => $jurusans]);
}

public function store(Request $request)
{
    // Buat siswa terlebih dahulu
    $student = Student::create($request->all());

    // Sinkronkan jurusan yang dipilih dengan siswa yang baru dibuat
    $student->jurusans()->sync($request->jurusan);

    return redirect()->route('admin.dashboard')->with('success', 'Siswa berhasil ditambahkan!');
}

public function edit(Student $student)
{
    $jurusans = Jurusan::all();
    return view('admin.edit', ['student' => $student, 'jurusans' => $jurusans]);
}

public function update(Request $request, Student $student)
{
    $student->update($request->all());
    $student->jurusans()->sync($request->jurusans);
    return redirect()->route('admin.dashboard')->with('success', 'Siswa berhasil diperbarui!');
}

public function destroy(Student $student)
{
    $student->delete();
    return redirect()->route('admin.dashboard')->with('success', 'Siswa berhasil dihapus!');
}

public function showStudentDetails($id)
{
    $student = Student::with('jurusans')->find($id);

    return view('admin.student-details', ['student' => $student]);
}

public function restore()
    {
        Student::onlyTrashed()->restore();
    
        return redirect()->route('admin.dashboard')->with('success', 'All files restored successfully.');
    }

}
