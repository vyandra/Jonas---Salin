<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];


    protected $fillable = [ 'filename', 'nama', 'pendidikan', 'tempat', 'tgl_lahir', 'posisi', 'tgl_join', 'tgl_keluar', 'alasan_keluar'];

    public function deleteFile()
    {
        // Delete the file from storage
        Storage::delete('public/files/' . $this->filename);
    
        // Delete the record from the database
        $this->delete();
    }
    
   
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function jurusans()
    {
        return $this->belongsToMany(Jurusan::class, 'file_jurusan', 'file_id', 'jurusan_id');
    }
}
