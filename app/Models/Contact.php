<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['user_id', 'phone', 'company', 'position', 'notes'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sales() {
        return $this->hasMany(Sale::class);
    }

    public function activities() {
        return $this->hasMany(Activity::class)->orderByDesc('occurred_at');
    }
}
