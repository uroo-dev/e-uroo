<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Addres extends Model
{
    protected $table = 'addres' ;
    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone',
        'province',
        'city',
        'district',
        'postal_code',
        'full_address',
    ];

    public function users():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
    