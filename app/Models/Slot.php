<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeCenter($q, $center_id)
    {
        return $q->where('center_id', $center_id);
    }
    
    public function scopeDate($q, $date)
    {
        return $q->where('date', $date);
    }

    public function cacheKey()
    {
        return $this->center_id.':'.$this->date;
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }
}


