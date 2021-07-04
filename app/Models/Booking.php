<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function scopeIdentifier($q, $identifier)
    {
        return $q->where('identifier', $identifier);
    }
    
    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

}
