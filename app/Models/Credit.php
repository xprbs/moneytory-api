<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $table = 'credits';
    protected $fillable = [
        'email',
        'jumlah',
        'kategori',
        'keterangan'
    ];
}
