<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule_dokter extends Model
{
    use HasFactory;
    protected $table = 'schedules_dokter';
    protected $fillable = [
        'doctor_id',
        'start',
        'end',
        'quota',
        'total_quota',
        'hari',
        'userinput',
        'userinputid',
    ];

    // ScheduleDokter.php
    public function doctor()
    {
        return $this->belongsTo(doctor::class, 'id', 'doctor_id');
    }

    public function quotaHistories()
    {
        return $this->hasMany(history_quota::class, 'schedule_id');
    }


}
