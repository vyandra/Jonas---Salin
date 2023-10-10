<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table ='jurusans';
    protected $fillable = ['name'];

    public function students()
{
    return $this->belongsToMany(Student::class, 'student_jurusan');
}

public function files()
{
    return $this->belongsToMany(File::class, 'file_jurusan');
}
}
