<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
        protected $table = 'product';
        protected $fillable = [
            'category_id',
            'name',
            'slug',
            'sku',
            'description',
            'price',
            'stock',
            'weight',
            'main_image',
            'isactive',
        ];

        public function category():BelongsTo
        {
            return $this->belongsTo(Categories::class);
        }

        public function product_image():HasMany
        {
            return $this->hasMany(ProductImage::class);
        }
}
