<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserData extends Model
{
    use SoftDeletes;

    protected $table = 'users_data';

    protected $fillable = [
        'user_id',
        'name',
        'father_name',
        'national_code',
        'birth_date',
        'gender',
        'religion',
        'denomination',
        'health_status',
        'address',
        'phone_number',
        'emergency_contact'
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(UserBase::class, 'user_id');
    }
}
