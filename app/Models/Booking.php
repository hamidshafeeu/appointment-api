<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $appends = ['is_cancellable'];
    protected $guarded = [];
    
    public function scopeIdentifier($q, $identifier)
    {
        return $q->where('identifier', $identifier);
    }
    
    public function scopePhone($q, $phone)
    {
        return $q->where('phone', $phone);
    }
    
    public function scopehash($q, $hash)
    {
        return $q->where('hash', $hash);
    }
    
    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    public function pending()
    {
        return $this->status == 'pending';
    }
    
    public function rejected()
    {
        return $this->status == 'rejected';
    }
    
    public function notRejected()
    {
        return !$this->rejected();
    }
    
    public function scopeApproved($q)
    {
        return $q->where('status', 'approved');
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

    public function approved()
    {
        return $this->status == 'approved';
    }

    public function approve()
    {
        return $this->update(['status' => 'approved']);
    }

    public function reject()
    {
        return $this->update(['status' => 'rejected']);
    }

    public function getIsCancellableAttribute()
    {
        return $this->status != 'rejected'; // $this->status == 'pending' && Carbon::parse($this->slot->date.' '.$this->slot->start)->gt(now());
    }

}
