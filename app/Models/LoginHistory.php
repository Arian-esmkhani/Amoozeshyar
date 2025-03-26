<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'login_history';

    protected $fillable = [
        'user_id',
        'login_time',
        'logout_at',
        'ip_address',
        'user_agent',
        'status',
        'failure_reason',
        'is_active',
        'last_login_at'
    ];

    protected $casts = [
        'login_time' => 'datetime',
        'logout_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(UserBase::class, 'user_id');
    }
}
