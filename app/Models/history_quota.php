<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class history_quota extends Model
{
    protected $fillable = ['schedule_id', 'action', 'amount', 'remaining_quota'];

    public function schedule()
    {
        return $this->belongsTo(schedule_dokter::class, 'schedule_id');
    }
}
