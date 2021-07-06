<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeSite($q, $center_id)
    {
        return $q->where('center_id', $center_id);
    }
    
    public function scopeDate($q, $date)
    {
        return $q->where('date', $date);
    }
    
    public function scopeNotExpired($q, $time = null)
    {
        return $q->whereRaw("concat(date, ' ', start) > ?", [ $time ? $time : now() ]);
    }

    public function cacheKey()
    {
        return $this->center_id.':'.$this->date;
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function getStartAttribute($v)
    {
        return substr($v,0,5);
    }

    public function scopeVacant($q)
    {
        return $q->has('active_bookings', '<', DB::raw('allocations'));
    }

    public function active_bookings()
    {
        return $this->bookings()->where('status', '<>', 'rejected');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
   
    public function getEndAttribute($v)
    {
        return substr($v,0,5);
    }

    public function getFormattedDateAttribute($v)
    {
        return Carbon::parse($v)->format('l, d M Y');
    }
}


