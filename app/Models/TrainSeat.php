<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainSeat extends Model
{
    use HasFactory;
    protected $fillable = ['train_schedule_id', 'seat_number', 'is_booked'];

    public function trainSchedule()
    {
        return $this->belongsTo(TrainSchedule::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'seat_id');
    }
}
