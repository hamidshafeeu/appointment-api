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
    
    public function scopeNotRejected($q)
    {
        return $q->where('status', '<>', 'rejected');
    }
    
    public function scopeSlot($q, $slot_id)
    {
        return $q->where('slot_id', $slot_id);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function approve()
    {
        return $this->update(['status' => 'approved']);
    }
    
    public function reject()
    {
        return $this->update(['status' => 'rejected']);
    }

}
