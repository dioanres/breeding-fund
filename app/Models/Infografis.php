<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Infografis extends Model
{
    use HasFactory;

    protected $table = 'infografis';

    protected $fillable = [
        'name',
        'file',
        'type',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
