<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainStop extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = ['train_schedule_id', 'station_id', 'arrival_time', 'departure_time'];

    public function schedule()
    {
        return $this->belongsTo(TrainSchedule::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
    
    public function scopeGetTicketPrice($query, $train_schedule_id, $from_station_id, $to_station_id)
{
    $fromStop = $query->where('train_schedule_id', $train_schedule_id)
        ->where('station_id', $from_station_id)
        ->first();

    $toStop = $query->where('train_schedule_id', $train_schedule_id)
        ->where('station_id', $to_station_id)
        ->first();

    if (!$fromStop || !$toStop || $fromStop->id >= $toStop->id) {
        return null;
    }

    return $query->where('train_schedule_id', $train_schedule_id)
        ->whereBetween('id', [$fromStop->id, $toStop->id])
        ->sum('fare');
}

}
