<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['contact_id', 'title', 'amount', 'status', 'expected_close', 'notes'];

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
}
