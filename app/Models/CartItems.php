<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItems extends Model
{
    protected $table = 'casrt_items';
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    public function carts():BelongsTo
    {
        return $this->belongsTo(Carts::class);
    }
}
