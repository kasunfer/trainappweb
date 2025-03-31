<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    public function seats() {
        return $this->hasMany(TrainSeat::class);
    }
    public function schedules() {
        return $this->hasMany(TrainSchedule::class);
    }
}
