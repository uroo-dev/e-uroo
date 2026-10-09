<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal',
        'shoping_cost',
        'discount_amount',
        'grand_total',
        'payment_method',
        'payment status',
        'recipient_name',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order_items():HasMany
    {
        return $this->hasMany(OrderItems::class);
    }

    public function payment():HasOne
    {
        return $this->hasOne(Payments::class);
    }

    public function order_status():HasMany
    {
        return $this->hasMany(OrderStatusLogs::class);
    }
}
