<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['phone_number', 'train_id', 'schedule_id', 'seat_id', 'from_station_id', 'to_station_id', 'status'];

    public function fromStation() {
        return $this->belongsTo(Station::class, 'from_station_id');
    }

    public function toStation() {
        return $this->belongsTo(Station::class, 'to_station_id');
    }
    public function trainSchedule() {
        return $this->belongsTo(TrainSchedule::class, 'schedule_id');
    }
    public function seat() {
        return $this->belongsTo(TrainSeat::class, 'seat_id');
    }
}
