<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'iso_code'];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
