<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }
}
