<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SslCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_id',
        'is_valid',
        'expires_at',
        'days_to_expiry',
        'issued_by',
        'error_message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_valid' => 'boolean',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }
}
