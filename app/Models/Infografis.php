<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Infografis extends Model
{
    use HasFactory;

    protected $table = 'infografis';

    protected $fillable = [
        'uuid',
        'name',
        'file',
        'type',
        'is_active',
        'published_at',
    ];

    protected static function booted(): void
    {
        static::creating(fn ($model) => $model->uuid ??= Str::uuid());
    }

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
