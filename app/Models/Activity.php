<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['contact_id', 'type', 'description', 'occurred_at'];

    protected $casts = ['occurred_at' => 'datetime'];

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
}
