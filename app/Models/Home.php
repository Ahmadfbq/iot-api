<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'gate_status',
        'package_status',
        'pin',
    ];

    // I might not need to cast this
    protected function casts(): array
    {
        return [
            'gate_status' => 'string',
            'package_status' => 'string',
            'pin' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}