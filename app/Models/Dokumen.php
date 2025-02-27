<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumen extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
