<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = [
        'user_id',
        'namamapel',
        'class_level',
        'jurusan',
        'questions_data',
        'tahun_ajar'
    ];
    protected $casts = [
        'questions_data' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
