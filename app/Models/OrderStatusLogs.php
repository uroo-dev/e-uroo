<?php

namespace App\Models;

use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Schema\Blueprint;

class OrderStatusLogs extends Model
{
    protected $table = 'order_status_log';

    protected $fillable = [
        'order_id',
        'status',
        'note',
        'change_by',
    ];

    public function order():BelongsTo
    {
        return $this->belongsTo(Orders::class);
    }

    public function change_by():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
