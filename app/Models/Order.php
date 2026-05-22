<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'order_date',
        'units',
        'amount',
        'product_id'
    ];


    /**
     * Relacion un orden pertence a un producto
     * @return BelongsTo
     */
    public function product () 
    {
        return $this->belongsTo(Product::class);
    }
}
