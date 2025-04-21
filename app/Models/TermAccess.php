<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'term_number',
        'is_active',
        'start_date',
        'end_date',
        'message'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function isAccessible()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($this->start_date && $now < $this->start_date) {
            return false;
        }

        if ($this->end_date && $now > $this->end_date) {
            return false;
        }

        return true;
    }
}
