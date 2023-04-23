<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'events_id',
        'attendance',
    ];

    protected $table = 'subscriptions';

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id', 'id');
    }

}
