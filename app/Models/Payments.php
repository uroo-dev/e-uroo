<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payments extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'method',
        'amount',
        'status',
        'veryfied_by',
    ];

    public function order():BelongsTo
    {
        return $this->belongsTo(Orders::class);
    }

    public function verify():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
