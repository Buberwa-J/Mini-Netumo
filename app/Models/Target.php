<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(StatusLog::class)->orderBy('created_at', 'desc');
    }

    public function latestStatusLog()
    {
        return $this->hasOne(StatusLog::class)->latestOfMany();
    }

    public function sslChecks()
    {
        return $this->hasMany(SslCheck::class)->orderBy('created_at', 'desc');
    }

    public function latestSslCheck()
    {
        return $this->hasOne(SslCheck::class)->latestOfMany();
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class)->orderBy('created_at', 'desc');
    }

    /**
     * Accessor for the last checked timestamp.
     *
     * @return \Carbon\Carbon|null
     */
    public function getLastCheckedAtAttribute()
    {
        return $this->latestStatusLog?->created_at;
    }


    public function getOverallStatusAttribute(): string
    {
        if ($this->alerts()->whereNull('resolved_at')->exists()) {
            return 'alert'; // Or specific alert type
        }
        if ($this->latestStatusLog) {
            if ($this->latestStatusLog->status_code >= 200 && $this->latestStatusLog->status_code < 400) {
                return 'up';
            }
            return 'down'; // Or 'issue' based on status code
        }
        return 'pending';
    }
}
