<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = [
        'namamapel',
        'class_level',
        'jurusan',
        'questions_data',
        'tahun_ajar'
    ];
    protected $casts = [
        'questions_data' => 'array',
    ];
}
