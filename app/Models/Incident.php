<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function peoples() {
        return $this->hasMany(People::class);
    }
}
