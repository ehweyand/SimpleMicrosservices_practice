<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'event_date',
    ];

    protected $table = 'events';

    public function users()
    {
        return $this->belongsToMany(User::class, 'subscriptions')->withPivot('attendance')->withTimestamps();
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
