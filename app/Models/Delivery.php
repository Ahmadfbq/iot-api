<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'delivery_name',
        'gate_status',
        'package_status',
        'pin',
    ];

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}